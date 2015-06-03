<?php

include_once "api/instagram.php";
include_once "api/youtube.php";

add_action( "wp_enqueue_scripts", "enqueue_assets" );
function enqueue_assets() {
  $temp_dir   = get_template_directory_uri();
  $css_dir    = "${temp_dir}/assets/css";
  $js_dir     = "${temp_dir}/assets/js";
  $bower_dir  = "${temp_dir}/bower_components";

  wp_enqueue_style( "my-stylesheet", "${css_dir}/my.css" );

  // javascript
  wp_enqueue_script( "my-js", "${js_dir}/my.js", array( "jquery" ), "1", true );
  wp_enqueue_script( "fit-text", "${bower_dir}/FitText.js/jquery.fittext.js", array( "my-js" ), "1.2.0", true );

  wp_localize_script( "my-js", "the_api", array(
      "ajax_url" => admin_url( "admin-ajax.php" )
    )
  );
}
add_action( "wp_ajax_nopriv_query_photos", "my_photo_query" );
add_action( "wp_ajax_query_photos", "my_photo_query" );
function my_photo_query() {

  $instagram = new InstagramApi();
  $data = $instagram->query_photos();

  echo $data;

  wp_die();
}
add_action( "wp_ajax_nopriv_query_videos", "my_video_query" );
add_action( "wp_ajax_query_videos", "my_video_query" );
function my_video_query() {

  $youtube = new YouTubeApi();
  $data = $youtube->query_videos();

  echo $data;

  wp_die();
} ?>
