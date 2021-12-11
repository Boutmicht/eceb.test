<?php 

session_start(); 

if (empty($_SESSION['user'])) {
	header('Location: index.php');
	die();
};
 

 ?>
 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>welcome administration</title>

  <!-- <link rel="icon" href="../public/images/favicon.ico" > -->
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../public/css/font-awesome.min.css">   
  <link rel="stylesheet" type="text/css" href="../public/css/dashboard.css"> 

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <script src="../public/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../public/js/bootstrap.min.js"></script> 
    <script src="../public/js/dashboard.js"></script> 

    
</head>

<body>





<div class="col-lg-12 col-md-12 container-page">
 <div class="container-bars">
 	<div class="bars-icons">
 		<ul>
 			<li >
 				<a class="btn-menu-sub"  data-category='category'  ><i class="fa fa-archive" aria-hidden="true" style="color:#72c169;"></i><span style="color:#72c169;">Categories</span></a>
 			</li>
      <li>
        <a class="btn-menu-sub"  data-category='products' ><i class="fa fa-folder-open-o" aria-hidden="true"></i><span>Produits</span></a>
      </li>
 			<li>
 				<a class="btn-menu-sub"  data-category='commandes' ><i class="fa fa-shopping-basket" aria-hidden="true"></i><span>Commandes</span></a>
 			</li> 
 			<li>
 				<a class="btn-menu-sub"  data-category='devis' ><i class="fa fa-money" aria-hidden="true"></i><span>Devis</span></a>
 			</li>
 			<li>
 				<a class="btn-menu-sub"  data-category='contacts' ><i class="fa fa-envelope-o" aria-hidden="true"></i><span>Contacts</span></a>
 			</li>
 			<!-- <li>
 				<a><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Reports</span></a>
 			</li>
 			<li>
 				<a><i class="fa fa-wrench" aria-hidden="true"></i><span>System</span></a>
 			</li> -->
 		</ul>
 	</div>
<!--  	<div class="bars-icons-details">
 		<ul>
 			<li >
 				<a class="btn-menu-sub" data-category='category' ><i class="fa fa-th-list" aria-hidden="true"></i><span>Categories</span></a>
 			</li> 
 			<li>
 				<a class="btn-menu-sub" data-category='products' ><i class="fa fa-folder-open-o" aria-hidden="true"></i><span>Produits</span></a>
 			</li> 
 		</ul>
 	</div> -->
 </div>

 <div class="container-content">
 	
 	<div class="header-bar">
 		<ul>
 		<!-- <li style="float: left;">
 			<span class="directory-bar" >#Categories</span>
 		</li> -->
 		<li>
 			<a class="ico-user"><?php echo $_SESSION['user']; ?> <i class="fa fa-user-circle" aria-hidden="true"></i></a>
 		</li>
 		<li>
 			<a href="./logout.php" class="btn-logout">log out</a>
 		</li>
 	 </ul>
 	</div>
 
 	<div class="contentu">
 		
  

 	</div>

 </div>

</div>

<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
 <script type="text/javascript">
      
    </script>
</body>
</html>

 


