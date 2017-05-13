<?php
return [
    'uploadUrl' => 'system-path/api/web/upload/',

    'pagSeguro' => [
        'environment' => 'sandbox', // TODO: Change to 'production' when finished.
        'email' => 'igorabrandao@gmail.br',  // TODO: Change to client's email
        'token' => '4D60DCAC0AB64DC983F65BD68801ED80', // TODO: Change to client's  token
        'redirectUrl' => 'http://www.mydomain.com.br/', // TODO: Change to client's  domain
        'notificationUrl' => 'http://api.domain.com.br/v1/payments/notify' // TODO: Change to client's  domain
    ]
];
