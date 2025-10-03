<?php
session_start();

require_once "./functions/db_functions.php";

$title = "Purchase Process";
require "./template/header.php";

$conn = db_connect();

$firstname = trim($_POST['firstname']);
$firstname = mysqli_real_escape_string($conn, $firstname);

$lastname = trim($_POST['lastname']);
$lastname = mysqli_real_escape_string($conn, $lastname);

$address = trim($_POST['address']);
$address = mysqli_real_escape_string($conn, $address);

$city = trim($_POST['city']);
$city = mysqli_real_escape_string($conn, $city);

$zipcode = trim($_POST['zipcode']);
$zipcode = mysqli_real_escape_string($conn, $zipcode);

$cardnumber = trim($_POST['cardNumber']);
$cardnumber = mysqli_real_escape_string($conn, $cardnumber);

$expiry_date = trim($_POST['expiryDate']);
$expiry_date = mysqli_real_escape_string($conn, $expiry_date);

$cvv = trim($_POST['cvv']);
$cvv = mysqli_real_escape_string($conn, $cvv);

// find customer
$customer = getCustomerInfobyEmail($_SESSION['email']);
$id = $customer['id'];

$query = "UPDATE customers SET firstname='$firstname', lastname='$lastname', address='$address', city='$city', zipcode='$zipcode', cardnumber='$cardnumber', expiry_date='$expiry_date', cvv='$cvv' where id='$id'";

mysqli_query($conn, $query);

// Razorpay integration starts here
$apiKey = "rzp_test_LH6YVzeSnmkYjh"; // Enter the Test API Key ID generated from Dashboard → Settings → API Keys
$apiSecret = "IyLkwU9DIyqxPwCcEA4P6ofk"; // Enter the Test Secret Key generated from Dashboard → Settings → API Keys
$total_price = $_SESSION['total_price'] * 100; // Convert to paise

?>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<form id="paymentForm" action="process_payment.php" method="POST">
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo $apiKey; ?>"
        data-amount="<?php echo $total_price; ?>" data-currency="INR"
        data-buttontext="Purchase" data-name="InkWell"
        data-prefill.name="<?php echo htmlspecialchars($firstname . ' ' . $lastname); ?>"
        data-prefill.email="<?php echo htmlspecialchars($_SESSION['customer_info']['email']); ?>"
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

<?php
// Continue with the order processing and finalization as in the second code base
?>

<p class="lead text-success" id="p" style="text-align: center; padding: 20px;">Your order has been processed successfully..</p>
<script>
    window.setTimeout(function(){
        window.location.href = "http://localhost/InkWell/index.php";
    }, 35000);
</script>

<?php
if(isset($conn)){
    mysqli_close($conn);
}

require_once "./template/footer.php";
?>