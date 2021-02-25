<?php

namespace App\Services\Payment;

use Exception;

class PaymentTypeResolverService
{
    public function resolve(array $responseData): string
    {
        $available_payment_types = config('payment.types');

        foreach (array_keys($available_payment_types) as $type_name) {
            $methodName = 'isResponseDataFrom' . ucfirst($type_name);

            if(!method_exists($this, $methodName)){
                throw new Exception("Payment type '$type_name' doesnt have resolver method.");
            }

            if ($this->$methodName($responseData)) {
                $payment_type = $type_name;
            }
        }

        if (!isset($payment_type) || !in_array($payment_type, $available_payment_types)) {
            throw new Exception("Payment type '$payment_type' is not available.");
        }

        return $payment_type;
    }

    public function isResponseDataFromApple(array $responseData): bool
    {
        $apple_status_dictonary = config('payment.statuses_dictonary.apple');

        return isset($responseData['notification_type']) && in_array($responseData['notification_type'], $apple_status_dictonary);
    }
}
