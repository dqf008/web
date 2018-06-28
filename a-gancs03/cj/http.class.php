<?php class k4rrg
{
	public $referer;
	public $fetch_url;
	public $postStr;
	public $retStr;
	public $theData;
	public $theCookies;
	public $proxy_host = '';
	public $proxy_port = '0';
	public $curl;
	public function cHTTP()
	{
		$this->curl = new Curl_HTTP_Client();
		$this->curl->store_cookies('/cache/cookies.txt');
		$this->curl->set_user_agent('Mozilla/4.0 (compatible;MSIE 6.0;Windows NT 5.1)');
	}
	public function setReferer($sRef)
	{
		$this->referer = $sRef;
	}
	public function checkCookies()
	{
		$cookies = explode('Set-Cookie:', $this->theData);
		$i = 0;
		if (0 < (count($cookies) - 1))
		{
			while (list($foo, $theCookie) = each($cookies))
			{
				list($foo, $theCookie) = each($cookies);
				if (!($i == 0))
				{
					list($theCookie, $foo) = explode(';', $theCookie);
					list($cookieName, $cookieValue) = explode('=', $theCookie);
					list($cookieValue, $foo) = explode("\r\n", $cookieValue);
					$this->setCookies(trim($cookieName), trim($cookieValue));
				}
				$i++;
			}
		}
	}
	public function setCookies($sName, $sValue)
	{
		$total = count(explode($sName, $this->theCookies));
		if (1 < $total)
		{
			list($foo, $cValue) = explode($sName, $this->theCookies);
			list($cValue, $foo) = explode(';', $cValue);
			$this->theCookies = str_replace($sName . $cValue . ';', '', $this->theCookies);
		}
		$this->theCookies .= $sName . '=' . $this->HTMLEncode($sValue) . ';';
	}
	public function getContent()
	{
		$this->curl->set_referrer($this->referer);
		return $this->curl->fetch_url($this->fetch_url);
	}
	public function getHeaders()
	{
		list($header, $foo) = explode("\r\n\r\n", $this->theData);
		list($foo, $content) = explode($header, $this->theData);
		return $header;
	}
	public function getHeader($sName)
	{
		list($foo, $part1) = explode($sName . ':', $this->theData);
		list($sVal, $foo) = explode("\r\n", $part1);
		return trim($sVal);
	}
	public function getPage($sURL)
	{
		$this->fetch_url = $sURL;
	}
	public function dataDecode()
	{
		$kk = strstr($this->theData, 'Transfer-Encoding');
		if (empty($kk))
		{
			return NULL;
		}
		else
		{
			$encode_method = $this->getHeader('Transfer-Encoding');
		}
		if ($encode_method == 'chunked')
		{
			$headers = $this->getHeaders();
			$content = $this->getContent();
			$temp = $content;
			$content = $this->unchunk($content);
			if (empty($content))
			{
				$content = $temp;
			}
			$this->theData = $headers . "\r\n\r\n" . $content;
		}
		return NULL;
	}
	public function parseRequest($sURL)
	{
		list($protocol, $sURL) = explode('://', $sURL);
		list($host, $foo) = explode('/', $sURL);
		list($foo, $request) = explode($host, $sURL);
		list($host, $port) = explode(':', $host);
		if (strlen($request) == 0)
		{
			$request = '/';
		}
		if (strlen($port) == 0)
		{
			$port = '80';
		}
		$sInfo = array();
		$sInfo['host'] = $host;
		$sInfo['port'] = $port;
		$sInfo['protocol'] = $protocol;
		$sInfo['request'] = $request;
		return $sInfo;
	}
	public function HTMLEncode($sHTML)
	{
		$sHTML = urlencode($sHTML);
		return $sHTML;
	}
	public function downloadData($host, $port, $httpHeader)
	{
		$fp = @(fsockopen($host, $port));
		$retStr = '';
		if ($fp)
		{
			fputs($fp, $httpHeader);
			while (!feof($fp))
			{
				$retStr .= fread($fp, 1024);
			}
		}
		fclose($fp);
		return $retStr;
	}
	public function unchunk($str)
	{
		$return_str = '';
		$loop_count = 0;
		$become_data_lenght = 0;
		$last_data_lenght = 0;
		while (1)
		{
			$temp = strstr($str, "\r\n");
			$now_data = substr($str, 0, strlen($str) - strlen($temp));
			$str = substr($str, strlen($now_data) + 2, strlen($str));
			if (!empty($now_data))
			{
				$become_data_lenght = hexdec($now_data);
			}
			if ($last_data_lenght == strlen($now_data))
			{
				$return_str .= $now_data;
			}
			$last_data_lenght = $become_data_lenght;
			if (empty($now_data))
			{
				$loop_count++;
			}
			else
			{
				$loop_count = 0;
			}
			if (15 < $loop_count)
			{
				break;
			}
		}
		return $return_str;
	}
}
class u7tu9pyo_0rhcak7
{
	public $ch;
	public $debug = true;
	public $error_msg;
	public $error_no = '';
	public function Curl_HTTP_Client($debug = false)
	{
		$this->debug = $debug;
		$this->init();
	}
	public function init()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->ch, CURLOPT_ENCODING, 'gzip, deflate ,sdch');
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
	}
	public function set_credentials($username, $password)
	{
		curl_setopt($this->ch, CURLOPT_USERPWD, $username . ':' . $password);
	}
	public function set_referrer($referrer_url)
	{
		curl_setopt($this->ch, CURLOPT_REFERER, $referrer_url);
	}
	public function set_user_agent($useragent)
	{
		curl_setopt($this->ch, CURLOPT_USERAGENT, $useragent);
	}
	public function include_response_headers($value)
	{
		curl_setopt($this->ch, CURLOPT_HEADER, $value);
	}
	public function set_proxy($proxy)
	{
		curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
	}
	public function send_post_data($url, $postdata, $ip = NULL, $timeout = 10)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		if ($ip)
		{
			if ($this->debug)
			{?> Binding to ip<?=$ip ;
 }
			curl_setopt($this->ch, CURLOPT_INTERFACE, $ip);
		}
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($this->ch, CURLOPT_POST, true);
		$post_array = array();
		if (is_array($postdata))
		{
			foreach ($postdata as $key => $value)
			{
				$post_array[] = $key . '=' . $value;
			}
			$post_string = implode('&', $post_array);
			if ($this->debug)
			{?> Url:<?=$url ;?>
  Post String:<?=$post_string ;
 }
		}
		else
		{
			$post_string = $postdata;
		}
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_string);
		$result = curl_exec($this->ch);
		if (curl_errno($this->ch))
		{
			if ($this->debug)
			{?> Error Occured in Curl
 Error number:<?=curl_errno($this) ;?>
 Error message:<?=curl_error($this) ;
 }
			return false;
		}
		else
		{
			return $result;
		}
	}
	public function fetch_url($url, $ip = NULL, $timeout = 20)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_HTTPGET, true);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		if ($ip)
		{
			if ($this->debug)
			{?> Binding to ip<?=.$ip ;
 }
			curl_setopt($this->ch, CURLOPT_INTERFACE, $ip);
		}
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($this->ch);
		if (curl_errno($this->ch))
		{
			if ($this->debug)
			{?> Error Occured in Curl
 Error number:<?=curl_errno($this) ;?>
 Error message:<?=curl_error($this) ;
 }
			return false;
		}
		else
		{
			return $result;
		}
	}
	public function fetch_into_file($url, $fp, $ip = NULL, $timeout = 5)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_HTTPGET, true);
		curl_setopt($this->ch, CURLOPT_FILE, $fp);
		if ($ip)
		{
			if ($this->debug)
			{?> Binding to ip<?=.$ip ;
 }
			curl_setopt($this->ch, CURLOPT_INTERFACE, $ip);
		}
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($this->ch);
		if (curl_errno($this->ch))
		{
			if ($this->debug)
			{?> Error Occured in Curl
 Error number:<?=curl_errno($this) ;?>
 Error message:<?=curl_error($this) ;
 }
			return false;
		}
		else
		{
			return true;
		}
	}
	public function send_multipart_post_data($url, $postdata, $file_field_array = array(), $ip = NULL, $timeout = 30)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		if ($ip)
		{
			if ($this->debug)
			{?> Binding to ip<?=.$ip ;
 }
			curl_setopt($this->ch, CURLOPT_INTERFACE, $ip);
		}
		curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($this->ch, CURLOPT_POST, true);
		$headers = array('Expect: ');
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
		$result_post = array();
		$post_array = array();
		$post_string_array = array();
		if (!is_array($postdata))
		{
			return false;
		}
		foreach ($postdata as $key => $value)
		{
			$post_array[$key] = $value;
			$post_string_array[] = urlencode($key) . '=' . urlencode($value);
		}
		$post_string = implode('&', $post_string_array);
		if ($this->debug)
		{?> Post String:<?=$post_string ;
 }
		if (!empty($file_field_array))
		{
			foreach ($file_field_array as $var_name => $var_value)
			{
				if (strpos(PHP_OS, 'WIN') !== false)
				{
					$var_value = str_replace('/', '\\', $var_value);
				}
				$file_field_array[$var_name] = '@' . $var_value;
			}
		}
		$result_post = array_merge($post_array, $file_field_array);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $result_post);
		$result = curl_exec($this->ch);
		if (curl_errno($this->ch))
		{
			if ($this->debug)
			{?> Error Occured in Curl
 Error:<?=curl_errno($this) ;?>
 Message:<?=curl_error($this) ;
 }
			return false;
		}
		else
		{
			return $result;
		}
	}
	public function store_cookies($cookie_file)
	{
		curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookie_file);
		curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookie_file);
	}
	public function set_cookie($cookie)
	{
		curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);
	}
	public function get_effective_url()
	{
		return curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
	}
	public function get_http_response_code()
	{
		return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
	}
	public function get_error_msg()
	{?> Error:<?=curl_errno($this) ;?>
 Message3:<?=curl_error($this) ;
 return $err;
	}
	public function close()
	{
		curl_close($this->ch);
	}
}?>