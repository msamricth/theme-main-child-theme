<?php 
/**
 * Child Theme Functions
 */


 $theme_enqueue = __DIR__ . '/inc/enqueue.php';
 if ( is_readable( $theme_enqueue ) ) {	require_once $theme_enqueue;}
 
 
 
 $theme_forms = __DIR__ . '/inc/forms.php';
 if ( is_readable( $theme_forms ) ) {	require_once $theme_forms;}
 
 
 
  