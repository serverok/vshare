<?php

class Captcha
{
    private $public_key;
    private $private_key;

    public function __construct()
    {
        $this->public_key = Config::get('recaptcha_sitekey');
        $this->private_key = Config::get('recaptcha_secretkey');
    }

    public function isEnabled()
    {
        if (strlen($this->public_key) > 10 && strlen($this->private_key) > 10) {
            return true;
        }
        return false;
    }

    public function get()
    {
        if ($this->isEnabled()) {
            return $this->_reCaptcha();
        }
        return '';
    }

    private function _reCaptcha()
    {
        $captcha_code = '
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">
        <script src="https://www.google.com/recaptcha/api.js?render=' . $this->public_key . '"></script>
        <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("' . $this->public_key . '", {action: "homepage"}).then(function(token) {
                document.getElementById("g-recaptcha-response").value = token;
            });
        });
        </script>
        ';
        return $captcha_code;
    }

    public function validate($response = '')
    {
        return $this->_reCaptchaValidate($response);
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

        if ($response->success)
            if ($response->score >= 0.5)
                return true;

        return false;
    }
}
