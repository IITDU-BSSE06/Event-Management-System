<?php

echo "RA Rahat";

$to      = 'froghramar@gmail.com';
$subject = 'test kortesi';
$message = 'hello world from rahat';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$send = mail($to, $subject, $message, $headers);

if ($send) 
{
    echo "send";
}
else
{
	echo "fail";
}


?>

