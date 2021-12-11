<?php 

$connect = new PDO("mysql:host=localhost;dbname=eceb","root","");
session_start();

$error = '';
$output = '';

$query = "SELECT * FROM categories_types WHERE statut=1 ORDER BY classement ASC"; 
$statement = $connect->prepare($query);
$statement->execute(); 
$types = $statement->fetchAll();

 
?>

<header>
       <nav class="navbar navbar-inverse">
        <div class="container-fluid container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle navbar-mobile" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand proxy-link" data-link="index" ></a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              
              <!-- NAV BAR CLASSIC -->

            </ul>
            <ul class="nav navbar-nav navbar-right"> 
              <li ><a class="proxy-link" data-link="index"> Accueil</a></li>
             <!--  <li><a class="proxy-link" data-link="entreprise">Ecole</a></li> -->
              <li class="dropdown">
                <a class="dropdown-toggle dropdown-proxy-produits" data-toggle="dropdown" >Formations <i class="fa fa-angle-down" aria-hidden="true"></i></a>
               <ul class="dropdown-menu dropdown-nos-produits dropdowned">
                  <li class="dropdown"><a class="proxy-link" data-link="formations">Tous nos formations</a>
                  </li>

                  <?php 

                    $query = "SELECT * FROM formations WHERE state=1 ORDER BY id ASC"; 
                    $statement = $connect->prepare($query);
                    $statement->execute(); 
                    $count = $statement->rowCount();

                    if ($count!=0) {
                      

                      $formations = $statement->fetchAll();

                      foreach ($formations as $formation) {

                        $link_formation = str_replace(' ', '_',  $formation['nom_formation']); 
                        
                        echo '<li class="dropdown"><a class="dropdown-liste-types proxy-link" data-link="formations">'.$formation['nom_formation'].'</a></li>';

                        // echo '<li class="dropdown"><a class="dropdowned dropdown-liste-types" >'.$formation['nom_formation'].' <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        //         <ul class="dropdown-menu dropdown-types-produits">';

                        // $query = "SELECT * FROM categories_types WHERE statut=1 AND categories='".$formation['id']."' ORDER BY classement ASC"; 
                        // $statement = $connect->prepare($query);
                        // $statement->execute();
                        // $count = $statement->rowCount();

                        // if ($count!=0) {
                           
                        //    $types = $statement->fetchAll();

                        //    foreach ($types as $type) {

                        //       $link_type = str_replace(' ', '_',  $type['types']);
                              
                        //       echo '<li><a class="dropdowned proxy-link" data-link="produits?'.$link_categorie.'?'.$link_type.'" >- '.$type['types'].'</a></li>';

                        //    }

                        // }

                        // echo "</ul></li>";

                      }


                    }

                   ?>
  

                </ul>  
              </li>
              <li><a class="proxy-link" data-link="evenements">Événements</a></li>
              <li><a class="proxy-link" data-link="contact">Contact</a></li>
              <!-- <li>
                <input type="text" placeholder="recherche un produit.." class="search-header" >
                <a class="btn-search-header"><i class="fa fa-search" aria-hidden="true"></i></a>
              </li>  -->
              <!-- <li class="dropdown"><a class="dropdown-toggle icon-cart-proxy" data-toggle="dropdown" >Connexion <i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
              <ul class="dropdown-menu dropdown-cart dropdown-cart-proxy dropdowned" role="menu">
              <li><span class="title-cart-proxy">liste des produits demandé</span></li>
              <li class="divider"></li>
              <li class="dropdown-cart-infos-items" >

                <?php 
 
                  if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {

                    $count = count($_SESSION['shopping_cart']);
                  
                    foreach ($_SESSION['shopping_cart'] as $key => $value) {

                    $query = "SELECT * FROM products WHERE id='".$value['item_ref']."'"; 
                    $statement = $connect->prepare($query);
                    $statement->execute(); 
                    $count = $statement->rowCount();

                     if ($count!=0) {

                      $shoppings = $statement->fetchAll();

                      foreach ($shoppings as $shopping) {

                      $img = $shopping['images'];
                      $description = $shopping['description'];
                      $reference = $value['item_ref'];
                      $refDetails = $value['item_ref_details'];

                      $output .= '<ul class="nav navbar-nav">
                                      <li><span class="img-items-cart-proxy" style="background-image: url('.$img.');"></span></li>
                                      <li><span class="description-items-cart-proxy">'.$description.'</span></li>
                                      <li class="li-trash-items-cart"><a class="btn-delete-items-cart-proxy" data-reference="'.$reference.'" data-referenceDetails="'.$refDetails.'"><i class="fa fa-minus-square" aria-hidden="true"></i></a></li>
                                    </ul>  ';


                      }

                    }

                       
                  }
 

                }else{

                   $output = '<span style="padding: 10px 30px 10px 10px;text-align: left;display: block;position: relative;color: #424242;font-size: 12px;">Aucun article ajouté.</span>';

                };

                 echo $output;

                 ?>

                

              </li> 

              <?php if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) { ?>
                <li class="divider"></li>
                <li><a class="text-center btn-completer-order proxy-link" data-link="demandes" >completer</a></li>
              <?php } ?>

          </ul></li>  -->
            </ul> 
          </div>  
        </div>
      </nav> 
  </header>