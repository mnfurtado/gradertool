<?php 
include_once './includes/config.php';
include_once './includes/functions_form.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


sec_session_start(); 
if(login_check($mysqli) == true) {
        // Adicione o conteúdo da sua página protegida aqui! 

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title>Grader Tool - Create Survey</title>

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

  <div class="navbar">

  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <i class="fa fa-cogs"></i>
      </button>

      <a class="navbar-brand navbar-brand-image" href="./dashboard.php">
        <img src="./img/logo.png" alt="Site Logo">
      </a>

    </div> <!-- /.navbar-header -->

    <div class="navbar-collapse collapse"> 
    
    <ul class="nav navbar-nav navbar-right">  

        <li class="dropdown navbar-profile">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
            <img src="./img/avatars/avatar-1-xs.jpg" class="navbar-profile-avatar" alt="">
            <?php echo $username; ?> 
            <i class="fa fa-caret-down"></i>
          </a>

          <ul class="dropdown-menu" role="menu">

            <li>
              <a href="./integrations.php">
                <i class="fa fa-puzzle-piece"></i> 
                Integrations
              </a>
            </li>

            <li>
              <a href="./includes/logout.php">
                <i class="fa fa-sign-out"></i> 
                &nbsp;&nbsp;Logout
              </a>
            </li>

          </ul>

        </li>

      </ul>
       

    </div> <!--/.navbar-collapse -->

  </div> <!-- /.container -->

</div> <!-- /.navbar -->

  <div class="mainbar">

  <div class="container">

    <button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">
      <i class="fa fa-bars"></i>
    </button>

    <div class="mainbar-collapse collapse">

      <ul class="nav navbar-nav mainbar-nav">

        <li class="active">
          <a href="./dashboard.php">
            <i class="fa fa-dashboard"></i>
            Dashboard
          </a>
        </li>

        <li class="dropdown">
          <a href="./leads.php">
            <i class="fa fa-rocket"></i>
            Leads
          </a>


            

    </div> <!-- /.navbar-collapse -->   

  </div> <!-- /.container --> 

</div> <!-- /.mainbar -->


<div class="container">

  <div class="content">

    <div class="content-container">

      

      <div class="content-header">
        <h2 class="content-header-title">Create New Survey</h2>
        <ol class="breadcrumb">
          <li><a href="./dashboard.php">Dashboard</a></li>
          <li class="active">Create New Survey</li>
        </ol>
      </div> <!-- /.content-header -->


      <div class="portlet">
      
        <div class="portlet-header">
      
          <h3>
            <i class="fa fa-tasks"></i>
            Survey Info
          </h3>
      
        </div> <!-- /.portlet-header -->
      
        <div class="portlet-content">
      
          <form class="form-horizontal" role="form"
          action="includes/process-create-survey.php" method="post" id="tb_survey">
                    
         <!-- <input type="hidden" name="formID" value="tb_survey" /> -->
         <input type="hidden" name="redirect_to" value="http://localhost/gradertool/dashboard.php" />
         <input type="hidden" name="survey_status" value="Online" />
         <input type="hidden" name="survey_type" value="std_grader" />
         <input type="hidden" name="id_user" value="<?php echo $user_id;?>" />
          
          <div class="form-group">
              <label class="col-md-4">Survey Name</label>

              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Let's name your child"
                name="survey_name" required>
              </div>
            </div>
                        
          <div class="form-group">
              <label class="col-md-4">Where do you want to redirect you user after answering your survey?</label>

              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="http://www.yourpage.com"
                name="survey_redirect">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4">Please provide some instructions for your lead to fill out your survey, when published.</label>

              <div class="col-md-5">
                <textarea type="text" class="form-control" placeholder="Give some instructions..."
                name="survey_instructions"></textarea>
              </div>
            </div>

            <br>
            <p>When people finish your survey, they will see a result page with their grade (from A to D) and a message accordingly to the grade. Please, write down below the text that you want your leads to see after answering your survey.</p>
            <p>Don't forget to let them know that your company will contact them to instruct them on getting better results.</p>

            <div class="form-group">
              <label class="col-md-4">If they receive the 'A' grade.</label>

              <div class="col-md-5">
                <textarea type="text" class="form-control" placeholder="Congratulate your lead..."
                name="a_grade"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4">If they receive the 'B' grade.</label>

              <div class="col-md-5">
                <textarea type="text" class="form-control" placeholder="It is good, but..."
                name="b_grade"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4">If they receive the 'C' grade.</label>

              <div class="col-md-5">
                <textarea type="text" class="form-control" placeholder="There are rooms for improvement..."
                name="c_grade"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4">If they receive the 'D' grade.</label>

              <div class="col-md-5">
                <textarea type="text" class="form-control" placeholder="Your lead seriously need you..."
                name="d_grade"></textarea>
              </div>
            </div>
      
        </div> <!-- /.portlet-content -->
      
      </div> <!-- /.portlet -->

          <question>

           <div class="portlet">
          
            <div class="portlet-header">
          
              <h3>
                <i class="fa fa-tasks"></i>
                Question
              </h3>
          
            </div> <!-- /.portlet-header -->

            
          
            <div class="portlet-content">
              
                <div class="form-group">
                  <label class="col-md-2">Question</label>

                  <div class="col-md-10">
                    <input type="text" class="form-control" placeholder="Write here your question"
                    name="desc_question[]">
                  </div>
                  <br><br>
                              
                  <label class="col-md-2">Answer #1</label>

                  <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Answer #1"
                    name="answer[]">
                  </div>
                
                
                  
                    <label class="col-md-2" for="select-input">Grade for Answer #1</label>
                    <div class="col-md-2">
                    <select id="select-input" class="form-control" name="grade[]">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                    </select>
                    </div>
                  <br>
                  
                
                  <label class="col-md-2">Answer #2</label>

                  <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Answer #2" 
                    name="answer[]">
                  </div>
                  
                    <label class="col-md-2" for="select-input">Grade for Answer #2</label>
                    <div class="col-md-2">
                    <select id="select-input" class="form-control" name="grade[]">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                    </select>
                    </div>
                  <br>
                  
                  <label class="col-md-2">Answer #3</label>

                  <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Answer #3" 
                    name="answer[]">
                  </div>
                
                
                  
                    <label class="col-md-2" for="select-input">Grade for Answer #3</label>
                    <div class="col-md-2">
                    <select id="select-input" class="form-control" name="grade[]">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                    </select>
                    </div>
                  <br>
                  
                  
                  <label class="col-md-2">Answer #4</label>

                  <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Answer #4" 
                    name="answer[]">
                  </div>
               
                
                
                    <label class="col-md-2" for="select-input">Grade for Answer #4</label>
                    <div class="col-md-2">
                    <select id="select-input" class="form-control" name="grade[]">
                      <option>0</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
                      <option>7</option>
                      <option>8</option>
                      <option>9</option>
                      <option>10</option>
                    </select>
                    </div>
                    <br>


                  </div> <!--div "form-group" -->
                  
          
            </div> <!-- /.portlet-content -->
          
          </div> <!-- /.portlet -->

          </question>
 
      <newquestion>
      </newquestion>
      
      <button type="submit" class="btn btn-success" value="submit">Save Survey</button>
      <br><br>
      
      </form>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
            $("button").click(function(){
                $("question:first").clone().appendTo("newquestion");
            });
        });
        </script>

          
          <button><i class="fa fa-plus-square"></i>  Add new question</button>

    </div> <!-- /.content-container -->
      
  </div> <!-- /.content -->

