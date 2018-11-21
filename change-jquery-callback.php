<?php

/* Change jquery callback */
function change_jquery_cdn() { 
  $jquery_version = wp_scripts()->registered['jquery']->ver;
  wp_deregister_script('jquery');
  wp_register_script(
    'jquery', 'https://code.jquery.com/jquery-' . $jquery_version . '.min.js', [], null, true );
  add_filter('script_loader_src', 'local_jquery_help', 10, 2);
}
add_action('wp_enqueue_scripts', 'change_jquery_cdn', 100);

/* Local jquery callback */
function local_jquery_help($path, $jquery_callback = null) {
  static $hel_jquery = false;
  if ($hel_jquery) {
    echo '<script>(window.jQuery && jQuery.noConflict()) || document.write(\'<script src="' . $hel_jquery .'"><\/script>\')</script>' . "\n";
    $hel_jquery = false;
  }
  if ($jquery_callback === 'jquery') {
    $hel_jquery = get_bloginfo('url') .'/app/scripts/jquery.js'; 
  }
  return $path;
}
add_action('wp_head','local_jquery_help');