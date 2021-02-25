<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\Payment;
use App\Models\UserExternalId;

class UserSubscribtionService
{
    public function update(Payment $payment)
    {
        $user = $this->getUser($payment);

        $this->updateProductPermission($user->id, $payment->product_id, $payment->status);
    }

    public function getUser(Payment $payment): User
    {
        $user = User::whereHas('user_external_ids', function ($query) use ($payment) {
            $query->where('id', $payment->user_external_id)->where('service_name', $payment->service_name);
        })->first();

        if (!isset($user)) {
            $user = new User;

            // add more user info?

            $user->save();

            $user_external_id = new UserExternalId;

            $user_external_id->external_id  = $payment->user_external_id;
            $user_external_id->service_name = $payment->service_name;

            $user_external_id->save();
            //need prorper relationships , maybe pivot with user and user external id

            $user->user_external_ids()->attach($user_external_id);
        }

        return $user;
    }

    public function updateProductPermission(int $user_id, int $product_id, string $status)
    {

    }
}
