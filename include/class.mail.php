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
        require 'Zend/Loader.php';
        Zend_Loader::loadClass('Zend_Mail');
        
        $email = new Zend_Mail('UTF-8');
        $email->setBodyText($this->mail['body']);
        $email->setBodyHtml($this->mail['body']);
        $email->setFrom($this->mail['from_email'], $this->mail['from_name']);
        $email->addTo($this->mail['to_email'], $this->mail['to_name']);
        $email->setSubject($this->mail['subject']);
        $email->send();
        
    }

}
