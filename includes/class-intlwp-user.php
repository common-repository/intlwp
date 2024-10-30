<?php
class Internationalize_WordPress_User
{
	var $args = array();
	var $new = '';
	var $idna;
	function __construct($args)
	{
		$this->args = $args;
		
		if(get_site_option('IntlWP_min_length')||get_site_option('IntlWP_max_length'))
		{
			$this->IntlWP_length();
		}
		
		if(get_site_option('IntlWP_domainname'))
		{
			if(!$this->args['intl_install'])
			{
				$this->idna = $this->net_idna2();
			}
			$this->IntlWP_domainname();
		}
	}
	
	function IntlWP_domainname()
	{
		add_action('signup_hidden_fields', array(&$this, 'signup_hidden_fields'));
		add_action('wpmu_validate_blog_signup', array(&$this, 'check_blogname'));
	}
	
	function IntlWP_length()
	{
		add_action('wpmu_validate_blog_signup', array(&$this, 'check_length'));
	}
		
	function idn_2_utf8($str='')
	{
		$res = false;
		if(!$this->args['intl_install'])
		{
			if(!$res = $this->idna->decode($str))
			{
				if($this->idna->_error=='This is not a punycode string')
				{
					$res = $str;
					$this->idna->_error='';
				}
			}
		}
		else
		{
			$res = idn_to_utf8($str);
		}
		return $res;
	}
	
	function idn_2_ascii($str='')
	{
		$res = false;
		if(!$this->args['intl_install'])
		{
			if(!$res = $this->idna->encode($str))
			{
				if($this->idna->_error=='The given string does not contain encodable chars')
				{
					$res = $str;
					$this->idna->_error='';
				}
			}
			
		}
		else
		{
			$res = idn_to_ascii($str);
		}
		return $res;
	}
	
	function request_var($name = '', $default = 0)
	{
		$res = $default;
		if(isset($_REQUEST[$name])) 
		{
			$res = $_REQUEST[$name];
		}
		return $res;
	}
	
	function net_idna2()
	{
		if(!class_exists('Net_IDNA2'))
		{
			$file = $this->args['plugin_path'] . "/includes/IDNA.php";
			require_once($file);
		}
		$res = Net_IDNA::getInstance();
		return $res;
	}
	
	function valid_length($str)
	{
		$res = false;
		$strlen = $this->utf8_strlen($str);
		if(($strlen>=get_site_option('IntlWP_min_length'))&&
			($strlen<=get_site_option('IntlWP_max_length')))
		{
			$res = true;
		}
		return $res;
	}
	
	function utf8_strlen($string=null, $string_encoding='UTF-8') 
	{
		$res = mb_strlen($string, $string_encoding);
		return $res;
	}	
	
	function validate_utf8($str = '')
	{
		$res = false;
		$ascii = $this->idn_2_ascii($str);
		if($str == $this->idn_2_utf8($ascii))
		{
			$res = true;
		}
		return $res;
	}
			
	function check_blogname($result)
	{
		if (! is_wp_error($result['errors'])) {
			return $result;
		}
		
		$result['errors'] = $this->remove_wp_error($result['errors'], 'blogname', __('Only lowercase letters and numbers allowed'));
		if(
			$this->check_fobid_charactor($result['blogname']) 
			||!$this->validate_utf8($result['blogname']) 
		)
		{
			$message = __('Only Chinese, lowercase letters (a-z) and numbers are allowed.', $this->args['plugin_slug']);
			$result['errors']->add('blogname',$message);
		}
		if(is_subdomain_install())
		{
			$result['domain'] = $this->idn_2_ascii($result['domain']);
		}
		else
		{
			$result['path'] = urlencode($result['path']);
			$result['path'] = str_replace(urlencode('/'),'/',$result['path']);
		}
		return $result;
	}
	
	function check_length($result)
	{
		$result['errors'] = $this->remove_wp_error($result['errors'], 'blogname', __('Site name must be at least 4 characters'));
		if(!$this->valid_length($result['blogname']))
		{
			$format = __('Must be %1$d - %2$d characters.', $this->args['plugin_slug']);
			$message = sprintf($format, get_site_option('IntlWP_min_length'), get_site_option('IntlWP_max_length'));
			$result['errors']->add('blogname',$message);
		}
		return $result;
	}
	
	function check_fobid_charactor($str='')
	{
		$res = false;
		$patten = "/[[:space:][:punct:]]/";
		if(preg_match($patten,$str))
		{
			$res = true;
		}
		return $res;
	}
	
	function signup_hidden_fields()
	{
		global $current_site;
		add_filter('gettext', array(&$this, 'override_language'),10,2);
		$current_site->domain = $this->idn_2_utf8($current_site->domain);
	}
	
	function remove_wp_error($obj, $code=false, $message=false)
	{
		if (! is_wp_error($obj)) 
		{
			return $obj;
		}
		$errors = $obj->errors;
		$new_errors = array();
		foreach($errors as $k => $error)
		{
			if($k == $code)
			{
				$new_code = array();
				foreach($error as $v)
				{
					if($v != $message)
					{
						$new_code[] = $v;
					}
				}
				if(sizeof($new_code)>0)
				{
					$new_errors[$code] = $new_code;
				}
			}
			else
			{
				$new_errors[$k] = $error;
			}
		}
		$obj->errors = $new_errors;
		return $obj;
	}
	
	function override_language($translate, $text)
	{
		$res = $translate;
		if($text == 'Must be at least 4 characters, letters and numbers only. It cannot be changed, so choose carefully!')
		{
			$res = __('Only Chinese, lowercase letters (a-z) and numbers are allowed.', $this->args['plugin_slug']);
		}
		return $res;
	}
}
?>