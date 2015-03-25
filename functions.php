<?php


add_action( "wp_enqueue_scripts", "wp_styles_scripts" );
function wp_styles_scripts() {
  $temp_dir   = get_template_directory_uri();
  $css_dir    = "/assets/css/";
  $js_dir     = "/assets/js/";

  global $wp_scripts;

  //CSS
  wp_enqueue_style( "master-stylesheet", $temp_dir . $css_dir . "screen.css" );

  //Javascript
}

?>
