<?php namespace Feeder\Handlers\Events;

use Feeder\Models\User;
use Feeder\Models\Service;
use Feeder\Events\UserHasRegistered;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventsHandler {
    
    /**
     * Mailer
     * 
     * @var Mailer
     */
    protected $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  UserHasRegistered  $event
     * @return void
     */
    public function handle(UserHasRegistered $event)
    {
        $user = $event->user;
        $admin = User::where('role', '=', User::ROLE_ADMIN)->first();
        $this->mailer->send('email.userRegistrationWelcome', ['user' => $user], function ($message) use ($user, $admin) {
            $message
            ->from($admin->email)
            ->to($user->email)
            ->cc('angay9@gmail.com')
            ->subject('Registration');
        });

        $this->mailer->send('email.userRegistration', ['user' => $user], function ($message) use ($user, $admin) {
            $message
            ->from('angay9@gmail.com')
            ->to($admin->email)
            ->cc('angay9@gmail.com')
            ->subject('Registration');
        });
    }
}