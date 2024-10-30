<?php
class Internationalize_WordPress_Admin
{
	var $args;
	function __construct($args)
	{
		$this->args = $args;
	}
	
	function add_network_admin_menu()
	{
		$icon_url = $this->args['plugin_url'] . 'style/img/slogo.png';
		$page = add_menu_page( __('IntlWP Config Page', $this->args['plugin_slug']), __('IntlWP', $this->args['plugin_slug']), 'read', $this->args['plugin_slug'], array(&$this, 'admin_defalt_page'), $icon_url );
	}
	
	function admin_defalt_page() {
		$plugin_slug = $this->args['plugin_slug'];
		$file = $this->args['plugin_path'] . "/style/admin_defalt_page.php";
		require_once($file);
	}
	
	function admin_style($hook)
	{
    	if( ('toplevel_page_' . $this->args['plugin_slug'])!= $hook )return;
		wp_enqueue_script('jquery.validate.min', $this->args['plugin_url'] . 'style/js/jquery.validate.min.js');
		wp_enqueue_script($this->args['plugin_slug'] . '_admin_js', $this->args['plugin_url'] . 'style/js/admin.js');
		wp_enqueue_style($this->args['plugin_slug'] . '_admin_css', $this->args['plugin_url'] . 'style/css/admin.css');
	}
	
	function update_config_callback() 
	{
		$res = __('Fail');
		$data = $this->before_update_site_options($this->args['config_arr'], $_REQUEST);
		if($this->save_site_options($data))
		{
			$res = __('Done');
		}
		$response = $this->ajax_response_arr($_REQUEST['action'], 0, $res);
		$xmlResponse = new WP_Ajax_Response($response);
		$xmlResponse->send();
		die();
	}
	
	function site_option_checked($key, $default=0, $use_cache=true) 
	{
		$res = '';
		if(get_site_option($key, $default, $use_cache))
		{
			$res = ' checked="checked" ';
		}
		return $res;
	}
	
	function site_option_text($key, $default=0, $use_cache=true)
	{
		$res = get_site_option($key, $default, $use_cache);
		return $res;
	}
	
	function before_update_site_options($config_arr = array(), $new_arr = array())
	{
		$res = array();
		if(is_array($config_arr)&&sizeof($config_arr)>0)
		{
			foreach($config_arr as $k => $v)
			{
				$res[$k]['key'] = $v['key'];
				$res[$k]['value'] = $v['default'];
				if(array_key_exists($v['key'], $new_arr))
				{
					$res[$k]['value'] = $new_arr[$v['key']];
				}
			}
		}
		return $res;
	}
		
	function ajax_response_arr($action='', $id=0, $text='')
	{
		$res = array(
			'what'=>$this->args['plugin_slug'],
			'action'=>$action,
			'id'=>0,
			'data'=>$text,
		);
		return $res;
	}
	
	function save_site_options($arr)
	{
		$res = false;
		if(is_array($arr)&&sizeof($arr)>0)
		{
			foreach($arr as $k => $v)
			{
				$i = get_site_option($v['key']);
				if($i !== false)
				{
					if($i != $v['value'])
					{
						update_site_option($v['key'], $v['value']);
					}
					else continue;
				}
				else
				{
					add_site_option($v['key'], $v['value']);
				}
			}
			$res = true;
		}
		return $res;
	}
	
	function plugin_deactivate()
	{
		foreach($this->args['config_arr'] as $v)
		{
			if(get_site_option($v['key']))
			{
				delete_site_option($v['key']);
			}
		}
	}
}
?>