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
  list($font_face, $font_size, $font_color, $bg_color, $padding, $border, $hover, $margin, $width, $align) = explode('|', get_option('headcounters_style'));
echo  "<style>
  @font-face {
    font-family: 'HeadCounters';
    src: url('./wp-content/plugins/headcounters/fonts/{$font_face}-webfont.eot');
    src: local('☺'), url('./wp-content/plugins/headcounters/fonts/{$font_face}-webfont.woff') format('woff'), url('./wp-content/plugins/headcounters/fonts/{$font_face}-webfont.ttf') format('truetype'), url('./wp-content/plugins/headcounters/fonts/{$font_face}-webfont.svg#webfontWcAYDrv2') format('svg');
    font-weight: normal;
    font-style: normal;
  }
  a.headcounters {
    font: {$font_size} 'HeadCounters', Arial, sans-serif; 
    color:{$font_color}; 
    background:{$bg_color};
    padding:{$padding};
    margin:{$margin};
    border:{$border} solid;
    width:{$width};
    text-align:{$align};
    display:block;
  }
  a.headcounters:hover {color:{$hover};}
</style>\n";
}

add_action('wp_head', 'headcounters_css');

function headcounters(){
  list($position,$is_txt,$label) = explode('|', get_option('headcounters_base'));
  if(!$position){
    $position = 'footer';
    $is_txt   = 'false';
  }
  if ($is_txt == 'false') {
    echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".HC."/wp.js\"></script>";
    echo "
      <script type=\"text/javascript\" charset=\"utf-8\">
        var footer = document.getElementById('{$position}');
        if (typeof(headcounters_content)!='undefined' && footer != null){
          footer.innerHTML += headcounters_content;
        }
      </script>";
  } else {  
    echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".HC."/wp_count.js\"></script>";
    echo "
    <script type=\"text/javascript\" charset=\"utf-8\">
         var head_counter = document.getElementById('{$position}');
         if (typeof(wp_count)!='undefined' && head_counter != null){
           head_counter.innerHTML += '<div class=\"headcounters\"><a class=\"headcounters\" href=\"http://headcounters.com\" title=\"HeadCounters - Wondering how many people are on your page? You can finally know!\">{$label} ' + wp_count + '</a></div>'
         }
     </script>";
    }
}

function headcounters_admin(){
  add_options_page('HeadCounters', 'HeadCounters', 10, basename(__FILE__), 'headcounters_admin_panel');
}

function headcounters_admin_panel(){
  if ($_POST['is_txt']){
    update_option('headcounters_style', "{$_POST['font_face']}|{$_POST['font_size']}|{$_POST['font_color']}|{$_POST['bg_color']}|{$_POST['padding']}|{$_POST['border']}|{$_POST['hover']}|{$_POST['margin']}|{$_POST['width']}|{$_POST['align']}");
    update_option('headcounters_base', "{$_POST['position']}|{$_POST['is_txt']}|{$_POST['label']}");
    echo '<div id="setting-error-settings_updated" class="updated settings-error"> 
    <p><strong>Settings saved.</strong></p></div>';
  }
  if (!get_option('headcounters_base')){ add_option('headcounters_base', 'footer|false|Online Users:'); }
  if (!get_option('headcounters_style')){ add_option('headcounters_style', 'Sansation_Regular|11px|#000000|transparent|5px|0px #000000|#DD0000|5px|auto|auto');}
  list($font_face, $font_size, $font_color, $bg_color, $padding, $border, $hover, $margin, $width, $align) = explode('|', get_option('headcounters_style'));
  list($position,$is_txt, $label) = explode('|', get_option('headcounters_base'));
?>

<form method="post" action="">
  <div class="wrap">
    <div style="border: 1px dotted #000; background: #ffffeb; padding: 10px 30px; margin: 20px 0;">
      <h2>HeadCounters Configuration</h2>
      <strong><u>Main Configuration</u></strong><br />
      <br /><strong>HeadCounter Type:</strong><br />
      <input type="radio" name="is_txt" value="false" <? if ($is_txt == 'false') echo 'checked' ?>>&nbsp;HC Classic&trade; Counter&nbsp;
      <img src='../wp-content/plugins/headcounters/images/headcounters_example.png'>
      <br>
      <input type="radio" name="is_txt" value="true" <? if ($is_txt == 'true') echo 'checked' ?>> <em>Text-Based</em> Counter (completely configurable!)
            
      <br /><br />
        <strong>Name of CSS element where your counter is displayed</strong><br />
        <input type="text" name="position" value="<?php echo $position ?>" />
        -- This is usually "footer" - no need to change for most themes.
        <br /><br />
    <strong><u><em>Style for <em>Text-Based</em> Counter</em></u></strong><br /><br />
    
    <strong>Label</strong><br />
    <input type="text" name="label" value="<?php echo $label ?>" />
    -- This is "Online Users:" by default;
    
    <br /><br />
    <strong>Font Face</strong><br />
    <input type="text" name="font_face" value="<?php echo $font_face ?>" />
    -- The font shipped with HeadCounter is called "Sansation_Regular", but many font-kits are freely available at <a href='http://www.fontsquirrel.com/' target="_new">fontsquirrel.com</a> along with a font-kit-generator. You will need to upload the additional font-kit to the plugin folder: see our FAQ for detailed instructions;

    <br /><br /><strong>Font Size (px)</strong><br />
    <input type="text" name="font_size" value="<?php echo $font_size ?>" />
    -- This is "11px" by default;

    <br /><br /><strong>Font Color</strong><br />
    <input type="text" name="font_color" value="<?php echo $font_color ?>" />
    -- This is "#000000" by default;
    
    <br /><br /><strong>Font 'MouseOver' Color</strong><br />
    <input type="text" name="hover" value="<?php echo $hover ?>" />
    -- This is "0px #DD0000" by default;
    
    <br /><br /><strong>Text Align</strong><br />
    <input type="text" name="align" value="<?php echo $align ?>" />
    -- This is "auto" by default; Options are: auto, left, right or center;

    <br /><br /><strong>Width</strong><br />
    <input type="text" name="width" value="<?php echo $width ?>" />
    -- This is "auto" by default;

    <br /><br /><strong>Background</strong><br />
    <input type="text" name="bg_color" value="<?php echo $bg_color ?>" />
    -- This is "transparent" by default;
    
    <br /><br /><strong>Padding</strong><br />
    <input type="text" name="padding" value="<?php echo $padding ?>" />
    -- The internal space between the text and the element that displays it; "5px" by default;

    <br /><br /><strong>Margin</strong><br />
    <input type="text" name="margin" value="<?php echo $margin ?>" />
    -- The space around the counter; "5px" by default;

    <br /><br /><strong>Border (Width & Color)</strong><br />
    <input type="text" name="border" value="<?php echo $border ?>" />
    -- This is "0px #000000" by default;
    
    <br /><br />
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </form>
    </div>

  </div>

<div class="wrap">
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
  <p>May your visitors and fortunes multiply!</p>
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