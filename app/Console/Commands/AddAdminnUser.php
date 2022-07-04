<?php

namespace App\Console\Commands;


use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddAdminnUser extends Command
{
    protected $signature = 'sas:create-admin';

    protected $description = 'Create a admin user. ex: php sas:create-admin';

    public function handle()
    {
        $name = $this->ask('name');
        $email = $this->ask('email address');

        if (User::query()->where('email', '=', trim($email))->exists()) {
            $this->error('Email address already exists');
        }

        $password = $this->secret('password');
        
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => trim($password)
        ]);
        $user->assignRole('Administrator');
        $this->info('success');

        return 0;
    }
}
