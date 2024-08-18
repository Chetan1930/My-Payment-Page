<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = htmlspecialchars($_POST['amount']);
    $transaction_id = htmlspecialchars($_POST['transaction_id']);
    $payment_method = htmlspecialchars($_POST['payment-method']);
    $to = "sdechetan@gmail.com";
    $subject = "Payment Confirmation - $payment_method";
    $message = "Payment Details:\n\nAmount: ₹$amount\nTransaction ID: $transaction_id\nPayment Method: $payment_method";

    // Handle file upload
    $file_tmp = $_FILES['screenshot']['tmp_name'];
    $file_name = $_FILES['screenshot']['name'];
    $file_size = $_FILES['screenshot']['size'];
    $file_type = $_FILES['screenshot']['type'];
    $file_error = $_FILES['screenshot']['error'];

    if ($file_error === 0) {
        $file_content = file_get_contents($file_tmp);
        $encoded_file = chunk_split(base64_encode($file_content));
        $boundary = md5("sanwebe");

        // Headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From: YourWebsite <no-reply@yourwebsite.com>\r\n";
        $headers .= "Reply-To: no-reply@yourwebsite.com\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        // Message Body
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n";

        // Attachment
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $encoded_file . "\r\n";
        $body .= "--$boundary--";

        // Send Email
        if (mail($to, $subject, $body, $headers)) {
            echo "Payment confirmation has been sent.";
        } else {
            echo "Failed to send payment confirmation.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
