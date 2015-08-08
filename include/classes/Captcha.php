<?php

class Captcha
{
    private $public_key;
    private $private_key;
    private $captcha_type;

    public function __construct()
    {
        $this->public_key = Config::get('recaptcha_sitekey');
        $this->private_key = Config::get('recaptcha_secretkey');
        $this->captcha_type = $this->getType();
    }

    public function getType()
    {
        $captcha_type = '';

        if (Config::get('captcha_type') == 'recaptcha') {
            if (strlen($this->public_key) > 10 && strlen($this->private_key) > 10) {
                $captcha_type = 'recaptcha';
            }
        }

        return $captcha_type;
    }

    public function get()
    {
        if ($this->captcha_type == 'recaptcha') {
            return $this->_reCaptcha();
        }

        return '';
    }

    private function _reCaptcha()
    {
        $captcha_code = '
        <div class="g-recaptcha" data-sitekey=' . $this->public_key . '></div>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        ';
        return $captcha_code;
    }

    public function validate($response = '')
    {
        if ($this->captcha_type == 'recaptcha') {
            return $this->_reCaptchaValidate($response);
        }
        return false;
    }

    private function _reCaptchaValidate($response)
    {
        $data = array(
            'secret' => $this->private_key,
            'remoteip' => User::get_ip(),
            'response' => $response
        );
        $req = "";

        foreach ( $data as $key => $value )
                $req .= $key . '=' . urlencode( stripslashes($value) ) . '&';

        $req = substr($req, 0, strlen($req) - 1);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);

        if(! $response)
        {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($response);
        return $response->success;
    }
}