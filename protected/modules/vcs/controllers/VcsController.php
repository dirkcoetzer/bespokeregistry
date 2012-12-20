<?php

class VcsController extends Controller
{
    public function actionAuthorisation(){
        $params = array(
            'UserId' => 4828,
            'Reference' => time(),
            'Description' => "API Test",
            'Amount' => 1000,
            'CardholderName' => 'Joe Blog',
            'CardNumber' => '4242424242424242',
            'ExpiryMonth' => 10,
            'ExpiryYear' => 15,
            'CardValidationCode' => '000',
        );
        
        $xml = "
            <?xml version='1.0' ?>
                <AuthorisationRequest>
                    <UserId>".$params['UserId']."</UserId>
                    <Reference>".$params['Reference']."</Reference>
                    <Description>".$params['Description']."</Description>
                    <Amount>".$params['Amount']."</Amount>
                    <CardholderName>".$params['CardholderName']."</CardholderName>
                    <CardNumber>".$params['CardNumber']."</CardNumber>
                    <ExpiryMonth>".$params['ExpiryMonth']."</ExpiryMonth>
                    <ExpiryYear>".$params['ExpiryYear']."</ExpiryYear>
                    <CardValidationCode>".$params['CardValidationCode']."</CardValidationCode>                    
                    <Currency>zar</Currency>
                    <CellNumber>0123456789</CellNumber>
                    <CellMessage>message</CellMessage>
                    <CardPresent>N</CardPresent>
                    <Track2>x</Track2>
                    <SettleOnly>N</SettleOnly>
                    <ManualAuthCode>x</ManualAuthCode>
                    <DelaySettlement>N</DelaySettlement>
                    <Eci>x</Eci>
                    <Cavv>x</Cavv>
                    <Xid>x</Xid>
                    <CardholderEmail>email@email.com</CardholderEmail>
                    <m_1>x</m_1>
                    <m_2>x</m_2>
                    <m_3>x</m_3>
                    <m_4>x</m_4>
                    <m_5>x</m_5>
                    <m_6>x</m_6>
                    <m_7>x</m_7>
                    <m_8>x</m_8>
                    <m_9>x</m_9>
                    <m_10>x</m_10>
                </AuthorisationRequest>
            ";
        
        $cc = new cURL();
        
        $url = "https://www.vcs.co.za/vvonline/ccxmlauth.asp";
        
        $postdata = "xmlmessage=".urlencode($xml);

        $output = $cc->post($url,$postdata); 
        
        print_r($output);
    }
    
    
}


class cURL {
    var $headers;
    var $user_agent;
    var $compression;
    var $cookie_file;
    var $proxy;


    function cURL($cookies=TRUE, $cookie='cookies.txt', $compression='gzip', $proxy=''){

        $this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $this->headers[] = 'Connection: Keep-Alive';
        $this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
        $this->compression = $compression;
        $this->proxy = $proxy;
        $this->cookies = $cookies;

        if ($this->cookies == TRUE) $this->cookie($cookie);
    }


    function cookie($cookie_file){
        if (file_exists($cookie_file)){
            $this->cookie_file=$cookie_file;
        } else {
            fopen($cookie_file,'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
            $this->cookie_file=$cookie_file;
            fclose($this->cookie_file);
        }
    }


    function get($url) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($process,CURLOPT_ENCODING , $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) curl_setopt($cUrl, CURLOPT_PROXY, 'proxy_ip:proxy_port');
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }


    function post($url,$data) {
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
        if ($this->cookies == TRUE) curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
        curl_setopt($process, CURLOPT_ENCODING , $this->compression);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if ($this->proxy) curl_setopt($process, CURLOPT_PROXY, $this->proxy);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_POST, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

    function error($error) {
        echo "<center><div style='width:500px;border: 3px solid #FFEEFF; padding: 3px; background-color: #FFDDFF;font-family: verdana; font-size: 10px'><b>cURL Error</b><br>$error</div></center>";
        die;
    }


    function extractCustomHeader($start,$end,$header) {
        $pattern = '/'. $start .'(.*?)'. $end .'/';
        if (preg_match($pattern, $header, $result)) {
            return $result[1];
        } else {
            return false;
        }
    }
}
