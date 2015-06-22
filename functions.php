<?php

include_once "api/keys.php";
include_once "api/instagram.php";
include_once "api/youtube.php";

$instagram = new InstagramApi( $keys["instagram"] );
$youtube = new YouTubeApi( $keys["youtube"] );

add_theme_support( "post-thumbnails" );
add_image_size( "music-thumb", 350, 348, true );
add_image_size( "news-thumb", 350, 360, true );
add_image_size( "news-feat-thumb", 540, 540, true );

add_filter( "excerpt_length", "custom_excerpt_length", 999 );
function custom_excerpt_length( $length ) {
  return 12;
}
add_filter( "excerpt_more", "new_excerpt_more" );
function new_excerpt_more( $more ) {
  return "...";
}
remove_filter( "the_excerpt", "wpautop" );

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

add_action( "init", "enqueue_post_types" );
function enqueue_post_types() {

  $labels = array(
    "name"               => "Music",
    "singular_name"      => "Music",
    "menu_name"          => "Music",
    "name_admin_bar"     => "Music",
    "add_new"            => "Add New Album",
    "add_new_item"       => "Add New Album",
    "new_item"           => "New Album",
    "edit_item"          => "Edit Album",
    "view_item"          => "View Album",
    "all_items"          => "All Albums",
    "parent_item_colon"  => "Parent Album:",
    "not_found"          => "No albums found.",
    "not_found_in_trash" => "No albums found in Trash."
  );
  $args = array(
    "labels"             => $labels,
    "public"             => true,
    "publicly_queryable" => true,
    "show_ui"            => true,
    "show_in_nav_menus"  => false,
    "menu_position"      => 5,
    "menu_icon"          => "dashicons-format-audio",
    "query_var"          => true,
    "rewrite"            => array( "slug" => "music" ),
    "capability_type"    => "post",
    "has_archive"        => false,
    "supports"           => array( "title", "thumbnail", "excerpt" )
  );
  register_post_type( "music", $args );

  $labels = array(
    "name"               => "Events",
    "singular_name"      => "Event",
    "menu_name"          => "Events",
    "name_admin_bar"     => "Event",
    "add_new"            => "Add New Event",
    "add_new_item"       => "Add New Event",
    "new_item"           => "New Event",
    "edit_item"          => "Edit Event",
    "view_item"          => "View Event",
    "all_items"          => "All Events",
    "parent_item_colon"  => "Parent Events:",
    "not_found"          => "No events found.",
    "not_found_in_trash" => "No events found in Trash."
  );
  $args = array(
    "labels"              => $labels,
    "public"              => true,
    "publicly_queryable"  => true,
    "show_ui"             => true,
    "show_in_nav_menus"   => false,
    "menu_position"       => 5,
    "menu_icon"           => "dashicons-calendar-alt",
    "query_var"           => true,
    "rewrite"             => array( "slug" => "events" ),
    "capability_type"     => "post",
    "has_archive"         => false,
    "supports"            => array( "title" )
  );
  register_post_type( "events", $args );
  flush_rewrite_rules();
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
}

?>
