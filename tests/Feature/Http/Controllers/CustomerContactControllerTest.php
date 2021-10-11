<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\File;
use App\Models\User;
use App\Models\CustomerContact;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class CustomerContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes()
    {
        $user = User::factory()->create();
        $uploadedFile = UploadedFile::fake()->image('logo.jpg');
        Storage::fake('public');

        $file = new File;
        $filePath = $uploadedFile->store('uploads', 'public');
        $file->file_path = pathinfo($filePath)['basename'];
        $file->save();

        $customer = Customer::factory()->create(['logo_id' => $file->id]);

        $customerContact = CustomerContact::factory()->create([
            'customer_id' => $customer->id
        ]);

        $this->actingAs($user);
        $this->deleteJson(route('customers.contacts.delete', $customerContact->id))
            ->assertStatus(302);

        $this->assertNull(
            CustomerContact::find($customerContact->id)
        );
    }
}
