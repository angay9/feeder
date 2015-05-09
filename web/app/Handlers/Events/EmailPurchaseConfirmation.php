<?php namespace Feeder\Handlers\Events;

use Feeder\Models\User;
use Feeder\Models\Service;
use Feeder\Events\ServiceWasPurchased;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailPurchaseConfirmation {
    
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
     * @param  ServiceWasPurchased  $event
     * @return void
     */
    public function handle(ServiceWasPurchased $event)
    {
        $user = User::findOrFail($event->userId);
        $admin = User::where('role', '=', User::ROLE_ADMIN)->first();
        $this->mailer->send('email.paymentConfirmation', ['service' => Service::findOrFail($event->serviceId)], function ($message) use($user, $admin) {
            $message
            ->from($admin->email)
            ->to($user->email)
            ->cc('angay9@gmail.com')
            ->subject('Payment confirmation');
        });
    }
}