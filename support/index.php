<?php 

session_start(); 

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  header('location: ./devis');
};


if (!empty($_POST) && isset($_POST)) {

$connect = new PDO("mysql:host=localhost;dbname=proxymarketmaroc","root","");

  $error = '';
  $output = '';

  if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          
          $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
          $password = filter_var($_POST['password'] , FILTER_SANITIZE_STRING);

          $query = "SELECT * FROM admin WHERE email='".$email."'"; 
          $statement = $connect->prepare($query);
          $statement->execute(); 

          $count = $statement->rowCount();

          if ($count!=0) {
           
           $admins = $statement->fetchAll();

           foreach ($admins as $admin) {
              
            if (password_verify($password, $admin['password']) ) {
                  
                 $_SESSION['user'] =  $admin['email'];
                 $_SESSION['level'] =  $admin['level'];

                 $error = 'false';
                 $output = '';

            }else{

              $error = 'true';
              $output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';

            }

           }

          }else{

            $error = 'true';
            $output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';

          }
 

  }else{

    $error = 'true';
    $output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';

  };

 $output = array(
    'error' => $error,
    'output' => $output
  );

 echo json_encode($output);

  die();
}


 ?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Panel d'administration</title>

  <link rel="icon" href="../public/images/favicon.ico" >
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../public/css/font-awesome.min.css">   
  <link rel="stylesheet" type="text/css" href="../public/css/login.css"> 

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../public/js/bootstrap.min.js"></script> 
    <script src="../public/js/login.js"></script> 

    
</head>

<body>

 

<div class="col-lg-12 col-md-12 container-login">
  <div class="col-lg-6 text-center form-login">
    
    <div class="col-lg-12 col-md-12 content-logo">
      <img src="../public/files/logo_proxy.svg" class="logo-form"  >
    </div>

    <div class="col-lg-12 col-md-12 grids-line">
      <span class="title-admin-page">Administration</span>
    </div>
    
    <div id="alert" class="col-lg-12 col-md-12 grids-line hide"  >
       <span class="incorrect-span">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.</span>
    </div>
 

    <div class="col-lg-12 col-md-12 grids-line" style="z-index: 99;"  >
      <i class="fa fa-user-o iconUser" aria-hidden="true"  ></i>  
      <input type="text" id="emailID" value="mr.boutmicht@gmail.com" class="input-login" placeholder="Nom d'utilisateur.." > 
       <span class="required-slide">Nom d'utilisateur..</span>
    </div>


    <div class="col-lg-12 col-md-12 grids-line"  >
      <i class="fa fa-lock iconPass" aria-hidden="true"    ></i>
      <a id="showPass" class="fa fa-eye-slash btn-eyes" aria-hidden="true" ></a>
      <a id="hidePass" class="fa fa-eye btn-eyes hide" aria-hidden="true" ></a> 
      <input type="password" id="passID" value="test" class="input-login"  placeholder="Mot de passe.." >
       <span class="required-slide">Mot de passe..</span>
    </div>

    <div class="col-lg-12 col-md-12 grids-line" style="margin-top: 20px;" >
      <a id="loginAdmin"  class="btn-save">
        <span><i class="fa fa-sign-in" aria-hidden="true"></i> connexion</span>
      </a>
      <a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
     </div>
 


  </div>
</div>
</body>
</html>




