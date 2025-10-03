<?php
session_start();
use Razorpay\Api\Api;

// Include the Razorpay PHP SDK
require('razorpay-php/Razorpay.php');

// Replace with your actual API Key ID and Secret
$keyId = 'rzp_test_MgZzLUk1eVeXZR';
$keySecret = '1RHD4EKhwkhlwH1oANL47Y0B';

// Initialize the Razorpay API with your API Key ID and Secret
$api = new Api($keyId, $keySecret);

// Ensure that the session variable is set
if (!isset($_SESSION['total_price'])) {
    $_SESSION['total_price'] = 1000; // Default value if not set
}

// Create an order
$order = $api->order->create([
    'receipt' => "Order{$_SESSION['order_id']}",
    'amount' => $_SESSION['total_price'] * 100, // Amount in paise
    'currency' => 'INR'
]);

$razorpayOrderId = $order['id'];
$_SESSION['razorpay_order_id'] = $razorpayOrderId;
?>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<form action="process_payment.php" method="POST">
    <script src="https://checkout.razorpay.com/v1/checkout.js" 
        data-key="<?php echo $keyId; ?>"
        data-amount="<?php echo $_SESSION['total_price'] * 100; ?>" // Use the calculated and converted amount in paise
        data-currency="INR"
        data-order_id="<?php echo $razorpayOrderId; ?>"
        data-buttontext="Purchase" 
        data-name="InkWell" 
        data-prefill.name=""
        data-prefill.email=""
        data-theme.color="#F37254"></script>
    <input type="hidden" custom="Hidden Element" name="hidden" />
</form>

<style>
    .razorpay-payment-button {
        display: none;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('.razorpay-payment-button').click();
    });
</script>
