<?php
require_once('config.php');
require_once('functions_form.php');

/*Check to see if the form was submitted from the installed domain. If so,
process the data. If not, kill the script. Obviously, you can disable this, but
it's strongly recommended that you keep this check in place.*/
$domain = $_SERVER['HTTP_HOST'];
$uri = parse_url($_SERVER['HTTP_REFERER']);
$r_domain = $uri['host'];

if ( $domain == $r_domain ) {

	/*Open the connection to our database use the info from the config file.*/
	$link = f_sqlConnect(DB_USER, DB_PASSWORD, DB_NAME);
	
	/*This cleans our &_POST array to prevent against SQL injection attacks.*/
	//$_POST = f_clean($_POST);
	
	/*These are the main variables we'll use to process the form.*/
	//$keys = implode(", ", (array_keys($_POST))); 
	//$values = implode("', '", (array_values($_POST)));

	/*These are variables for our redirect.*/
	$redirect = $_POST['redirect_to'];
	$referred = $_SERVER['HTTP_REFERER'];
	$query = parse_url($referred, PHP_URL_QUERY);
	$referred = str_replace(array('?', $query), '', $referred);
	

	/*Get our fields*/
	
	
	$id_user = mysql_real_escape_string($_POST['id_user']);
	$token_rdstation = mysql_real_escape_string($_POST['token_rdstation']);
	$token_pipedrive = mysql_real_escape_string($_POST['token_pipedrive']);
	$funel_pipedrive = mysql_real_escape_string($_POST['funel_pipedrive']);
	$register = mysql_real_escape_string($_POST['register']);
	


	if ($register == 0) {

		mysql_query("INSERT INTO tb_api (id_user, token_rdstation, token_pipedrive, funel_pipedrive) 
	VALUES ('$id_user', '$token_rdstation', '$token_pipedrive', '$funel_pipedrive')");

} else { 

	mysql_query("UPDATE tb_api SET token_rdstation='$token_rdstation', token_pipedrive='$token_pipedrive', funel_pipedrive='$funel_pipedrive' 
		WHERE id_user = '$id_user' ");


}
	/*Close our database connection.*/
	mysql_close();

	/*Redirect the user after a successful form submission*/
	if ( !empty ( $redirect ) ) {
		header("Location: $redirect?msg=1");
	} else {
		header("Location: $referred?msg=1");
	}
} else {
	die('You are not allowed to submit data to this form');
}
?>