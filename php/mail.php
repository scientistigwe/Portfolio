<?php


    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["inputName"]));
                $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["inputEmail"]), FILTER_SANITIZE_EMAIL);
        //$phone = filter_var(trim($_POST["inputPhone"], FILTER_SANITIZE_NUMBER_INT);
        $phone = trim($_POST["inputPhone"]);
        $message = trim($_POST["inputMessage"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($phone) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "xuwelkhan@gmail.com"; /** DON'T FORGET TO PUT YOUR EMAIL HERE **/

        // Set the email subject.
        $subject = "New message from $name";

        // Making email content
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Message:\n$message\n";

        // Making email headers
        $email_headers = "From: $name <$email>";

        // Sending email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Seting a 200 (okay) response code.
            http_response_code(200);
            echo "Great ! Your message has been sent !!"; // You may edit this value with your own
        } else {
            // Setting a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your input, please try again.";
    }


?>