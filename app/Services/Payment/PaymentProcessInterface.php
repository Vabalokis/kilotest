<?php

namespace App\Services\Payment;

interface PaymentProcessInterface
{
    public function processPaymentResponse(array $responseData): Payment;
}
