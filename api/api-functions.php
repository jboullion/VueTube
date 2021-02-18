<?php 
/**
 * Various helper functions used throughout the API
 */

 /**
  * Get the current subdomain string
  *
  * @return string
  */
function get_current_subdomain(){
	$host = explode('.', $_SERVER['HTTP_HOST']);
	//$subdomain = $host[0];
	return $host[0];
}