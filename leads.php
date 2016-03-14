<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/config.php';
//include_once 'includes/process-leads.php';

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

$sql = "SELECT * FROM tb_survey WHERE id_user = $user_id";

$results = mysql_query($sql);
    
if (!$results) {
  die('Invalid query: ' . mysql_error());
}

$result_survey = mysql_query("SELECT tb_answsurvey.*, tb_leads.*
                                                  FROM tb_answsurvey
                                                  INNER JOIN tb_leads
                                                  ON tb_answsurvey.id_leads = tb_leads.ID
                                                  WHERE user_id = $user_id");
$num_rows = mysql_num_rows($result_survey);

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title>Grader Tool - Leads</title>

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

      <a class="navbar-brand navbar-brand-image" href="./index.html">
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
              <a href="./page-profile.html">
                <i class="fa fa-user"></i> 
                &nbsp;&nbsp;Meu perfil
              </a>
            </li>

            <li>
              <a href="./page-pricing.html">
                <i class="fa fa-dollar"></i> 
                &nbsp;&nbsp;Planos &amp; Cobrança
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

        <li class="dropdown">
          <a href="./dashboard.php">
            <i class="fa fa-dashboard"></i>
            Dashboard
          </a>
        </li>

        <li class="active">
          <a href="./leads.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
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
        <h2 class="content-header-title">Leads</h2>
        <ol class="breadcrumb">
          <li><a href="./dashboard.html">Dashboard</a></li>
          <li class="active">Leads</li>
        </ol>
      </div> <!-- /.content-header -->

	<div class="portlet portlet-table">

            <div class="portlet-header">

              <h3>
                <i class="fa fa-group"></i>
                Leads Database
              </h3>

              <ul class="portlet-tools pull-right">
                <li>
                  <button class="btn btn-sm btn-default">
                    Export to Excel
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
                      <th>id Survey</th> 
                      <th>Email</th>
                      <th>Grade</th>
                      <th>View Survey</th>
                    </tr> 
                  </thead> 

                  <tbody>

                  <?php

                  while ($data_survey = mysql_fetch_array($result_survey)) {

                    $id_survey = $data_survey['id_survey'];
                    $lead_email = $data_survey['email'];
                    $grade = $data_survey['grade'];

                    ?>

                    <tr> 
                      <td class="checkbox-column"> 
                        <input type="checkbox" name="actiony" value="joey" class="icheck-input"> 
                      </td> 
                      
                      <td><?php echo $id_survey; ?></td>
                      <td><?php echo $lead_email; ?></td>
                      <td><?php echo $grade; ?></td>
                      <td><a data-toggle="modal" href="#basicModal" class="btn btn-sm btn-secondary"><i class="fa fa-file-o"></i></a></td>
                    </tr>

                    <?php
                      
                  } ?>

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
