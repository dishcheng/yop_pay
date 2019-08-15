<?php

return [
    'appKey' => env('YOP_APP_KEY'),
    //父商编
    'parentMerchantNo' => env('YOP_PARENT_MERCHANT_NO'),
    //父商编私钥
    'private_key' => env('YOP_PRIVATE_KEY'),
    //易宝公钥
    'yop_public_key' => env('YOP_PUBLIC_KEY'),
    //根地址
    'serverRoot' => env('YOP_APP_KEY', 'https://openapi.yeepay.com/yop-center'),
];