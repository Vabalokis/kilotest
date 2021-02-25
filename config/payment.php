<?php

return [
    'statuses_dictonary' => [
        'apple' => [
            'INITIAL_BUY'       => 'initial',
            'DID_RENEW'         => 'renewed',
            'DID_FAIL_TO_RENEW' => 'failed_to_renew',
            'CANCEL'            => 'canceled',
        ]
    ],
    'types' => [
        'apple' => App\Services\Payment\ApplePaymentProcessService::class,
    ]
];