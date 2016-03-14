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
	
	/*These are the extra data fields we'll collect on form submission.*/
	
	$x_fields = 'timestamp';
	$x_values = time();
	

	/*Get our fields*/
	
	
	$survey_name = mysql_real_escape_string($_POST['survey_name']);
	$survey_redirect = mysql_real_escape_string($_POST['survey_redirect']);
	$survey_instructions = mysql_real_escape_string($_POST['survey_instructions']);
	$survey_status = mysql_real_escape_string($_POST['survey_status']);
	$survey_type = mysql_real_escape_string($_POST['survey_type']);
	$id_user = mysql_real_escape_string($_POST['id_user']);
	$a_grade = mysql_real_escape_string($_POST['a_grade']);
	$b_grade = mysql_real_escape_string($_POST['b_grade']);
	$c_grade = mysql_real_escape_string($_POST['c_grade']);
	$d_grade = mysql_real_escape_string($_POST['d_grade']);

	//Arrays dos campos Perguntas, Respostas e Notas
	$desc_question = $_POST['desc_question'];
	$desc_answer = $_POST['answer'];
	$grade = $_POST['grade'];
	
	//Slug
	$survey_slug = slugify("$survey_name"."-origin-"."$id_user");

	//Set maximum grade (10 x number of questions)

	$max_grade = count($desc_question)*10;
	

	/*Insert out values into the database*/
	mysql_query("INSERT INTO tb_survey (survey_name, survey_redirect, survey_instructions, survey_status, survey_type, survey_slug, id_user, a_grade, b_grade, c_grade, d_grade, max_grade, $x_fields) 
	VALUES ('$survey_name', '$survey_redirect', '$survey_instructions', '$survey_status', '$survey_type', '$survey_slug', '$id_user', '$a_grade', '$b_grade', '$c_grade', '$d_grade', '$max_grade', '$x_values')");
    $id_survey = mysql_insert_id();
    
	

    //Array
    //print_r($desc_question);
    //echo "<br>";

    $array_question = array();

    //Insert question individually to tb_question
    $cont = 1;
	foreach ($desc_question as $key=>$question) {
	    mysql_query("INSERT INTO tb_question (desc_question, id_survey, $x_fields) 
	VALUES ('$question', '$id_survey', '$x_values')");
	    
		$id_question = mysql_insert_id();
		
		array_push($array_question, $id_question, $id_question, $id_question, $id_question);


	    $cont++;
	}


	//Add answers indexed by questions

	$cont = 1;
	foreach ($array_question as $key => $value) {

		mysql_query("INSERT INTO tb_answers (desc_answer, grade, id_question, $x_fields) 
	VALUES ('$desc_answer[$key]', '$grade[$key]', '$array_question[$key]', '$x_values')");

	    $cont++;

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