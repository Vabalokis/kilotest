<?php

namespace App\Listeners;

use App\Events\PaymentResponseRecieved;
use App\Services\User\UserSubscribtionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserSubscribtionStatus
{
    private UserSubscribtionService $userSubscribtion;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserSubscribtionService $userSubscribtion)
    {
        $this->userSubscribtion = $userSubscribtion;
    }

    /**
     * Handle the event.
     *
     * @param  PaymentResponseRecieved  $event
     * @return void
     */
    public function handle(PaymentResponseRecieved $event)
    {
        $payment = $event->payment;

        $this->userSubscribtion->update($payment);
    }
}
