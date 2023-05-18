<?php

return [
    "sandbox"         => env("NAGAD_SANDBOX", true),

    "merchant_id"     => env("NAGAD_MERCHANT_ID", ""),
    "merchant_number" => env("NAGAD_MERCHANT_NUMBER", ""),
    "public_key"      => env("NAGAD_PUBLIC_KEY", ""),
    "private_key"     => env("NAGAD_PRIVATE_KEY", ""),

    "merchant_id_2"     => env("NAGAD_MERCHANT_ID2", ""),
    "merchant_number_2" => env("NAGAD_MERCHANT_NUMBER2", ""),
    "public_key_2"      => env("NAGAD_PUBLIC_KEY2", ""),
    "private_key_2"     => env("NAGAD_PRIVATE_KEY2", ""),

    "merchant_id_3"     => env("NAGAD_MERCHANT_ID3", ""),
    "merchant_number_3" => env("NAGAD_MERCHANT_NUMBER3", ""),
    "public_key_3"      => env("NAGAD_PUBLIC_KEY3", ""),
    "private_key_3"     => env("NAGAD_PRIVATE_KEY3", ""),

    "merchant_id_4"     => env("NAGAD_MERCHANT_ID4", ""),
    "merchant_number_4" => env("NAGAD_MERCHANT_NUMBER4", ""),
    "public_key_4"      => env("NAGAD_PUBLIC_KEY4", ""),
    "private_key_4"     => env("NAGAD_PRIVATE_KEY4", ""),

    /*
      |--------------------------------------------------------------------------
      | Default callback url
      |--------------------------------------------------------------------------
      |
      | This option controls the nagad callback url
      | By default, it will redirect to "http://your_domain/nagad/callback"
      | you may change this url any time.
      */
    "callback_url"    => env("NAGAD_CALLBACK_URL", "http://your_domain/nagad/callback"),
    "callback_url_2"    => env("NAGAD_CALLBACK_URL2", "http://your_domain/nagad/callback"),
    "callback_url_3"    => env("NAGAD_CALLBACK_URL3", "http://your_domain/nagad/callback"),
    "callback_url_4"    => env("NAGAD_CALLBACK_URL4", "http://your_domain/nagad/callback"),

    /*
      |--------------------------------------------------------------------------
      | Default Response Type
      |--------------------------------------------------------------------------
      |
      | This option controls the response type callback
      | By default, it will return json data
      | you may specify any of the other wonderful options provided here.
      |
      | Supported: "json", "html",
      |
      */
    'timezone'        => 'Asia/Dhaka',

    "response_type"   => "html" // response type json/html
];
