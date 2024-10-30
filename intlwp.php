<?php
/**
 * @package IntlWP
 */
/*
Plugin Name: IntlWP
Plugin URI: http://xn--fjqz24b.xn--fiqs8s/
Description: Internationalize your WordPress. Your users can use their local language as sub-domainname or sub-directory.
Version: 1.2.1
Author: 450786@qq.com
Author URI: http://xn--fjqz24b.xn--fiqs8s/
*/
if(!class_exists('Internationalize_WordPress_Plugin'))
{
	require_once(plugin_dir_path(__FILE__) . 'includes/class-intlwp.php');
}
$intlwp_arr = array(
	'version'		=>	'1.2.1',
	'plugin_slug' 	=>	'intlwp',
	'plugin_path'	=>	plugin_dir_path( __FILE__ ),
	'plugin_url'	=>	plugin_dir_url( __FILE__ ),
	'config_arr'	=>	array
	(
		array('key'=>'IntlWP_domainname',	'default'=>0),
		array('key'=>'IntlWP_min_length',	'default'=>2),
		array('key'=>'IntlWP_max_length',	'default'=>5),
	),
);
$class_intlwp = new Internationalize_WordPress_Plugin($intlwp_arr);
?>
