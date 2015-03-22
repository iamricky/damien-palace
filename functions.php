<?php


add_action( "wp_enqueue_scripts", "wp_styles_scripts" );
function wp_styles_scripts() {
  $template_url = get_template_directory_uri();
  $css_dir = "/assets/css/";
  $js_dir = "/assets/js/";

  global $wp_scripts;

  //CSS
  wp_enqueue_style( "master-stylesheet"
    , get_template_directory_uri() . $css_dir . "screen.css" );

  //Javascript
}

?>