</div> <!-- /.container -->




<footer class="footer">

  <div class="container">

    <div class="row">

      <div class="col-sm-3">

        <h4>About Theme</h4>

        <br>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>  

        <hr>    

        <p>&copy; 2014 Jumpstart Themes.</p>

      </div> <!-- /.col -->

      <div class="col-sm-3"> 

        <h4>Support</h4>

        <br>

        <ul class="icons-list">
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Frequently Asked Questions</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Ask a Question</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Video Tutorial</a>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Feedback</a>
          </li>
        </ul>          

      </div> <!-- /.col -->

      <div class="col-sm-3">

        <h4>Legal</h4>

        <br>

        <ul class="icons-list">
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">License</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Terms of Use</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Privacy Policy</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Security</a>
          </li>
        </ul>          

      </div> <!-- /.col -->

      <div class="col-sm-3">

        <h4>Settings</h4>

        <br>

        <ul class="icons-list">
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Consectetur adipisicing</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Eiusmod tempor </a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Fugiat nulla pariatur</a>
          </li>
          <li>
            <i class="fa fa-angle-double-right icon-li"></i>
            <a href="javascript:;">Officia deserunt</a>
          </li>
        </ul>        



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
  


  
</body>
</html>

<?php
} else { 
        echo 'Você não está autorizado a acessar essa página, favor fazer o login.';
}

?>
