<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

use Razorpay\Api\Api;

// Initialize the Razorpay API with your API Key ID and Secret
$api = new Api($keyId, $keySecret);

// Create an order
$order = $api->order->create([
    'receipt'       => 'rcptid_11',
    'amount'        => 500000, // Amount in currency subunits
    'currency'      => 'USD'
]);
