<?php
/*
 *  Plugin Name: 1 Decembrie 1918
 *  Plugin URI: http://wordpress.org/extend/plugins/1-decembrie-1918/
 *  Description: 1 Decembrie 1918 - Ziua cea mare a tuturor romanilor!
 *  Author: Marius OLAR
 *  Version: 1.dec.2012
 *  Author URI: http://olarmarius.tk/
 *  License: GPLv3
 *
 */

define(UNU_DEC_1918_TEXTDOMAIN, '1-decembrie-1918');

//----------------------------------------------------------------------------------------

function unu_decembrie_1918_init() {
  load_plugin_textdomain( UNU_DEC_1918_TEXTDOMAIN, false, '1-decembrie-1918/languages' );
}

add_action('plugins_loaded', 'unu_decembrie_1918_init');

//----------------------------------------------------------------------------------------

function unu_decembrie_1918_activate() {
  add_option('unudec1918_url', 'http://1decembrie.ro/');
  add_option('unudec1918_efect', 1);
  add_option('unudec1918_text', 1);
  add_option('unudec1918_title_text', '1 Decembrie - Ziua Nationala a Romaniei!');
}

//----------------------------------------------------------------------------------------

function unu_decembrie_1918_deactivate() {
  delete_option('unudec1918_url');
  delete_option('unudec1918_efect');
  delete_option('unudec1918_text');
  delete_option('unudec1918_title_text');
}

register_activation_hook( __FILE__, 'unu_decembrie_1918_activate' );
register_deactivation_hook( __FILE__, 'unu_decembrie_1918_deactivate' );

//----------------------------------------------------------------------------------------------

function admin_unudec1918_options() {
  ?><div class="wrap"><h2>1 Decembrie 1918</h2><?php

  if ($_REQUEST['submit']) {
     update_unudec1918_options();
  }
  print_unudec1918_form();

  ?></div><?php
}

//----------------------------------------------------------------------------------------------

function update_unudec1918_options() {
  $eroare = '';
  
  $ok = false; 
  if ($_REQUEST['unudec1918_url']) { update_option('unudec1918_url', $_REQUEST['unudec1918_url']);  $ok = true;} 
  else {$eroare.=' -> URL';}

  $ok = false; 
  if ( isset($_REQUEST['unudec1918_efect'])) { update_option('unudec1918_efect', 1);  $ok = true;} 
  else {update_option('unudec1918_efect', 0); $eroare.=' -> Efect';}

  $ok = false; 
  if ( isset($_REQUEST['unudec1918_text']) ) { update_option('unudec1918_text', 1);  $ok = true;} 
  else {update_option('unudec1918_text', 0); $eroare.=' -> Text';}

  $ok = false; 
  if ($_REQUEST['unudec1918_title_text']) { update_option('unudec1918_title_text', $_REQUEST['unudec1918_title_text']);  $ok = true;} 
  else {$eroare.=' -> Title text';}

  if ($ok) {
    ?><div id="message" class="updated fadee">
       <p><?php echo __('Message', UNU_DEC_1918_TEXTDOMAIN); ?>: <strong> <?php echo __('Saved options', UNU_DEC_1918_TEXTDOMAIN); ?>!</strong></p>
      </div><?php
  } else {
       ?><div id="message" class="error fade">
         <p><?php echo __('Message', UNU_DEC_1918_TEXTDOMAIN); ?>: <strong> <?php echo __('Error saving options', UNU_DEC_1918_TEXTDOMAIN); ?>! (<?php echo $eroare;?>) </strong></p>
         </div><?php
  }
}

//----------------------------------------------------------------------------------------------

function print_unudec1918_form() {
  $default_unudec1918_url = get_option('unudec1918_url');
  $default_unudec1918_efect = get_option('unudec1918_efect');
  $default_unudec1918_text = get_option('unudec1918_text');
  $default_unudec1918_title_text = get_option('unudec1918_title_text');
  ?>	  
	  <h2><?php echo __('Settings', UNU_DEC_1918_TEXTDOMAIN); ?></h2>

  <div class="postbox" style="float:left; width:auto; height:auto; padding:10px;margin:10px;" >
  <form method="POST">
  <table>
  <tbody>

  <tr>
    <td><label for="unudec1918_url"><?php echo __('URL', UNU_DEC_1918_TEXTDOMAIN); ?>:</label></td>
    <td><input type="text" style="width:400px;" name="unudec1918_url" value="<?php echo$default_unudec1918_url;?>"></td>
    <td></td>
  </tr>

   <tr>
    <td><label for="unudec1918_title_text"><?php echo __('Title text', UNU_DEC_1918_TEXTDOMAIN); ?></label></td>
    <td><input type="text" style="width:400px;" name="unudec1918_title_text" value="<?php echo$default_unudec1918_title_text;?>"></td>
    <td></td>
  </tr>

  <tr>
    <td></td>
    <td><input type="checkbox" id="unudec1918_efect" name="unudec1918_efect" value="<?php echo$default_unudec1918_efect;?>" <?php checked(1==$default_unudec1918_efect);?>><label for="unudec1918_efect"><?php echo __('Show neon effect', UNU_DEC_1918_TEXTDOMAIN); ?></label></td>
    <td></td>
  </tr>

  <tr>
    <td></td>
    <td><input type="checkbox" id="unudec1918_text" name="unudec1918_text" value="<?php echo$default_unudec1918_text;?>" <?php checked(1==$default_unudec1918_text);?>><label for="unudec1918_text"><?php echo __('Show ribbon text', UNU_DEC_1918_TEXTDOMAIN); ?>:</label></td>
    <td></td>
  </tr>

 <tr>
    <td colspan="3"><input type="submit" name="submit" value="<?php echo __('Save', UNU_DEC_1918_TEXTDOMAIN); ?>" /></td>
  </tr>
  </tbody>
  </table>
  </form>
   <?php
}

//----------------------------------------------------------------------------------------------

function unu_decembrie_1918_menu() {
  add_options_page(
    '1 Decembrie 1918 - ' . __('Settings', UNU_DEC_1918_TEXTDOMAIN), // page title
    '1 Decembrie 1918', // submenu title
    'manage_options', // access/capability
    __FILE__, // file
    'admin_unudec1918_options' // function
  );
}

add_action('admin_menu', 'unu_decembrie_1918_menu');

//----------------------------------------------------------------------------------------------

function unu_decembrie_1918_panglica() {
  $unudec1918_url = get_option('unudec1918_url','');
  $unudec1918_efect = get_option('unudec1918_efect', 0);
  $unudec1918_text = get_option('unudec1918_text', 0);
  $unudec1918_title_text = get_option('unudec1918_title_text', '1 Decembrie - Ziua Nationala a Romaniei!');

  $panglica = '<a target="_blank" href="'.$unudec1918_url.'"><img style="position: fixed; top: 0; right: 0; border: 0; z-index: 999999999999 !important; cursor: pointer;" src="'.get_bloginfo('siteurl').'/wp-content/plugins/1-decembrie-1918/img/1-decembrie-1918-'.$unudec1918_text.$unudec1918_efect.'.png" alt="'.$unudec1918_title_text.'" title="'.$unudec1918_title_text.'"></a>';
  
  echo $panglica;
}

add_filter('wp_footer', 'unu_decembrie_1918_panglica');

?>