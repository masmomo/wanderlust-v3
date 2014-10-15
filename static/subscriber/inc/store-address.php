<?php
/*///////////////////////////////////////////////////////////////////////
Part of the code from the book 
Building Findable Websites: Web Standards, SEO, and Beyond
by Aarron Walter (aarron@buildingfindablewebsites.com)
http://buildingfindablewebsites.com

Distrbuted under Creative Commons license
http://creativecommons.org/licenses/by-sa/3.0/us/
///////////////////////////////////////////////////////////////////////*/


function storeAddress(){
	
	// Validation
	if(!$_GET['email_chimp']){ return "<p class=\"alert alert-danger\">No email address provided</p>"; } 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_GET['email_chimp'])) {
		return "<p class=\"alert alert-danger\">Email address is invalid</p>"; 
	}

	require_once('MCAPI.class.php');
	// grab an API Key from http://admin.mailchimp.com/account/api/
	$api = new MCAPI('3ac08219253c93954c9ebcdd1ece99c5-us9');
	
	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
	$list_id = "58cdcf476d";

	if($api->listSubscribe($list_id, $_GET['email_chimp'], '') === true) {
		// It worked!	
		return '<p class="alert alert-success">Success! Check your email to confirm sign up.</p>';
	}else{
		// An error ocurred, return error message	
		return '<p class="alert alert-danger">Error: ' . $api->errorMessage.'</p>';
	}
	
}

// If being called via ajax, autorun the function
if($_GET['ajax']){ echo storeAddress(); }
?>
