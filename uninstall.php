<?php
//if uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN'))
exit();

$options = array(
    'udimi_optin_key',
    'udimi_optin_script',
    'udimi_prime_features',
    'udimi_user_email',
    'udimi_optin_date',
    'udimi_is_last_success',

    'udimi_greyboxes_list',
    'udimi_selected_greybox',
    'udimi_allow_optin_tracking',
    'udimi_allow_greyboxes',

	// deprecated:
	'udimi_optin_name',
	'udimi_optin_email',
	'udimi_optin_connected'
);

foreach($options as $option){
    delete_option($option);
}
