<?php
/*
Plugin Name: HeadCounters
Plugin URI: http://headcounters.com/
Description: Wondering how many people are on your page? You can finally know!
Version: 2.0.1
Author: Tozzato-Johnson-Rabinowitz
Author URI: http://headcounters.com/
*/

define('HEADCOUNTERS_VERSION', '2.0.1');

define('HC', 'http://app.headcounters.com');

function headcounters_css(){
  echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"./wp-content/plugins/headcounters_beta/headcounters.css\">";
}

add_action('wp_head', 'headcounters_css');

function headcounters(){
  echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".HC."/wp_count.js\"></script>";
  echo "
  <script type=\"text/javascript\" charset=\"utf-8\">
       var head_counter = document.getElementById('footer');
       if (typeof(wp_count)!='undefined' && head_counter != null){
         head_counter.innerHTML += '<div class=\"headcounters\"><a class=\"headcounters\" href=\"http://headcounters.com\">Online Users: ' + wp_count + '</a></div>'
       }
   </script>";
}

function headcounters_admin(){
  add_options_page('HeadCounters', 'HeadCounters', 10, basename(__FILE__), 'headcounters_admin_panel');
}

function headcounters_admin_panel(){
?>

<form method="post" action="">
  <div class="wrap">
    <div style="border: 1px dotted #000; background: #ffffeb; padding: 10px 30px; margin: 20px 0;">
      <h2>HeadCounters Configuration</h2>
      <br />
        <strong>Name of CSS element where your counter is displayed</strong><br />
        <input type="text" name="siwp_placement" value="<?php echo get_option('headcounter_placement'); ?>" />
        -- This is usually "footer" - no need to change for most themes.
        <br /><br />
    <strong><em>Style of the counter</em></strong><br /><br />
    <strong>Font Face</strong><br />
    <input type="text" name="font_face" value="<?php echo $font_face ?>" />
    -- The font shipped with HeadCounter is called "Sansation_Regular", but many font-kits are freely available at <a href='http://www.fontsquirrel.com/' target="_new">fontsquirrel.com</a> along with a font-kit-generator. You will need to upload the additional font-kit to the plugin folder: see our FAQ for detailed instructions;

    <br /><br /><strong>Font Size (px)</strong><br />
    <input type="text" name="font_size" value="<?php echo $font_size ?>" />
    -- This is "10px" by default;

    <br /><br /><strong>Font Color</strong><br />
    <input type="text" name="font_color" value="<?php echo $font_color ?>" />
    -- This is "#000000" by default;
    
    <br /><br /><strong>Background</strong><br />
    <input type="text" name="bg_color" value="<?php echo $bg_color ?>" />
    -- This is "transparent" by default;
    
    <br /><br /><strong>Padding</strong><br />
    <input type="text" name="padding" value="<?php echo $padding ?>" />
    -- The internal space between the text and the element that displays it; "5px" by default;

    <br /><br /><strong>Border (Width & Color)</strong><br />
    <input type="text" name="border" value="<?php echo $border ?>" />
    -- This is "0px #000" by default;
    </div>
  </div>
</form>

<div class="wrap">
  <h2>HeadCounters Configuration</h2>
  <table border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Plugin Version:</td>
      <td id='version'>
      </td>
    </tr>
  </table>
  <p>
  HeadCounters was created by the friendly web developers at <a href='http://www.trueinteractive.net' target='_new'>True Interactive</a>.
  </p>
  <p>
  We strive to create flexible, easy-to-implement, and highly useful tools for web people. Our main focus is monetization; we want to help you get the best possible return on your website authoring efforts. To learn more, visit <a href='http://www.searchintegrate.com' target='_new'>Search Integrate</a>
  </p>
  May your visitors and fortunes multiply!
</div>

<?
echo "<script type=\"text/javascript\" charset=\"utf-8\">hc_installed_version = '".HEADCOUNTERS_VERSION."';</script>";
echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".HC."/version.js\"></script>"; 
?>

<script>
  var version = document.getElementById('version');
  if (hc_version == hc_installed_version){
    version.innerHTML = '<strong>up to date</strong>: v' + hc_version + ' is installed.';
  } else {
    version.innerHTML = '<strong>update to v' + hc_version + ' required </strong>: v' + hc_installed_version + ' is installed.';
  }
</script>

<?}

add_action('wp_footer', 'headcounters');
add_action('admin_menu', 'headcounters_admin');

?>