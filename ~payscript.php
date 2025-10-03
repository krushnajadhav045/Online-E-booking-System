<?php
use Razorpay\Api\Api;

$apiKey = "rzp_test_MgZzLUk1eVeXZR"; // Enter the Test API Key ID generated from Dashboard → Settings → API Keys
$apiSecret = "1RHD4EKhwkhlwH1oANL47Y0B"; // Enter the Test Secret Key generated from Dashboard → Settings → API Keys
$total_price = 1000; // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise

$order = $api->order->create(array(
    'receipt'         => 'Order'.$id,
    'amount'          => $_SESSION['total_price'] * 100, // Amount in paise
    'currency'        => 'INR'
    )
  );

  $razorpayOrderId = $order['id'];
  $_SESSION['razorpay_order_id'] = $razorpayOrderId;
?>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<form action="process_payment.php" method="POST">
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $apiKey; ?>"
        data-amount="<?php echo $total_price; ?>" // Use the calculated and converted amount in paise
        data-currency="INR" // Change to INR data-id="<?php echo 'OID' . rand(10, 100) . 'END'; ?>"
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