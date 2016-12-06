<?php
/*
 * MyBB: Random Logo
 *
 * File: RandomLogo.php
 * 
 * Authors: Edson Ordaz, Vintagedaddyo
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.1
 * 
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Plugin Information

function RandomLogo_info()
{
    global $lang;

    $lang->load("random_logo");
    
    $lang->random_logo_Desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->random_logo_Desc;

    return Array(
        'name' => $lang->random_logo_Name,
        'description' => $lang->random_logo_Desc,
        'website' => $lang->random_logo_Web,
        'author' => $lang->random_logo_Auth,
        'authorsite' => $lang->random_logo_AuthSite,
        'version' => $lang->random_logo_Ver,
        'guid' => $lang->random_logo_GUID,
        'compatibility' => $lang->random_logo_Compat
    );
}

// Activate Plugin

function RandomLogo_activate(){
	global $db, $lang;
	
	$RandomLogo = array(
		"gid" =>			NULL,
		"name" => $lang->name_0,
		"title" => $lang->title_0,
		"description" =>	"",
		"disporder" =>		"0",
		"isdefault" =>		"no"
	);

	$db->insert_query("settinggroups", $RandomLogo);
	$gid = $db->insert_id();

	$RandomLogo_1 = array(
		"sid"			=> NULL,
		"name" => $lang->name_1,
		"title" => $lang->title_1,
		"description" => $lang->description_1,
		"optionscode"	=> "text",
		"value"			=> "images/RandomLogo/logo1.png",
		"disporder"		=> "1",
		"gid"			=> intval($gid)
	);

	$RandomLogo_2 = array(
		"sid"			=> NULL,
		"name" => $lang->name_2,
		"title" => $lang->title_2,
		"description" => $lang->description_2,
		"optionscode"	=> "text",
		"value"			=> "images/RandomLogo/logo2.png",
		"disporder"		=> "2",
		"gid"			=> intval($gid)
	);

	$RandomLogo_3 = array(
		"sid"			=> NULL,
		"name" => $lang->name_3,
		"title" => $lang->title_3,
		"description" => $lang->description_3,
		"optionscode"	=> "text",
		"value"			=> "images/RandomLogo/logo3.png",
		"disporder"		=> "3",
		"gid"			=> intval($gid)
	);

	$RandomLogo_4 = array(
		"sid"			=> NULL,
		"name" => $lang->name_4,
		"title" => $lang->title_4,
		"description" => $lang->description_4,
		"optionscode"	=> "text",
		"value"			=> "images/RandomLogo/logo4.png",
		"disporder"		=> "4",
		"gid"			=> intval($gid)
	);

	$RandomLogo_5 = array(
		"sid"			=> NULL,
		"name" => $lang->name_5,
		"title" => $lang->title_5,
		"description" => $lang->description_5,
		"optionscode"	=> "text",
		"value"			=> "images/RandomLogo/logo5.png",
		"disporder"		=> "5",
		"gid"			=> intval($gid)
	);

	$db->insert_query("settings", $RandomLogo_1);
	$db->insert_query("settings", $RandomLogo_2);
	$db->insert_query("settings", $RandomLogo_3);
	$db->insert_query("settings", $RandomLogo_4);
	$db->insert_query("settings", $RandomLogo_5);

    include MYBB_ROOT . '/inc/adminfunctions_templates.php';
	
    $find     = '#' . preg_quote('<img src="{$theme[\'logo\']}" alt="{$mybb->settings[\'bbname\']}" title="{$mybb->settings[\'bbname\']}" />') . '#';
    $replace  = '<script Language="JavaScript">
today = new Date()
number_of_images = 5
seconds = today.getSeconds()
number = seconds % number_of_images
if (number == 0){
banner = "{$mybb->settings[\'RandomLogo_1\']}"
target = "_self"
}
if (number == 1){
banner = "{$mybb->settings[\'RandomLogo_2\']}"
target = "_self"
}
if (number == 2){
banner = "{$mybb->settings[\'RandomLogo_3\']}"
target = "_self"
}
if (number == 3){
banner = "{$mybb->settings[\'RandomLogo_4\']}"
target = "_self"
}
if (number == 4){
banner = "{$mybb->settings[\'RandomLogo_5\']}"
target = "_self"
}
document.write(\'<img src="\' + banner + \'" border=0>\')
</script>';	

	find_replace_templatesets('header', $find, $replace, 1);

	// Optimize Database

	$db->query("OPTIMIZE TABLE ".TABLE_PREFIX."settinggroups");
	$db->query("OPTIMIZE TABLE ".TABLE_PREFIX."settings");
	$db->query("OPTIMIZE TABLE ".TABLE_PREFIX."sessions");
	
	// Rebuild Settings

    rebuild_settings();
}

// Deactivate plugin

function RandomLogo_deactivate(){
	global $db;
	$db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='RandomLogo'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='RandomLogo_1'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='RandomLogo_2'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='RandomLogo_3'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='RandomLogo_4'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='RandomLogo_5'");

    include MYBB_ROOT . '/inc/adminfunctions_templates.php';

    $find     = '#' . preg_quote('<script Language="JavaScript">
today = new Date()
number_of_images = 5
seconds = today.getSeconds()
number = seconds % number_of_images
if (number == 0){
banner = "{$mybb->settings[\'RandomLogo_1\']}"
target = "_self"
}
if (number == 1){
banner = "{$mybb->settings[\'RandomLogo_2\']}"
target = "_self"
}
if (number == 2){
banner = "{$mybb->settings[\'RandomLogo_3\']}"
target = "_self"
}
if (number == 3){
banner = "{$mybb->settings[\'RandomLogo_4\']}"
target = "_self"
}
if (number == 4){
banner = "{$mybb->settings[\'RandomLogo_5\']}"
target = "_self"
}
document.write(\'<img src="\' + banner + \'" border=0>\')
</script>') . '#';	
    $replace = '<img src="{$theme[\'logo\']}" alt="{$mybb->settings[\'bbname\']}" title="{$mybb->settings[\'bbname\']}" />';	

    find_replace_templatesets('header', $find, $replace, 0);

	// Optimize Database

	$db->query("OPTIMIZE TABLE ".TABLE_PREFIX."settinggroups");
	$db->query("OPTIMIZE TABLE ".TABLE_PREFIX."settings");
	$db->query("OPTIMIZE TABLE ".TABLE_PREFIX."sessions");
	
	// Rebuild Settings

    rebuild_settings();
}

?>