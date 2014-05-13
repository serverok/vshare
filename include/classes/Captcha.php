<?php

class Captcha
{
    private static $public_key = '6Le6eAUAAAAAAFFu7P7Z2QX_J748rwpvAattTlzq';
    private static $private_key = '6Le6eAUAAAAAADDQahn7Hgqbr21lEQAkoIQAAdKK';

    public static function get($captcha_type = 'default')
    {
        if ($captcha_type == 'recaptcha') {
            return self::_reCaptcha();
        } else {
            return self::_default();
        }
    }

    private static function _reCaptcha()
    {
        $captcha_code = '
        <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=' . self::$public_key . '"></script>
        <noscript>
            <iframe src="http://www.google.com/recaptcha/api/noscript?k=' . self::$public_key . '" height="300" width="500" frameborder="0"></iframe><br>
            <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
            <input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
        </noscript>
        ';
        return $captcha_code;
    }

    private static function _default()
    {
        return '<img src="' . VSHARE_URL . '/captcha.php">';
    }

    public static function validate($captcha_type = 'default', $response = '', $challenge = '')
    {
        if ($captcha_type == 'recaptcha') {
            return self::_reCaptchaValidate($challenge, $response);
        } else {
            return self::_defaultValidate($response);
        }
    }

    private static function _defaultValidate($security_code)
    {
        if ($_SESSION['security_code'] == $security_code)
        {
            return true;
        }

        return false;
    }

    private static function _reCaptchaValidate($challenge, $response)
    {
        $data = array(
            'privatekey' => self::$private_key,
            'remoteip' => User::get_ip(),
            'challenge' => $challenge,
            'response' => $response
        );
        $req = "";

        foreach ( $data as $key => $value )
                $req .= $key . '=' . urlencode( stripslashes($value) ) . '&';

        $req = substr($req, 0, strlen($req) - 1);

        $http_request  = "POST /verify HTTP/1.0\r\n";
        $http_request .= "Host: api-verify.recaptcha.net\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($req) . "\r\n";
        $http_request .= "User-Agent: reCAPTCHA/PHP\r\n";
        $http_request .= "\r\n";
        $http_request .= $req;

        $response = '';

        if( false == ( $fs = @fsockopen('api-verify.recaptcha.net', 80, $errno, $errstr, 10) ) )
        {
            die ('Could not open socket');
        }

        fwrite($fs, $http_request);

        while ( !feof($fs) )
            $response .= fgets($fs, 1160);
        fclose($fs);

        $response = explode("\r\n\r\n", $response);
        $response = explode("\n", $response[1]);

        if ($response[0] == "true")
        {
            return true;
        }

        return false;
    }
}