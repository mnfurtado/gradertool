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


/*Open the connection to our database use the info from the config file.*/
$link = mysql_connect($host, $user, $password);

if (!$link) {
  die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('dbgradertoolapp', $link);


$sql = mysql_query("SELECT * FROM tb_api WHERE id_user = $user_id");
$results = mysql_fetch_assoc($sql);
$register = mysql_num_rows($sql);


?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title>Grader Tool - Integrations</title>

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

        <li class="dropdown">
          <a href="./dashboard.php">
            <i class="fa fa-dashboard"></i>
            Dashboard
          </a>
        </li>

        <li class="dropdown">
          <a href="leads.html" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
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
        <h2 class="content-header-title">Integrations</h2>
        <ol class="breadcrumb">
          <li><a href="./dashboard.php">Settings</a></li>
          <li class="active">Integrations</li>
        </ol>
      </div> <!-- /.content-header -->


      <!-- ALERTA DE SUCESSO DA PESQUISA -->

      <?php 

      if(isset($_GET['msg'])) {

      $msg = $_GET['msg'];

      if ($msg == 1) { ?>

      <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        <strong>You got it!</strong> Your integration data was saved.
      </div> <!-- /.alert -->

      <?php  } } ?>


      <div class="portlet">
      
        <div class="portlet-header">
      
          <h3>
            <i class="fa fa-puzzle-piece"></i>
            Avaiable Integrations
          </h3>
      
        </div> <!-- /.portlet-header -->
      
        <div class="portlet-content">
      
          <form class="form-horizontal" role="form"
          action="includes/process-integrations.php" method="post" id="tb_api">
                    
         <!-- <input type="hidden" name="formID" value="tb_survey" /> -->
         <input type="hidden" name="redirect_to" value="http://localhost/gradertool/integrations.php" />
         <input type="hidden" name="id_user" value="<?php echo $user_id;?>" />
         <input type="hidden" name="register" value="<?php echo $register;?>" />
          
          <img src="./img/logo_rdstation.png"  width="50" height="50" alt="RD Station"><br><br>
          <div class="form-group">
              <label class="col-md-4">RD Station Token</label>

              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Paste your RD Station token here."
                name="token_rdstation" value="<?php if ($register == 1) { echo $results['token_rdstation'];}?>">

              </div>
            </div>
            <hr>

            <img src="./img/logo_pipedrive.png"  width="50" height="50" alt="RD Station"><br><br>
          <div class="form-group">
              <label class="col-md-4">Pipedrive Token</label>

              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Paste your Pipedrive token here."
                name="token_pipedrive" value="<?php if ($register == 1) { echo $results['token_pipedrive'];}?>">
              </div>
          </div>

          <div class="form-group">
              <label class="col-md-4">Pipedrive Funnel ID</label>

              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Where your leads will be directed to."
                name="funel_pipedrive" value="<?php if ($register == 1) { echo $results['funel_pipedrive'];}?>">
              </div>
          </div>
                            
        </div> <!-- /.portlet-content -->
      
	</div>

      <button type="submit" class="btn btn-success" value="submit" name="insert">Save data</button> 

      
      </form>

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
