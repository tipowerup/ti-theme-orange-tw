<?php

// Register country & currency JS variables for frontend use
$jsVars = [];

if ($defaultCountry = \Igniter\System\Models\Country::getDefault()) {
    $jsVars['country'] = [
        'name' => $defaultCountry->country_name,
        'iso_code_2' => $defaultCountry->iso_code_2,
        'iso_code_3' => $defaultCountry->iso_code_3,
        'format' => $defaultCountry->format,
    ];
}

if ($defaultCurrency = currency()->getDefault()) {
    $jsVars['currency'] = [
        'symbol' => $defaultCurrency->currency_symbol,
        'symbol_position' => $defaultCurrency->symbol_position,
        'thousand_sign' => $defaultCurrency->thousand_sign,
        'decimal_sign' => $defaultCurrency->decimal_sign,
        'decimal_precision' => $defaultCurrency->decimal_position,
    ];
}

if ($jsVars) {
    Assets::putJsVars($jsVars);
}
