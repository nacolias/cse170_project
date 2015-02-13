<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once('adLDAP.php');
require_once("dbconn.php");
//require_once("/var/www/html/jump/filter_users.php");

$username = strtolower($_POST['username']);
$password = $_POST['password'];

$valid_usernames=array(
						"nacolias",
						"stt009",
						"crose",
						"dscornell",
						"chrafla",
						"drapp",
						"rjoyce",
						"jmadden",
						"jseddon",
						"rasullivan",
						"vpolichar",
						"hordorica",
						"crys",
						"yhicks",
						"jrapp",
						"hdhstaff",
						"wade",
						"bparent",
						"agt",
						"sosterth",
						"pcruz",
						"ncolias",
						"switucky"
					);


try
{
	if(!in_array($username,$valid_usernames))
	{
		echo false;
		exit();
	}
	else
	{

		$adldap  = new adLDAP(array('base_dn' => 'DC=AD,DC=UCSD,DC=EDU', 'use_ssl' => true, 'domain_controllers' => array("ldap.ad.ucsd.edu"), 'account_suffix' => ''));
		$authUser = $adldap->user()->authenticate("AD\\$username", $password);
		if($authUser)
		{
			$_SESSION['username'] = $username;
			$_SESSION['logged_in'] = true;
			$_SESSION['logout_time'] = strtotime("+8 hours");
		}
		else
		{
			echo $adldap->getLastError() . "\n";
		}
		echo $authUser;
	}
}
catch(adLDAPException $e) 
{
	echo $e;
	exit();
}



// $ldap = ldap_connect("ldaps://ldap.ad.ucsd.edu") or die("Could not connect to LDAP!!");
// ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
// ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

// // base DN
// $base_dn = "DC=AD,DC=UCSD,DC=EDU";

// // users that are not in the standard resnet OU that need access to this tool. must get their EXACT DN.
// $override_dns = array(
// 	"CN=s1tan,OU=bi,OU=Undergraduates,OU=Instructional Accounts,OU=Academic Computing Services,DC=AD,DC=UCSD,DC=EDU");

// // attempt to bind to ldap
// $binding_dn = "CN=$username,OU=Users,OU=ResNet,OU=Academic Computing Services,DC=AD,DC=UCSD,DC=EDU";
// foreach($override_dns as $override)
// 	if(strpos($override, $username) !== false)
// 	{
// 		$binding_dn = $override;
// 		break;
// 	}

// $bind_attempt = ldap_bind($ldap, $binding_dn, $password);
// ldap_unbind($ldap);
// if($bind_attempt)
// {
// 	$_SESSION['username'] = $username;
// 	$_SESSION['logged_in'] = true;
// 	$_SESSION['logout_time'] = strtotime("+30 minutes");
// }
// echo $bind_attempt;
?>
