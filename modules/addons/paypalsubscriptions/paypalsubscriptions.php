<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

function paypalsubscriptions_config() {
    $configarray = array(
    "name" => "PayPal Subscriptions",
    "description" => "This module will help you identify PayPal Subscription that have not been cancelled, when the service has.",
    "version" => "1.0",
    "author" => "zFast Technologies Ltd",
    "language" => "english",
    "fields" => array(
        //"apiusername" => array ("FriendlyName" => "API Username", "Type" => "text", "Size" => "30", "Description" => "Paypal API Username", "Default" => "user_api1.paypal.com", ),
        //"apipassword" => array ("FriendlyName" => "API Password", "Type" => "password", "Size" => "30", "Description" => "Paypal API Password", ),
        //"apisignature" => array ("FriendlyName" => "API Signature", "Type" => "password", "Size" => "50", "Description" => "Paypal API Signature", ),
    ));
    return $configarray;
}

function paypalsubscriptions_activate() {
	
	$return = array('status'=>'success','description'=>'PayPal Subscriptions Activated');

	return $return;

}

function paypalsubscriptions_deactivate() {

	$return = array('status'=>'success','description'=>'PayPal Subscriptions De-activated');

	
	return $return;

}

function paypalsubscriptions_upgrade($vars) {

    $version = $vars['version'];

}

function paypalsubscriptions_output($vars) {

    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
	
	if($_GET['filter'] == "uncancelled") {
		$query = "SELECT DISTINCT tblhosting.id, tblhosting.domain, tblhosting.subscriptionid, tblhosting.nextduedate, tblhosting.domainstatus FROM tblhosting, tblinvoiceitems, tblaccounts WHERE tblhosting.id = tblinvoiceitems.relid AND tblaccounts.invoiceid = tblinvoiceitems.invoiceid AND tblhosting.subscriptionid != '' AND tblaccounts.date >= tblhosting.nextduedate";
	} elseif($_GET['filter'] == "active") {
		$query = "SELECT DISTINCT tblhosting.id, tblhosting.domain, tblhosting.subscriptionid, tblhosting.nextduedate, tblhosting.domainstatus FROM tblhosting WHERE tblhosting.subscriptionid != '' AND tblhosting.domainstatus = 'Active'";
	} elseif($_GET['filter'] == "cancelled") {
		$query = "SELECT DISTINCT tblhosting.id, tblhosting.domain, tblhosting.subscriptionid, tblhosting.nextduedate, tblhosting.domainstatus FROM tblhosting WHERE tblhosting.subscriptionid != '' AND tblhosting.domainstatus = 'Cancelled'";
	} elseif($_GET['filter'] == "terminated") {
		$query = "SELECT DISTINCT tblhosting.id, tblhosting.domain, tblhosting.subscriptionid, tblhosting.nextduedate, tblhosting.domainstatus FROM tblhosting WHERE tblhosting.subscriptionid != '' AND tblhosting.domainstatus = 'Terminated'";
	} elseif($_GET['filter'] == "suspended") {
		$query = "SELECT DISTINCT tblhosting.id, tblhosting.domain, tblhosting.subscriptionid, tblhosting.nextduedate, tblhosting.domainstatus FROM tblhosting WHERE tblhosting.subscriptionid != '' AND tblhosting.domainstatus = 'Suspended'";
	} else {
		$query = "SELECT DISTINCT tblhosting.id, tblhosting.domain, tblhosting.subscriptionid, tblhosting.nextduedate, tblhosting.domainstatus FROM tblhosting WHERE tblhosting.subscriptionid != ''";
	}
	
	echo "<p><a style=\"text-decoration: none;\" class=\"btn\" href=\"{$modulelink}\">All</a>  
			<a style=\"text-decoration: none;\" class=\"btn\" href=\"{$modulelink}&filter=active\">Active</a> 
			<a style=\"text-decoration: none;\" class=\"btn\" href=\"{$modulelink}&filter=cancelled\">Cancelled</a> 
			<a style=\"text-decoration: none;\" class=\"btn\" href=\"{$modulelink}&filter=terminated\">Terminated</a> 
			<a style=\"text-decoration: none;\" class=\"btn\" href=\"{$modulelink}&filter=suspended\">Suspended</a>
			<a style=\"text-decoration: none;\" class=\"btn\" href=\"{$modulelink}&filter=uncancelled\">Uncancelled</a></p>";
	
	echo "<table class=\"datatable\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">";

	echo "<tr><th>Service</th><th>Domain</th><th>Subscription</th><th>Next Due Date</th><th>Status</th></tr>";
	
	$result = mysql_query($query);
	
	while($row = mysql_fetch_array($result)) {
		echo "<tr><td><a href=\"clientshosting.php?id={$row['id']}\" target=\"_blank\">{$row['id']}</a></td><td>{$row['domain']}</td><td>{$row['subscriptionid']}</td><td>{$row['nextduedate']}</td><td>{$row['domainstatus']}</td></tr>";
	}
	
	echo "</table>";
	

}

function paypalsubscriptions_sidebar($vars) {
	
	$sidebar = "";
	
    return $sidebar;

}

?>