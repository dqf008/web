 ﻿<?php class u7tu9pyo_0rhcak7
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
		curl_setopt($this->ch, CURLOPT_ENCODING, 'gzip, deflate');
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
	public function highlightHtml($code, $line_number = false)
	{
		$code = htmlspecialchars($code);
		$code = preg_replace('/(&lt;[a-zA-Z0-9]+)/', '<font color="#0000FF">$1</font>', $code);
		$code = preg_replace('/(&lt;\\/[a-zA-Z0-9]+&gt;)/', '<font color="#0000FF">$1</font>', $code);
		$code = preg_replace('/(\\/&gt;)/', '<font color="#0000FF">${1}</font>', $code);
		$code = preg_replace('/&lt;!DOCTYPE\\s+.+?&gt;/', '<font color="#3300FF">${0}</font>', $code);
		$code = str_replace('&lt;!--', '<font color="#666666"><em>&lt;!--', $code);
		$code = str_replace('--&gt;', '--&gt;</em></font>', $code);
		$code = preg_replace('/(&lt;!--\\s*)(begin|end)(\\s+)([a-z_\\x7f-\\xfe]+)/i', '${1}<font size="" color="#0000FF"><b>${2}</b></font>${3}<b><font color="#FF0000">${4}</font></b>', $code);
		$code = preg_replace('/(\\$[a-z0-9_]+)\\s*=\\s*(per|on)\\(([0-9]+),(\'.*?\'),(\'.*?\')\\)/i', '<font color="#009900"><b>${1}</b></font>=<font color="#0000FF">${2}</font>(${3},<font color="#FF9999">${4}</font>,<font color="#FF9999">${5}</font>)', $code);
		$code = preg_replace('/<font color="#666666"><em>&lt;!--\\s*vip/i', '<span style="display:block;border:1px dashed #696969;padding 3px" >${0}', $code);
		$code = preg_replace('/&lt;!--\\s*endvip\\s*--&gt;<\\/em><\\/font>/i', '${0}</span>', $code);
		$code = preg_replace('/&lt;!--\\s*#include\\s+file.+?--&gt;/i', '<span style="background-color:#FFFF66;font-weight:bold;font-style:normal;padding:3px">${0}</span>', $code);
		$code = preg_replace('/(\\{\\$[a-zA-Z0-9_\\x7f-\\xfe]+\\})/', '<font style="background-color:#D7FED1;padding:1px" color="#009900">${1}</font>', $code);
		$code = preg_replace('/(\\{\\$[a-zA-Z0-9_\\x7f-\\xfe]+;)([a-zA-Z]+)=\'([^\']+?)\'\\}/', '<font style="background-color:#D7FED1;padding:1px" color="#009900">${1}<font color="#CC0000">${2}</font>=<font color="#FF33CC">\'${3}\'</font>}</font>', $code);
		if (!$line_number)
		{
			return '<PRE>' . $code . '</PRE>';
		}
		else
		{
			$code = '<pre><ol><li>' . str_replace("\n", '</li><li>', $code) . '</li></ol></pre>';
			return $code;
		}
	}
	public function close()
	{
		curl_close($this->ch);
	}
}?>