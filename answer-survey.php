<?php 
include_once 'includes/db_connect.php';
include_once './includes/config.php';
include_once './includes/functions.php';

$id_survey = $_GET['id'];

connect_db();


$result_survey = mysql_query("SELECT * FROM tb_survey WHERE ID = $id_survey");
$data_survey = mysql_fetch_assoc($result_survey);

$user_id = $data_survey['id_user'];

$result_api = mysql_query("SELECT * FROM tb_api WHERE id_user = $user_id");
$data_api = mysql_fetch_assoc($result_api);

/*
// fetch all questions into one big array

$result_question = mysql_query("SELECT * FROM tb_question WHERE id_survey = $id_survey");
 
$allQuestion = array();
while ($row = mysql_fetch_array($result_question))
{
  $allQuestion[] = $row['desc_question'];
}

foreach ($allQuestion as $key => $value){
  $retrieve_id = mysql_fetch_assoc($result_question);
  $id_question = ['id_question'];
  echo $value;
  echo $id_question;
  echo "<br><br>";
}*/

$result_question = mysql_query("SELECT * FROM tb_question WHERE id_survey = $id_survey");
$row_question = mysql_num_rows($result_question);


/*
$result_question = mysql_query("SELECT * FROM tb_answers WHERE id_question = $id_question");
 
                      $allAnswers = array();
                      while ($row = mysql_fetch_array($result_question))
                      {
                        $allAnswers[] = $row['desc_question'];
                      }

                      foreach ($allAnswers as $key_answ => $value_answ){

                          echo $value_answ;
                          echo "<br>";

                        }


*/

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title>Grader Tool - Answer Survey</title>

  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
  <link rel="stylesheet" href="./css/font-awesome.min.css">
  <link rel="stylesheet" href="./js/libs/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">

  <!-- Plugin CSS -->
  <link rel="stylesheet" href="./js/plugins/morris/morris.css">
  <link rel="stylesheet" href="./js/plugins/icheck/skins/minimal/blue.css">
  <link rel="stylesheet" href="./js/plugins/select2/select2.css">
  <link rel="stylesheet" href="./js/plugins/fullcalendar/fullcalendar.css">

  <!-- App CSS -->
  <link rel="stylesheet" href="./css/target-admin.css">
  <link rel="stylesheet" href="./css/custom.css">


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>

<body>

<!-- INICIO MENU PRINCIPAL -->

  <div class="mainbar">

  <div class="container">

    <button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">
      <i class="fa fa-bars"></i>
    </button>

    <div class="mainbar-collapse collapse">



    </div> <!-- /.navbar-collapse -->   

  </div> <!-- /.container --> 

</div> <!-- /.mainbar -->

<!-- FIM MENU PRINCIPAL -->


<div class="container">

  <div class="content">

    <div class="content-container">

      

      <div class="content-header">
        <h2 class="content-header-title"><?php echo $data_survey['survey_name']; ?></h2>
      </div> <!-- /.content-header -->
      
      <p><?php echo $data_survey['survey_instructions']; ?></p>
      <br>

      <form class="form-horizontal" role="form"
          action="includes/process-answer-survey.php" method="post">
                    
        <input type="hidden" name="redirect_to" value="../dashboard.php"/>
        <input type="hidden" name="survey_id" value="<?php echo $data_survey['ID']; ?>" />
        <input type="hidden" name="max_grade" value="<?php echo $data_survey['max_grade']; ?>" />
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
          
          <div class="form-group">
              <label class="col-md-2">E-mail*</label>

              <div class="col-md-5">
                <input type="email" class="form-control" placeholder="Type your e-mail to receive the survey."
                name="email" required>
              </div>
            </div>
       
      <br>

      <?php

      for ($x=0; $x < $row_question;$x++){

        $data_question = mysql_fetch_array($result_question);
        $id_question = $data_question['ID'];
        $desc_question = $data_question['desc_question'];

      ?>
      
      <label for="select-input"><h4><?php echo $desc_question; ?>*</h4></label>
      <input type="hidden" name="question_id[]" value="<?php echo $data_question['ID']; ?>" required/>

              <select id="select-input" class="form-control" name="answer_id[]">

              <!-- FETCH POSSIBLE ANSWERS FROM QUESTION -->
              <?php
                $result_answer = mysql_query("SELECT * FROM tb_answers WHERE id_question = $id_question");
                $row_answer = mysql_num_rows($result_answer);

                for ($y=0; $y < $row_answer; $y++){  

                  $data_answer = mysql_fetch_array($result_answer);                  

                  ?>

                  <option value="<?php echo $data_answer['ID']; ?>"><?php echo $data_answer['desc_answer']; ?></option>

                <?php
                              


      }?>

                </select>
      
      <br><br>

      <?php } ?>
      
      <button type="submit" class="btn btn-success" value="submit">See Results</button>
      
      </form>



    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->




<footer class="footer">

  <div class="container">

    <div class="row">

      <div class="col-sm-12">

        <h4>Grader Tool</h4>

        <br>

        <p>Built with the <a href="http://www.gradertool.com" target="_blank">Grader Tool</a></p>  

        <hr>    

        <p>&copy; 2016 Grader Tool.</p>

      </div> <!-- /.col -->


    </div> <!-- /.row -->

  </div> <!-- /.container -->
  
  
  
</footer>

  <script src="./js/libs/jquery-1.10.1.min.js"></script>
  <script src="./js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="./js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->
  <!-- App JS -->
  <script src="./js/target-admin.js"></script>
  

  <!-- RD STATION INTEGRATION -->
  <script type="text/javascript" src="https://d335luupugsy2.cloudfront.net/js/integration/stable/rd-js-integration.min.js"></script> 
  <script type="text/javascript">
   RdIntegration.integrate('<?php echo $data_api['token_rdstation']; ?>', 'Grader Tool'); 
  </script>

  
</body>
</html>
