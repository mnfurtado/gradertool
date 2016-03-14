<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/config.php';

sec_session_start(); 
if(login_check($mysqli) == true) {
        // Adicione o conteúdo da sua página protegida aqui! 

  $user_id = $_SESSION['user_id'];
  $username = $_SESSION['username'];


/*Open the connection to our database use the info from the config file.*/
$link = mysql_connect($host, $user, $password);

if (!$link) {
  die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('dbgradertoolapp', $link);

$survey_table = mysql_query("SELECT * FROM tb_survey WHERE id_user = $user_id");
    
if (!$survey_table) {
  die('Invalid query: ' . mysql_error());
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title>Grader Tool - Dashboard teste</title>

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


  <!-- Scripts -->
  <script src="./js/demos/ui-notifications.js"></script>




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

      

      <div>
        <h4 class="heading-inline">Grader Tool Dashboard
        &nbsp;&nbsp;</h4>
      </div>

      <br>





      <!-- ALERTA DE SUCESSO DA PESQUISA -->

      <?php 

      if(isset($_GET['msg'])) {

      $msg = $_GET['msg'];

      if ($msg == 1) { ?>

      <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        <strong>Kudos!</strong> Your survey was successfully created.
      </div> <!-- /.alert -->

      <?php  } } ?>

      <div class="row">


<?php
$result_summary = mysql_query("SELECT count(*) AS total FROM tb_survey WHERE id_user = $user_id");
$data_summary = mysql_fetch_assoc($result_summary);

$result_summary_leads = mysql_query("SELECT count(*) AS total_leads FROM tb_answsurvey WHERE user_id = $user_id");
$data_summary_leads = mysql_fetch_assoc($result_summary_leads);

?>
        <div class="col-sm-6 col-md-6">
          <div class="row-stat">
            <p class="row-stat-label">Quantity of Surveys</p>
            <h3 class="row-stat-value"><?php echo $data_summary['total']; ?></h3>
          </div> <!-- /.row-stat -->
        </div> <!-- /.col -->

        <div class="col-sm-6 col-md-6">
          <div class="row-stat">
            <p class="row-stat-label">Number of Leads</p>
            <h3 class="row-stat-value"><?php echo $data_summary_leads['total_leads']; ?></h3>
          </div> <!-- /.row-stat -->
        </div> <!-- /.col -->
        
      </div> <!-- /.row -->


      <br>



          <div class="portlet portlet-table">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-comments-o"></i>
                Registered Surveys
              </h3>

              <ul class="portlet-tools pull-right">
                <li>
                  <button class="btn btn-sm btn-default">
                    <a href="create-survey.php">Create New Survey</a>
                  </button>
                </li>
              </ul>

            </div> <!-- /.portlet-header -->

            <div class="portlet-content">


              <div class="table-responsive">

                <table id="user-signups" class="table table-striped table-bordered table-checkable"> 
                  <thead> 
                    <tr> 
                      <th class="checkbox-column"> 
                        <input type="checkbox" id="check-all" class="icheck-input" />
                      </th> 
                      <th>Survey Id</th> 
                      <th>Survey Name</th>
                      <th># of Leads</th> 
                      <th>Status</th>
                      <th class="text-center" style="width: 90px">Share</th>
                    </tr> 
                  </thead> 

                  <tbody> 
                    <tr> 
                      
<?php
while($result = mysql_fetch_array( $survey_table )){


?>
					  
					  <!-- COLUMN 1: CHECKBOX -->

					 <td class="checkbox-column"> 
                        <input type="checkbox" name="actiony" value="joey" class="icheck-input"> 
                     </td>
					
					<!-- COLUMN 2: SURVEY NAME -->                      		
                     
                     <td><?php echo $result['ID']; ?></td>

                 	<!-- COLUMN 3: SURVEY NAME -->

                     <td><?php echo $result['survey_name']; ?></td>

                    <!-- COLUMN 4: NUMBER OF LEADS -->

                     <td><?php echo $result['id_user']; ?></td>


                    <!-- COLUMN 5: SURVEY STATUS -->

                     <td><?php echo $result['survey_status']; ?></td> 
                     
                     <td class="text-center">
                        
                        <a data-toggle="modal" href="#basicModal" class="btn btn-sm btn-secondary"><i class="fa fa-code"></i></a>

                     </td> 
                    
                    </tr> 
<?php } ?>

                  </tbody> 

                </table>
                  


              </div> <!-- /.table-responsive -->
                  
            </div> <!-- /.portlet-content -->

            <div class="portlet-footer">
              <div class="text-right">                  
                Apply to Selected: &nbsp;&nbsp;
                <select id="apply-selected" name="table-select" class="ui-select2" style="width: 125px">
                  <option value="">Select Action</option>
                  <option value="approve">Approve</option>
                  <option value="edit">Edit</option>
                  <option value="delete">Delete</option>
                  
                </select>
              </div>
            </div> <!-- /.portlet-footer -->

          </div> <!-- /.portlet -->




        </div> <!-- /.col -->

      </div> <!-- /.row -->

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

      <!-- Modal da tabela de Surveys -->
        <script src="./js/demos/ui-notifications.js"></script>

        


        
        <div id="basicModal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3 class="modal-title">How to distribute your survey</h3>
            </div>
            <div class="modal-body">

              <h4>URL</h4>
              <p>In order to distribute your survey, just pass to your leads the following URL:</p>

              <p><strong>http://www.gradertool.com/answer-survey.php?id=x</strong><br>(where 'x' = surve id you want to share)</p>

              <br>
              <h4>Embed to your site</h4>

              <p>Or, if you want to embed the survey into one of your pages, just copy and paste the following code:</p><br>

              <textarea name="textarea-input" id="textarea-input" cols="8" rows="2" class="form-control"><iframe src="http://www.gradertool.com/answer-survey.php?id=x" frameborder="0"></iframe></textarea>

              <p>(where 'x' = surve id you want to share)</p>



            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  <script src="./js/libs/jquery-1.10.1.min.js"></script>
  <script src="./js/libs/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="./js/libs/bootstrap.min.js"></script>

  <!--[if lt IE 9]>
  <script src="./js/libs/excanvas.compiled.js"></script>
  <![endif]-->
  
  <!-- Plugin JS -->
  <script src="./js/plugins/icheck/jquery.icheck.js"></script>
  <script src="./js/plugins/select2/select2.js"></script>
  <script src="./js/libs/raphael-2.1.2.min.js"></script>
  <script src="./js/plugins/morris/morris.min.js"></script>
  <script src="./js/plugins/sparkline/jquery.sparkline.min.js"></script>
  <script src="./js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="./js/plugins/fullcalendar/fullcalendar.min.js"></script>

  <!-- App JS -->
  <script src="./js/target-admin.js"></script>
  
  <!-- Plugin JS -->
  <script src="./js/demos/dashboard.js"></script>
  <script src="./js/demos/calendar.js"></script>
  <script src="./js/demos/charts/morris/area.js"></script>
  <script src="./js/demos/charts/morris/donut.js"></script>

  
</body>
</html>

<?php
} else { 
        echo 'Você não está autorizado a acessar essa página, favor fazer o login.';
}

?>
