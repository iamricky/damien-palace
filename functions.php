<?php

include_once "api/keys.php";
include_once "api/instagram.php";
include_once "api/youtube.php";

$instagram = new InstagramApi( $keys["instagram"] );
$youtube = new YouTubeApi( $keys["youtube"] );

add_action( "wp_enqueue_scripts", "enqueue_assets" );
function enqueue_assets() {
  $temp_dir   = get_template_directory_uri();
  $bower_dir  = "${temp_dir}/bower_components";

  $css_dir    = "${temp_dir}/assets/css";
  $js_dir     = "${temp_dir}/assets/js";

  $fancybox   = "${bower_dir}/fancybox/source";
  $fit_text   = "${bower_dir}/FitText.js";
  $mustache   = "${bower_dir}/mustache";

  // css
  wp_enqueue_style( "my-stylesheet", "${css_dir}/my.css" );
  wp_enqueue_style( "fancybox-css", "${fancybox}/jquery.fancybox.css" );

  // javascript
  wp_enqueue_script( "my-js", "${js_dir}/my.js", array( "jquery" ), false, true );
  wp_enqueue_script( "fancybox-js", "${fancybox}/jquery.fancybox.pack.js", array( "jquery" ), false, true );
  wp_enqueue_script( "fancybox-media", "${fancybox}/helpers/jquery.fancybox-media.js", array( "fancybox-js" ), false, true );
  wp_enqueue_script( "fit-text", "${fit_text}/jquery.fittext.js", array( "my-js" ), false, true );
  wp_enqueue_script( "mustache", "${mustache}/mustache.js", array( "my-js" ), false, true );

  // ajax url
  wp_localize_script( "my-js", "wp_urls", array(
      "ajax_url"      => admin_url( "admin-ajax.php" ),
      "template_url"  => $temp_dir
    )
  );
}
add_action( "wp_ajax_nopriv_query_photos", "my_photo_query" );
add_action( "wp_ajax_query_photos", "my_photo_query" );
function my_photo_query() {

  global $instagram;
  $data = $instagram->query_photos();

  echo $data;

  wp_die();
}
add_action( "wp_ajax_nopriv_query_pagination", "my_pagination_query" );
add_action( "wp_ajax_query_pagination", "my_pagination_query" );
function my_pagination_query() {

  global $instagram;
  $data = $instagram->pagination_query();

  echo $data;

  wp_die();
}
add_action( "wp_ajax_nopriv_query_videos", "my_video_query" );
add_action( "wp_ajax_query_videos", "my_video_query" );
function my_video_query() {

  global $youtube;
  $data = $youtube->query_videos();

  echo $data;

  wp_die();
} ?>
