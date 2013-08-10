<?php
/*
Plugin Name: WP Server Roots Rewrites
Plugin URI: http://github.com/leoj3n/wp-server-roots-rewrites
Description: Redirect requests when using `wp server`, as would normally be done under Apache.
Version: 0.1.0
Author: leoj3n
Author URI: http://twitter.com/leoj3n
*/

$root = $_SERVER['DOCUMENT_ROOT'];
$path = '/'. ltrim( parse_url( $_SERVER['REQUEST_URI'] )['path'], '/' );

if ( ! file_exists( $root.$path ) ) {
  $roots_new_non_wp_rules = array(
    '(/assets/(.*))'  => '/wp-content/themes/roots/assets/$1',
    '(/plugins/(.*))' => '/wp-content/plugins/$1'
  );

  $path = preg_replace(
    array_keys($roots_new_non_wp_rules),
    array_values($roots_new_non_wp_rules),
    $path
  );

  if (file_exists($root . $path)) {
    header("Location: {$path}");
    exit;
  }
}

