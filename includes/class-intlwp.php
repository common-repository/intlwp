<?php 
class Internationalize_WordPress_Plugin
{
	var $args;
	
	function __construct($args)
	{
		$this->args = $args;
		$this->args['intl_install'] = $this->intl_install();
		add_action('init', array(&$this, 'init'));
	}
	
	function init()
	{
		load_plugin_textdomain($this->args['plugin_slug'], false, '/' . $this->args['plugin_slug'] . '/language/' );
		if(is_super_admin()) 
		{
			$class_intlwp_admin = $this->plugin_function_admin();
		}
		if(get_site_option('IntlWP_domainname',0))
		{
			$class_intlwp_user = $this->plugin_function_user();
		}
	}
	
	function plugin_function_admin()
	{
		if(!class_exists('Internationalize_WordPress_Admin'))
		{
			$file = $this->args['plugin_path'] . "/includes/class-intlwp-admin.php";
			require_once($file);
		}
		$class_intlwp_admin = new Internationalize_WordPress_Admin($this->args);
		add_action('network_admin_menu', array(&$class_intlwp_admin, 'add_network_admin_menu'));
		add_action('admin_enqueue_scripts', array(&$class_intlwp_admin, 'admin_style'));
		add_action('wp_ajax_IntlWP_update_config', array(&$class_intlwp_admin, 'update_config_callback'));
		register_deactivation_hook( $this->args['plugin_path'] . 'IntlWP.php', array(&$class_intlwp_admin, 'plugin_deactivate'));
		return $class_intlwp_admin;
	}
	
	function plugin_function_user()
	{
		if(!class_exists('Internationalize_WordPress_User'))
		{
			$file = $this->args['plugin_path'] . "includes/class-intlwp-user.php";
			require_once($file);
		}
		$class_intlwp_user = new Internationalize_WordPress_User($this->args);
		return $class_intlwp_user;
	}
	
	function intl_install()
	{
		$res = false;
		if(function_exists('idn_to_utf8')&&function_exists('ascii')) 
		{
			$res = true;
		}
		return $res;
	}
}
?>
