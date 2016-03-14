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
	

	// Get our fields for tb_leads

	$lead_email = mysql_real_escape_string($_POST['email']);

	//Get our fields for tb_answsurvey

	$id_survey = mysql_real_escape_string($_POST['survey_id']);

	//Get our fields for tb_response

	$id_question = ($_POST['question_id']);
	$id_answer = ($_POST['answer_id']);


	// Get our fields to process everything

	$max_grade = mysql_real_escape_string($_POST['max_grade']);



	// 1st Step - Add lead to tb_leads

	$addemail = mysql_query("SELECT email FROM tb_leads WHERE email='$lead_email'");


	if (mysql_num_rows($addemail)==0) {

		mysql_query("INSERT INTO tb_leads (email, $x_fields) VALUES ('$lead_email', '$x_values')");
 
		}

	$get_id_leads = mysql_query("SELECT * FROM tb_leads WHERE email='$lead_email'");
	$id_leads = mysql_fetch_assoc($get_id_leads);
	$lead_id = $id_leads['ID'];

	// 2nd Step - Insert data into tb_answsurvey

	mysql_query("INSERT INTO tb_answsurvey (id_leads, id_survey, $x_fields) VALUES ('$lead_id', '$id_survey', '$x_values')");
	$id_answsurvey = mysql_insert_id();

	// 3rd Step - Insert responses data

	$cont = 1;
	foreach ($id_answer as $key=>$answer) {

		$result_answer = mysql_query("SELECT tb_answers.*, tb_question.ID, tb_question.desc_question
									FROM tb_answers
									INNER JOIN tb_question
									ON tb_answers.id_question = tb_question.ID
									WHERE tb_answers.ID = $answer");
		$data_answer = mysql_fetch_assoc($result_answer);

		$question_id = $data_answer['id_question'];
		$desc_answer = $data_answer['desc_answer'];
		$desc_question = $data_answer['desc_question'];
		$score = $data_answer['grade'];

		mysql_query("INSERT INTO tb_response (id_answer, id_question, id_answsurvey, desc_answer, desc_question, score, $x_fields) 
					VALUES ('$answer', '$question_id', '$id_answsurvey', '$desc_answer', '$desc_question', '$score', '$x_values')");

	    $cont++;
	}

	// 4th Step - Update survey with final score

	$total_score = mysql_query("SELECT SUM(score) AS total_score FROM tb_response WHERE id_answsurvey = '$id_answsurvey'");
	$show_score = mysql_fetch_assoc($total_score);

	$score = $show_score['total_score'];

	$percentage = $score / $max_grade;
	

	if ($percentage >= 0.75){

		$grade = "A";

	} elseif ($percentage >= 0.5 and $percentage < 0.75) {

		$grade = "B";

	} elseif ($percentage >= 0.25 and $percentage < 0.5) {

		$grade = "C";

	} else {

		$grade = "D";
	}

	mysql_query("UPDATE tb_answsurvey SET score = '$score', grade = '$grade' WHERE ID = '$id_answsurvey'");

	/*Close our database connection.*/
	mysql_close();

	/*Redirect the user after a successful form submission*/
	if ( !empty ( $redirect ) ) {
		header("Location: $redirect?id=$id_answsurvey");
	} else {
		header("Location: $referred?msg=1");
	}
} else {
	die('You are not allowed to submit data to this form');
}
?>