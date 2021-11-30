<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;
    protected string $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }


    public function build(): UserCreatedMail
    {
        return $this
            ->subject("Welcome to " . config('app.name'))
            ->markdown('emails.user-created', [
                'user' => $this->user,
                'password' => $this->password
            ]);
    }
}
