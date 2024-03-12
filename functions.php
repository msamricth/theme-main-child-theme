<?php 
/**
 * Child Theme Functions
 */


 $theme_enqueue = __DIR__ . '/inc/enqueue.php';
 if ( is_readable( $theme_enqueue ) ) {	require_once $theme_enqueue;}