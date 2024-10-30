<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2><?php _e('IntlWP Config Page',$plugin_slug);?></h2>
</div>
<div id="msg" style="display:none"></div>
<form id="IntlWP_update_config" action="" method="post" class="ajax_submit_form">
<?php if(is_multisite()){?>
<h3><?php _e('DomainName Config',$plugin_slug)?></h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="IntlWP_domainname"><?php _e('Internationalized Sub-DomainName and Path',$plugin_slug);?></label></th>
<td><input name="IntlWP_domainname" type="checkbox" value="1" <?php echo $this->site_option_checked('IntlWP_domainname', 0);?>> 
<br />
<?php _e('Enable Internationalized Sub-DomainName or Path for my WordPress Multiple Site',$plugin_slug)?></td>
</tr>
</tbody>
</table>

<h3><?php _e('Restriction Config',$plugin_slug)?></h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for=""><?php _e('Restriction Length',$plugin_slug);?></label></th>
<td><input name="IntlWP_min_length" type="text" value="<?php echo $this->site_option_text('IntlWP_min_length', 2);?>" size="3" maxlength="2" class="digits"> 
- <input name="IntlWP_max_length" type="text" value="<?php echo $this->site_option_text('IntlWP_max_length', 5);?>" size="3" maxlength="2" class="digits"> <?php _e('Characters',$plugin_slug)?>
<br />
<?php _e('Please input number',$plugin_slug)?></td>
</tr>
</tbody>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save');?>"></p>
<?php }else{?>
<h3><?php _e('No WordPress multisite installed!',$plugin_slug)?></h3>
<p><a href="http://wordpress.org/extend/plugins/intlwp/" target="_blank"><?php _e('Please visite WordPress MU document for more help',$plugin_slug)?></a></p>
<?php }?>
</form>