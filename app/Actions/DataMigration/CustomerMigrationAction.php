<?php

namespace App\Actions\DataMigration;


use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;
use App\Models\ErpUserDetail;
use App\Models\Factory;
use App\Models\MySas\ClientAddressDetail;
use App\Models\MySas\ClientContactDetail;
use App\Models\MySas\User;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class CustomerMigrationAction
{
    public function execute()
    {
        $output = new ConsoleOutput();

        $mysasCustomers = \App\Models\MySas\Client::with('addresses', 'contacts')->get();
        $progress = new ProgressBar($output, \App\Models\MySas\Client::count());
        $progress->start();

        $sales_agent_role = Role::where('name', 'Sales Agent')->first();
        if (!$sales_agent_role) {
            $sales_agent_role = Role::create([
                'name' => 'Sales Agent'
            ]);
        }


        $customer_service_agent_role = Role::where('name', 'Customer Service Agent')->first();
        if (!$customer_service_agent_role) {
            $customer_service_agent_role = Role::create([
                'name' => 'Customer Service Agent'
            ]);
        }

        $total_records_migrated = DB::transaction(function () use (
            $mysasCustomers,
            $progress,
            $sales_agent_role,
            $customer_service_agent_role
        ) {
            $total_records_migrated = 0;
            foreach ($mysasCustomers as $mysasCustomer) {

                if ($mysasCustomer->email == '') {
                    continue;
                }

                $cs_person_id = null;
                $sales_person_id = null;

                $my_sas_cs_person = User::with('factories')->find($mysasCustomer->cs_person_id);
                $my_sas_cs_person_factories = [];
                $csPersonfactoryIds = [];

                if ($my_sas_cs_person) {
                    foreach ($my_sas_cs_person->factories as $factory) {
                        if (!in_array($factory->name, $my_sas_cs_person_factories)) {
                            array_push($my_sas_cs_person_factories, $factory->name);
                        }
                    }

                    $csPersonfactoryIds = Factory::whereIn('name', $my_sas_cs_person_factories)->pluck('id')->toArray();
                }

                if ($my_sas_cs_person) {
                    $cs_person = \App\Models\User::where('email', $my_sas_cs_person->email)->first();
                    if (!$cs_person) {
                        $name = $my_sas_cs_person->firstname;
                        if ($my_sas_cs_person->lastname != "") {
                            $name = $name . " " . $my_sas_cs_person->lastname;
                        }

                        $cs_person = \App\Models\User::create([
                            'name' => $name,
                            'email' => $my_sas_cs_person->email,
                            'password' => $my_sas_cs_person->email . 'password'
                        ]);

                        $cs_person->assignRole($customer_service_agent_role);
                        $cs_person->factories()->sync($csPersonfactoryIds);

                        $default_factory = null;
                        if (count($csPersonfactoryIds) > 0) {
                            $default_factory = $csPersonfactoryIds[0];
                        }

                        ErpUserDetail::create([
                            'user_id' => $cs_person->id,
                            'contact_number' => $my_sas_cs_person->phone_number,
                            'factory_id' => $default_factory,
                        ]);

                        $cs_person_id = $cs_person->id;
                    }
                }


                $my_sas_sales_person = User::with('factories')->find($mysasCustomer->sales_person_id);

                $my_sas_sales_person_factories = [];

                if ($my_sas_sales_person) {
                    foreach ($my_sas_sales_person->factories as $factory) {
                        if (!in_array($factory->name, $my_sas_sales_person_factories)) {
                            array_push($my_sas_sales_person_factories, $factory->name);
                        }
                    }

                    $salesPersonFactoryIds = Factory::whereIn('name',
                        $my_sas_sales_person_factories)->pluck('id')->toArray();
                }

                if ($my_sas_sales_person) {
                    $sales_person = \App\Models\User::where('email', $my_sas_sales_person->email)->first();
                    if (!$sales_person) {
                        $name = $my_sas_sales_person->firstname;
                        if ($my_sas_sales_person->lastname != "") {
                            $name = $name . " " . $my_sas_sales_person->lastname;
                        }

                        $sales_person = \App\Models\User::create([
                            'name' => $name,
                            'email' => $my_sas_sales_person->email,
                            'password' => $my_sas_sales_person->email . 'password'
                        ]);

                        $sales_person->assignRole($sales_agent_role);
                        $sales_person->factories()->sync($salesPersonFactoryIds);

                        $default_factory = null;
                        if (count($salesPersonFactoryIds) > 0) {
                            $default_factory = $salesPersonFactoryIds[0];
                        }

                        ErpUserDetail::create([
                            'user_id' => $sales_person->id,
                            'contact_number' => $my_sas_sales_person->phone_number,
                            'factory_id' => $default_factory,
                        ]);

                        $sales_person_id = $sales_person->id;
                    }
                }


                $customerData = [
                    'name' => $mysasCustomer->company,
                    'email' => $mysasCustomer->email,
                    'description' => $mysasCustomer->biography,
                    'cs_agent_id' => $cs_person_id,
                    'sales_agent_id' => $sales_person_id
                ];

                $customer = Customer::create($customerData);

                $my_sas_client_address_details = ClientAddressDetail::where('client_id', $mysasCustomer->id)
                    ->get();

                foreach ($my_sas_client_address_details as $my_sas_client_address) {

                    if ($my_sas_client_address->state == "") {
                        $my_sas_client_address->state = "New Zealand";
                    }

                    $country = Country::where('name', $my_sas_client_address->state)->first();
                    if (!$country) {
                        $country = Country::create(
                            [
                                'name' => $my_sas_client_address->state,
                                'sort' => substr($my_sas_client_address->state, 0, 2),
                            ]
                        );
                    }

                    $address = [
                        'line_1' => $my_sas_client_address->line1,
                        'line_2' => $my_sas_client_address->line2,
                        'line_3' => null,
                        'city' => $my_sas_client_address->city,
                        'postal_code' => $my_sas_client_address->postal_code,
                        'country_id' => $country->id,
                    ];

                    $savedAddress = Address::query()->create($address);
                    $address_type = $my_sas_client_address->type;
                    if ($address_type == '') {
                        $address_type = 'Primary';
                    }
                    $addressType = [
                        'address_id' => $savedAddress->id,
                        'type' => $address_type
                    ];

                    $customerAddress = new CustomerAddress($addressType);
                    $customer = Customer::query()->find($customer->id);
                    $customer->addresses()->save($customerAddress);
                }


                $my_sas_customer_contact_details = ClientContactDetail::where('client_id', $mysasCustomer->id)
                    ->get();


                foreach ($my_sas_customer_contact_details as $my_sas_customer_contact) {

                    $first_name = $my_sas_customer_contact->first_name;
                    if ($first_name == "") {
                        $first_name = "N/A";
                    }

                    $last_name = $my_sas_customer_contact->last_name;
                    if ($last_name == "") {
                        $last_name = "N/A";
                    }

                    $type = $my_sas_customer_contact->type;
                    if ($type == "") {
                        $type = "Primary";
                    }

                    $phone_number = $my_sas_customer_contact->phone_number;
                    if ($phone_number == '') {
                        $phone_number = '0000000000';
                    }

                    $designation = $my_sas_customer_contact->designation;
                    if ($designation == "") {
                        $designation = "N/A";
                    }

                    $email = $my_sas_customer_contact->email;
                    if ($email == "") {
                        $email = "na@na.com";
                    }

                    CustomerContact::create([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'contact_no' => $phone_number,
                        'designation' => $designation,
                        'type' => $type,
                        'customer_id' => $customer->id,
                    ]);
                }


                $progress->advance();
            }
            return $total_records_migrated;
        });

        $progress->finish();

        return $total_records_migrated;
    }
}
