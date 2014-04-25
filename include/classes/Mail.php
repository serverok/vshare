<?php

class Mail
{

    public $mail = array();

    function send($mail)
    {
        $this->mail = $mail;
        $this->zendMail();
    }

    function zendMail()
    {
        require_once VSHARE_DIR . '/include/class.html2text.php';
        require_once 'Zend/Loader.php';

        Zend_Loader::loadClass('Zend_Mail');

        $html2text = new Html2Text($this->mail['body'], 80);
        $body_text = $html2text->convert();

        $email = new Zend_Mail('UTF-8');
        $email->setBodyText($body_text);
        $email->setBodyHtml($this->mail['body']);
        $email->setFrom($this->mail['from_email'], $this->mail['from_name']);
        $email->addTo($this->mail['to_email'], $this->mail['to_name']);
        $email->setSubject($this->mail['subject']);

        if (isset($this->mail['unsubscribe_url']) && ! empty($this->mail['unsubscribe_url'])) {
            $email->addHeader('List-Unsubscribe', $this->mail['unsubscribe_url']);
        }

        $email->send();

    }

}
