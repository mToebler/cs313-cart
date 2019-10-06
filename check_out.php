<?php
session_start();
//sort out variables
$name = ""; // Sender Name
$address = "";
$name_error = "";
$address_error = "";
if (isset($_POST['submit'])) { // Checking null values in message.
   if (empty($_POST["name"])) {
      $nameError = "Name is required";
   } else {
      $name = test_input($_POST["name"]); // check name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
         $nameError = "Only letters and white space allowed";
      }
   } // Checking null values inthe message.
   if (empty($_POST["email"])) {
      $emailError = "Email is required";
   } else {
      $email = test_input($_POST["email"]);
   } // Checking null values inmessage.
   if (empty($_POST["purpose"])) {
      $purposeError = "Purpose is required";
   } else {
      $purpose = test_input($_POST["purpose"]);
   } // Checking null values inmessage.
   if (empty($_POST["message"])) {
      $messageError = "Message is required";
   } else {
      $message = test_input($_POST["message"]);
   } // Checking null values inthe message.
   if (!($name == '') && !($email == '') && !($purpose == '') && !($message == '')) { // Checking valid email.
      if (preg_match("/([w-]+@[w-]+.[w-]+)/", $email)) {
         $header = $name . "<" . $email . ">";
         $headers = "FormGet.com"; /* Let's prepare the message for the e-mail */
         $msg = "Hello! $name Thank you...! For Contacting Us.
Name: $name
E-mail: $email
Purpose: $purpose
Message: $message
This is a Contact Confirmation mail. We Will contact You as soon as possible.";
         $msg1 = " $name Contacted Us. Hereis some information about $name.
Name: $name
E-mail: $email
Purpose: $purpose
Message: $message "; /* Send the message using mail() function */
         if (mail($email, $headers, $msg) && mail("receiver_mail_id@xyz.com", $header, $msg1)) {
            $successMessage = "Message sent successfully.......";
         }
      } else {
         $emailError = "Invalid Email";
      }
   }
} // Function for filtering input values.function test_input($data)
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
<!DOCTYPE html>

<head>
   <meta charset="utf-8">
   <title>Checkout</title>
   <meta name="description" content="For the CS313 Shopping cart assignment in week 3">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="week03.css">
</head>
<header class="header">
   <div class="container nav">
      Nav here.
   </div>
</header>

<body>
   <div class="container">
      <div class="main">
         <h2>PHP Contact Form with Validation</h2>
         <form method="post" action="contact_form.php">
            <label>Name :</label>
            <input class="input" type="text" name="name" value="">
            <span class="error"><?php echo $nameError; ?></span>
            <label>Email :</label>
            <input class="input" type="text" name="email" value="">
            <span class="error"><?php echo $emailError; ?></span>
            <label>Purpose :</label>
            <input class="input" type="text" name="purpose" value="">
            <span class="error"><?php echo $purposeError; ?></span>
            <label>Message :</label>
            <textarea name="message" val=""></textarea>
            <span class="error"><?php echo $messageError; ?></span>
            <input class="submit" type="submit" name="submit" value="Submit">
            <span class="success"><?php echo $successMessage; ?></span>
         </form>
      </div>
   </div>
</body>

</html>