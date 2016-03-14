<?php
include_once 'config.php';

/*Checks the validity of the retrieved IP address.*/
function f_validIP($ip) {
 
	if (!empty($ip) && ip2long($ip)!=-1) {
		$reserved_ips = array (	 
			array('0.0.0.0','2.255.255.255'),		 
			array('10.0.0.0','10.255.255.255'),		 
			array('127.0.0.0','127.255.255.255'),		 
			array('169.254.0.0','169.254.255.255'),		 
			array('172.16.0.0','172.31.255.255'),		 
			array('192.0.2.0','192.0.2.255'),		 
			array('192.168.0.0','192.168.255.255'),		 
			array('255.255.255.0','255.255.255.255')	 
		);
	 
		foreach ($reserved_ips as $r) { 
			$min = ip2long($r[0]);			 
			$max = ip2long($r[1]);			 
			if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
		
		return true;
	} else {
		return false;
	}
 }

/*Gets the IP address of the current user for storage in the database.*/
function f_getIP() {
	if (f_validIP($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	 
	foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {	 
		if (f_validIP(trim($ip))) {		 
			return $ip;		 
		}	 
	}
	 
	if (f_validIP($_SERVER["HTTP_X_FORWARDED"])) { 
		return $_SERVER["HTTP_X_FORWARDED"];	 
	} elseif (f_validIP($_SERVER["HTTP_FORWARDED_FOR"])) {	 
		return $_SERVER["HTTP_FORWARDED_FOR"];	 
	} elseif (f_validIP($_SERVER["HTTP_FORWARDED"])) {	 
		return $_SERVER["HTTP_FORWARDED"];	 
	} elseif (f_validIP($_SERVER["HTTP_X_FORWARDED"])) {	 
		return $_SERVER["HTTP_X_FORWARDED"];	 
	} else {
		return $_SERVER["REMOTE_ADDR"];	 
	}
 }


/*Cleans an array to protect against injection attacks.*/
function f_clean($array) {
    return array_map('mysql_real_escape_string', $array);
}

/*Connects to and selects the specified database with the specified user.*/
function f_sqlConnect($user, $pass, $db) {
	$link = mysql_connect('localhost', $user, $pass);

	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}

	$db_selected = mysql_select_db($db, $link);

	if (!$db_selected) {
		die('Can\'t use ' . $db . ': ' . mysql_error());
	}
}

/*Checks to see if the specified table exists and if it doesn't, creates it.*/
function f_tableExists($tablename, $database = false) {

    if(!$database) {
        $res = mysql_query("SELECT DATABASE()");
        $database = mysql_result($res, 0);
    }

    $res = mysql_query("
        SELECT COUNT(*) AS count 
        FROM information_schema.tables 
        WHERE table_schema = '$database' 
        AND table_name = '$tablename'
    ");

    return mysql_result($res, 0) == 1;

}

/*Checks to see if the specified field exists and if it doesn't, creates it.*/
function f_fieldExists($table, $column, $column_attr = "VARCHAR( 255 ) NULL" ) {
	$exists = false;
	$columns = mysql_query("show columns from $table");
	while($c = mysql_fetch_assoc($columns)){
		if($c['Field'] == $column){
			$exists = true;
			break;
		}
	}
	if(!$exists){
		mysql_query("ALTER TABLE `$table` ADD `$column`  $column_attr");
	}
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}


?>

<!-- add dinamically a field -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>