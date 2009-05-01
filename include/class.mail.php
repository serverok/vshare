<?php

require VSHARE_DIR . '/include/class.html2text.php';

class Mail
{

    function send($mail)
    {
        $vshareMailer = new PHPMailer();
        $vshareMailer->CharSet = 'UTF-8';
        $vshareMailer->From = $mail['from_email'];
        $vshareMailer->FromName = $mail['from_name'];
        $vshareMailer->Subject = $mail['subject'];
        $vshareMailer->ClearAllRecipients();

        if (isset($mail['to_name']) && ! stristr($mail['to_name'], '@'))
        {
            $vshareMailer->AddAddress($mail['to_email'], $mail['to_name']);
        }
        else
        {
            $vshareMailer->AddAddress($mail['to_email']);
        }

        $vshareMailer->Body = $mail['body'];
        $vshareMailer->AltBody = $this->html2text($mail['body']);
        $vshareMailer->IsHTML(true);

        $status = $vshareMailer->Send();
        $vshareMailer->ClearAddresses();
        $vshareMailer->ClearAttachments();
        return $status;
    }

    function html2text($body)
    {
        $asciiText = new Html2Text($body, 80); // 80 columns maximum
        return $asciiText->convert();
    }
}
