<?php
/*
Plugin Name: HeadCounters
Plugin URI: http://headcounters.com/
Description: Wondering how many people are on your page? You can finally know!
Version: 1.0.1
Author: Tozzato-Johnson-Rabinowitz
Author URI: http://headcounters.com/
*/

define('HEADCOUNTERS_VERSION', '1.0.1');

define('HC', 'http://app.headcounters.com');

function headcounters_css(){
  echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"./wp-content/plugins/headcounters/headcounters.css\">";
}

add_action('wp_head', 'headcounters_css');

function headcounters(){
    echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".HC."/wp.js\"></script>";
    echo "
      <script type=\"text/javascript\" charset=\"utf-8\">
        var footer = document.getElementById('footer');
        if(footer == null){
          var footer = document.getElementById('wp-footer');
        }
        if(footer == null){
          var footer = document.body
        }
        if (typeof(headcounters_content)!='undefined' && footer != null){
          footer.innerHTML += headcounters_content;
        }
      </script>";
}

function headcounters_admin(){
  add_options_page('HeadCounters', 'HeadCounters', 10, basename(__FILE__), 'headcounters_admin_panel');
}

function headcounters_admin_panel(){
?>

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