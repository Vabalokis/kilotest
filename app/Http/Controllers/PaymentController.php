<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHistoryItem;
use App\Events\PaymentResponseRecieved;
use App\Services\Payment\PaymentTypeService;
use App\Services\Payment\PaymentProcessInterface;

class PaymentController extends Controller
{
    private PaymentTypeService $paymentType;

    public function __construct(PaymentTypeService $paymentType)
    {
        $this->paymentType = $paymentType;
    }

    public function externalPaymentHook(Request $request): void
    {
        $responseData = json_decode($request->body, true);
        $paymentType  = $this->paymentType->resolve($responseData);

        $factory        = app(PaymentProcessInterface::class);
        $processPayment = $factory->make($paymentType);

        $transactionHistoryItem       = new TransactionHistoryItem;
        $transactionHistoryItem->data = json_encode($responseData);
        $transactionHistoryItem->save();

        $processedPayment = $processPayment->processPaymentResponse($responseData);

        PaymentResponseRecieved::dispatch($processedPayment);
    }
}
