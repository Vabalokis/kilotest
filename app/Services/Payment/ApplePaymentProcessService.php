<?php

namespace App\Services\Payment;

use App\Models\Payment;
use App\Services\Payment\PaymentProcessInterface;

class ApplePaymentProcessService implements PaymentProcessInterface
{
    private array $appleResponseStatusDictonary;

    public function __construct()
    {
        $this->appleResponseStatusDictonary = config('payment.statuses_dictonary.apple');
    }

    public function processPaymentResponse(array $responseData): Payment
    {
        $payment = new Payment;

        $payment->user_external_id = $responseData['unified_receipt']['Latest_receipt_info']['original_transaction_id'];
        $payment->product_id       = $responseData['unified_receipt']['Latest_receipt_info']['product_id'];
        $payment->service_name     = 'apple';
        $payment->status           = $this->appleResponseStatusDictonary[$responseData['notification_type']];

        // more payment data?

        $payment->save();

        return $payment;
    }
}
