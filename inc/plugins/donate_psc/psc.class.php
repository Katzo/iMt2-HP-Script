<?php
/*
 * This belongs to iMers iMt2-HP-Script
 * https://github.com/imermcmaps/iMt2-HP-Script
 * iMer.cc 2012
 * 
 * This is a default plugin called donate_psc
 * It helps you to make money with your server. (When you make enough money please consider donating to help me make more stuff like this!)
 * 
 */
class psc_cash_in
    {
    public $sessionid;
    public $code;  
    public $currency;
    public $captcha;
    public $cvid;
    public $value;
    public $date;
    public $id;
    public $cookie;
    public $cookie2;
	public $allowed_currency;
	public $novalue = false;
	
    function show_captcha($renew = false)
        {
        if (isset($_SESSION['PSC_script_data']['captcha']) AND !empty($_SESSION['PSC_script_data']['captcha']) AND $renew === false){
            return $_SESSION['PSC_script_data']['captcha'];
        }
        $result=file_get_contents("https://customer.cc.at.paysafecard.com/seam/resource/captcha", false,
            stream_context_create(array('http' => array('header' => "Cookie: JSESSIONID=" . $this->sessionid))));
        $isok=false;
        foreach($http_response_header as $resp)
        	if ($resp == "Content-Type: image/jpeg"){
        		$isok = true;
        		break;
        	}
        if (!$isok) return false;
        $_SESSION['PSC_script_data']['captcha']=$result;
        return $result;
        }
        
    function load_data($what)
        {
        if (isset($_SESSION['PSC_script_data'][$what]))
        {
        return  $_SESSION['PSC_script_data'][$what];
        }
        }

    function session_laden($renew = false)
        {
        if ($this->load_data('time')<(time()-(60*60)))
        {
        $this->sessionid='';
         unset($this->sessionid);
        }
        if (isset($this->sessionid) AND !empty($this->sessionid) AND $renew === false){
            return false;
        }
        $_SESSION['PSC_script_data']['time']=time();  

        $f=file_get_contents("https://customer.cc.at.paysafecard.com/psccustomer/GetWelcomePanelServlet");
        $this->sessionid=trim(str_replace(array
            (
            'Set-Cookie: JSESSIONID=',
            'Set-Cookie:JSESSIONID=', 
            ';Path=/; Secure',
            '; Path=/; Secure',
            ';Path=/;Secure'    
            ), '', $http_response_header[2]));
        $x=explode(';', $this->sessionid);
        $this->sessionid=$x[0];
		if (preg_match('/Set-Cookie: TSe8f342=(.*)/',$http_response_header[7])) {
			$this->cookie=trim(str_replace(array
			(
				'Set-Cookie: TSe8f342=',
				'; Path=/',
				';Path=/'
			), '', $http_response_header[7]));
			$x=explode(';', $this->cookie);
			$this->cookie=$x[0];
		}       
        $_SESSION['PSC_script_data']['sessionid']=$this->sessionid;     
        $_SESSION['PSC_script_data']['cookie']=$this->cookie;    
        $_SESSION['PSC_script_data']['cookie2']=$this->cookie2;   
        $_SESSION['PSC_script_data']['captcha']='';         
        return true; 
        }

    function cash_in()
        {
        $this->change_lang();
        $check=$this->check();

        if ($check != 'ok')
            return $check;

        if ($this->get_details() == "ok"){
        	$this->novalue = true;
        	return "ok";
        }
        	

        if ($this->value <= 0)
        {
            return 'error_empty';
        }        
		return 'ok';	
        }

    function check()
        {
        $this->code=trim($this->code);
        $this->code=str_replace(array
            (
            '-',
            ' '
            ), '', $this->code);

        if (empty($this->code) || empty($this->captcha))
            return 'error_fields_blank';

        elseif (strlen($this->code) != 16)
            return 'error_code';

        elseif (strlen($this->captcha) != 5)
            return 'error_captcha';

        elseif (substr($this->code, 0, 1) == "1")
            return 'error_online';
            

        else{ 
            $psc_code_array=explode(chr(0), wordwrap($this->code, 4, chr(0), true));
            $request="mainPagePart=mainPagePart&mainPagePart%3Arn1=" . $psc_code_array[0] . "&mainPagePart%3Arn2="
                . $psc_code_array[1] . "&mainPagePart%3Arn3="
                . $psc_code_array[2] . "&mainPagePart%3Arn4=" . $psc_code_array[3] . "&mainPagePart%3ApassField=&mainPagePart%3AverifyCaptcha="
                . urlencode($this->captcha) . "&mainPagePart%3Anext=OK&javax.faces.ViewState=j_id1";   


            $result=fsockopen('ssl://customer.cc.at.paysafecard.com', 443);
            fputs($result,
                "POST /psccustomer/GetWelcomePanelServlet HTTP/1.1\r\nHost: customer.cc.at.paysafecard.com\r\nConnection: close\r\nReferer: https://customer.cc.at.paysafecard.com/psccustomer/GetWelcomePanelServlet\r\nCookie: JSESSIONID="
                . $this->sessionid . ";TSe8f342=" . $this->cookie
                . "\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: "
                . strlen($request) . "\r\n\r\n" . $request);
            $result_page='';
			$ok = false;
            while (!feof($result))
                {
                  $temp = fgets($result, 128);
				  $result_page.=$temp;
                  if (stristr($temp,'Balance?') && !stristr(str_replace("\r", '', $result_page),"\n\n")){
                      list($a, $cvid)=explode("cvid=", $temp);
                      $this->cvid=trim($cvid);
					  $ok =true;
                  }
				  
                }
			if ($ok) {
				$this->sessionid=strbetween($result_page,"Set-Cookie: JSESSIONID=","; Path");
				$this->cookie=strbetween($result_page,"Set-Cookie: TSe8f342=","; Path");
				return "ok";
			} elseif (stristr($result_page,"Der eingegebene Text") || stristr($result_page,"text entered is not"))
                return 'error_captcha';

            elseif (stristr($result_page,"PIN-Code und") || stristr($result_page,"error has occurred with"))
                return 'error_code_pw';

            else
                return 'error_unknown';
        }
        }

    function get_details()
        {
		global $plugin_conf;
        $page=file_get_contents("https://customer.cc.at.paysafecard.com/psccustomer/Payments?cvid=" . $this->cvid, false,
            stream_context_create(array('http' => array('header' => "Cookie: JSESSIONID=" . $this->sessionid
                . ";TSe8f342=" . $this->cookie))));
        preg_match_all("#cell2\">(.*?)</td>#", $page, $res);
        $res = explode(" ",$res[1][count($res[1])-1]);
        $this->value=floatval(str_replace(',', '.', $res[0]));
		$this->currency=$res[1];
		}
    function change_lang()
        {
        return true;
        $request='language=language&language%3AlanguageSelection=DE&javax.faces.ViewState=j_id2';
        $result=fsockopen('ssl://customer.cc.at.paysafecard.com', 443);
        fputs($result, "POST /psccustomer/GetWelcomePanelServlet"
            . " HTTP/1.1\r\nHost: customer.cc.at.paysafecard.com\r\nConnection: close\r\nReferer: https://customer.cc.at.paysafecard.com/psccustomer/GetWelcomePanelServlet\r\nCookie: JSESSIONID="
            . $this->sessionid . ";sc_cntry=DE;TSe8f342=" . $this->cookie
                . "\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: "
            . strlen($request) . "\r\n\r\n" . $request);
            
                    $page=file_get_contents("https://customer.cc.at.paysafecard.com/psccustomer/Balance?cvid=" . $this->cvid, false,
            stream_context_create(array('http' => array('header' => "Cookie: JSESSIONID=" . $this->sessionid
                . ";TSe8f342=" . $this->cookie))));                
        }
    }
function strbetween($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}



?>