<?php 

// $hash = password_hash('test', PASSWORD_DEFAULT);
// if (password_verify($password, $hash)) {

require_once('./mail/SMTP.php');
require_once('./mail/PHPMailer.php');
require_once('./mail/Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;


$connect = new PDO("mysql:host=localhost;dbname=eceb","root","");
 
session_start();

$error = '';
$output = '';

if ( isset($_POST['action']) && !empty($_POST['action']) ) {
 

 
	if ($_POST['action'] == 'add_cart'){

	  	if (is_numeric($_POST['reference']) && is_numeric($_POST['ref_details']) && is_numeric($_POST['qte']) && is_numeric($_POST['qte_min']) ) {
	  		
	  			if (isset($_SESSION["shopping_cart"]) && !empty($_SESSION["shopping_cart"])) {
  
	  				$item_array_id = array_column($_SESSION["shopping_cart"], 'item_ref');
	  				$item_array_refD = array_column($_SESSION["shopping_cart"], 'item_ref_details');


	  				if (!in_array($_POST['reference'], $item_array_id) ) {
	  			  
	  					$count = array_key_last($_SESSION['shopping_cart']);

	  					$item_array = array(
	  						'item_ref'		   => $_POST['reference']	, 
		  					'item_ref_details' => $_POST['ref_details'] , 
		  					'item_qte'		   => $_POST['qte'] 	 
	  					);

	  					$_SESSION['shopping_cart'][$count+1] = $item_array;

	  							$error = 'false';
 
				  				$output = '<li><span class="title-cart-proxy">liste des produits demandé</span></li>
								              <li class="divider"></li>
								              <li class="dropdown-cart-infos-items">';

				  				if (count($_SESSION['shopping_cart'])!=0) {
			 						 
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

				                       
				                  };

				                  $output .= '</li> 
				                  			  <li class="divider"></li>
									          <li><a class="text-center btn-completer-order proxy-link" data-link="demandes" >completer</a></li>';


			 					}
	  						

	  				}else{
 
		  					if ( !in_array($_POST['ref_details'], $item_array_refD) ) {
	  						
	  						$count = array_key_last($_SESSION['shopping_cart']);

		  					$item_array = array(
		  						'item_ref'		   => $_POST['reference']	, 
			  					'item_ref_details' => $_POST['ref_details'] , 
			  					'item_qte'		   => $_POST['qte'] 	 
		  					);

		  						$_SESSION['shopping_cart'][$count+1] = $item_array;

		  						$error = 'false';
 
				  				$output = '<li><span class="title-cart-proxy">liste des produits demandé</span></li>
								              <li class="divider"></li>
								              <li class="dropdown-cart-infos-items">';

				  				if (count($_SESSION['shopping_cart'])!=0) {
			 						 
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

				                       
				                  };

				                  $output .= '</li> 
				                  			  <li class="divider"></li>
									          <li><a class="text-center btn-completer-order proxy-link" data-link="demandes" >completer</a></li>';


			 					}


		  					}else{

			  					$error  = 'true';
			  					$output = "Le produit déjà ajouté à votre panier !";

		  					}

	  				}

	  				
  
	  			}else{ 

	  				$item_array = $arrayName = array(
	  					'item_ref'		   => $_POST['reference']	, 
	  					'item_ref_details' => $_POST['ref_details'] , 
	  					'item_qte'		   => $_POST['qte'] 	
	  				);

	  				$_SESSION['shopping_cart'][1] = $item_array;

	  				$error = 'false';
 
	  				$output = '<li><span class="title-cart-proxy">liste des produits demandé</span></li>
					              <li class="divider"></li>
					              <li class="dropdown-cart-infos-items">';

	  				if (count($_SESSION['shopping_cart'])!=0) {
 						 
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

	                       
	                  };

	                  $output .= '</li> 
	                  			  <li class="divider"></li>
						          <li><a class="text-center btn-completer-order proxy-link" data-link="demandes"  >completer</a></li>';


 					}else{

 						 $output .= '<span style="padding: 10px 30px 10px 10px;text-align: left;display: block;position: relative;color: #424242;font-size: 12px;">Aucun article ajouté.</span>';

 					};

	  			}
 
	  		}else{

		  		$error = 'true';
		  		$output = "Error d'ajouter au panier!";
 
	  		}
	  	 
	
	};



	if ($_POST['action'] == 'delete_item'){

	  		if (is_numeric($_POST['reference']) && is_numeric($_POST['ref_details']) ) {
	  		
	  			if (isset($_SESSION["shopping_cart"])) {


	  				$output = '<li><span class="title-cart-proxy">liste des produits demandé</span></li>
					              <li class="divider"></li>
					              <li class="dropdown-cart-infos-items">';
   
 
 					foreach ($_SESSION['shopping_cart'] as $key => $value) {

 						if ( $value['item_ref'] == $_POST['reference'] && $value['item_ref_details'] == $_POST['ref_details'] ) {
 							 
 							unset($_SESSION['shopping_cart'][$key]);

 							$error = 'false'; 
     
 						}

 					};

 					if (count($_SESSION['shopping_cart'])!=0) {
 						 
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

	                       
	                  };

	                  $output .= '</li> 
	                  			  <li class="divider"></li>
						          <li><a class="text-center btn-completer-order proxy-link" data-link="demandes"   >completer</a></li>';


 					}else{

 						 $output .= '<span style="padding: 10px 30px 10px 10px;text-align: left;display: block;position: relative;color: #424242;font-size: 12px;">Aucun article ajouté.</span>';

 					};

 					 
	  			}else{

		  			$error = 'true';
			  		$output = "Impossible de supprimer les produits!";

	  			}
 
	  		}else{

		  		$error = 'true';
		  		$output = "Error de supprimer ce produit!";
 
	  		}
	  	 
	
	};




	if ($_POST['action'] == 'delete_item_commandes'){

	  		if (is_numeric($_POST['reference']) && is_numeric($_POST['ref_details']) ) {
	  		
	  			if (isset($_SESSION["shopping_cart"])) {
  
 					foreach ($_SESSION['shopping_cart'] as $key => $value) {

 						if ( $value['item_ref'] == $_POST['reference'] && $value['item_ref_details'] == $_POST['ref_details'] ) {
 							 
 							unset($_SESSION['shopping_cart'][$key]);

 							$error = 'false'; 
     
 						}

 					};

 					if (count($_SESSION['shopping_cart'])!=0) {

 						$output = '<li><span class="title-cart-proxy">liste des produits demandé</span></li>
					              <li class="divider"></li>
					              <li class="dropdown-cart-infos-items">';
 						 
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

	                       
	                  };

	                  $output .= '</li> 
	                  			  <li class="divider"></li>
						          <li><a class="text-center btn-completer-order proxy-link" data-link="demandes"   >completer</a></li>';


 					}else{

 						 $output .= '<span style="padding: 10px 30px 10px 10px;text-align: left;display: block;position: relative;color: #424242;font-size: 12px;">Aucun article ajouté.</span>';

 					};

 					 
	  			}else{

		  			$error = 'true';
			  		$output = "Impossible de supprimer les produits!";

	  			}
 
	  		}else{

		  		$error = 'true';
		  		$output = "Error de supprimer ce produit!";
 
	  		}
	  	 
	
	};


	if ($_POST['action'] == 'new_commandes'){


	  		if (is_numeric($_POST['telephone']) && $_POST['responsable'] !='' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && ($_POST['type_demmande']=='devis'||$_POST['type_demmande']=='commande') ) { 
 
	  			if (isset($_SESSION["shopping_cart"]) && !empty($_SESSION["shopping_cart"]) && count($_SESSION['shopping_cart'])!=0) {

  					$demande = strtolower(filter_var($_POST['type_demmande'] , FILTER_SANITIZE_STRING));
  					$entreprise = strtolower(filter_var($_POST['entreprise'] , FILTER_SANITIZE_STRING));
  					$responsable = strtolower(filter_var($_POST['responsable'] , FILTER_SANITIZE_STRING));
  					$email = strtolower(filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL));
  					$telephone = filter_var($_POST['telephone'] , FILTER_SANITIZE_NUMBER_INT);
  					$description = strtolower(filter_var($_POST['description'] , FILTER_SANITIZE_STRING));
  				 	$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
  					$current_time = date("d-m-Y H:i");
  					$current_date = date("d-m-Y");

 					$query = 'INSERT INTO demandes (type_demande,nom_entreprise,nom_responsable,email,phone,description,key_verification,verification,date_demande,date_confirmation,statut) VALUES ("'.$demande.'","'.$entreprise.'","'.$responsable.'","'.$email.'","'.$telephone.'","'.$description.'","'.$activationKey.'",0,"'.$current_time.'",0,0)';
	  				$statement = $connect->prepare($query);

	  				if ($statement->execute()) { 

	  				$order_type = 'demande';

	  				if ($demande=='devis') {
	  					$order_type = 'demande de devis';
	  				}elseif ($demande=='commande') {
	  					$order_type = 'commande';
	  				};

	  				$mail=new PHPMailer(true); // Passing `true` enables exceptions  
					//settings
					$mail->SMTPDebug=0; // Enable verbose debug output
					$mail->isSMTP(); // Set mailer to use SMTP
					$mail->Host='smtp.gmail.com';
					$mail->SMTPAuth=true; // Enable SMTP authentication
					$mail->Username='proxymarketma@gmail.com'; // SMTP username
					$mail->Password='AQWzsx123'; // SMTP password
					$mail->SMTPSecure='ssl';
					$mail->Port=465;
					$mail->setFrom('proxymarketma@gmail.com', 'PROXYMARKET');
					//recipient
					$mail->addAddress($email, $responsable);     // Add a recipient 
					//content
					$mail->isHTML(true); // Set email format to HTML
					$mail->Subject='Confirmation de '.$order_type.' PROXYMARKET du '.$current_date;
					$mail->Body='<div class="content-letter" style="padding: 40px 10px;background: whitesmoke;">
										<img src="http://proxymarketmaroc.com/public/images/logo_header.png" style="height: 100px;width: auto;margin-bottom: 20px;">
										<b style="display: block;font-size: 14px; color: #424242;padding-bottom: 10px;padding-top: 10px;">Bonjour '.$responsable.',</b>
														<span style="display: block;position: relative;color: #424242;font-size: 14px; padding-bottom: 10px;">Pour confirmer votre '.$order_type.' veuillez appuyer sur le bouton ci-dessous,</span> <a style="background:#72c169;padding:10px;color:white;font-family:arial;display: inline-block;border-radius: 25px;width: 200px;text-align: center;text-decoration: none;font-size: 18px;" href="http://www.proxymarketmaroc.com/demandes?'.$activationKey.'"  >confirmer</a>
														<span style="display: block;padding-top: 10px;">ou vérifiez en utilisant ce lien: </span><a href="http://www.proxymarketmaroc.com/contacts?'.$activationKey.'" style="display: block;">www.proxymarketmaroc.com/demandes?'.$activationKey.'</a>
														<span style="display: inline-block;color: #828282;padding-top: 10px;">si vous n\'avez pas demandé de notre site à l\'aide de cette adresse, veuillez ignorer cet e-mail.</span>
									</div>';
					$mail->AltBody='';
 					$mail->send();

	  					$last_id = $connect->lastInsertId(); 
	  				  

	  					foreach ($_SESSION['shopping_cart'] as $key => $value) {
	  						
	  						$query = 'INSERT INTO demandes_details (demande_id,reference,reference_detail,quantite) VALUES ("'.$last_id.'", "'.$value['item_ref'].'", "'.$value['item_ref_details'].'", "'.$value['item_qte'].'")';
		  					$statement = $connect->prepare($query);
		  					if ($statement->execute()) {

		  						 session_unset();
		  						
		  						 $error = 'false';
		  						 $output = '<p style="margin: 0;">
											<span style="font-variant:all-petite-caps;font-size:14px;font-family: proxyfont;color: #424242;"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 15px;"></i> votre commande a bien été enregistrée. Veuillez le confirmer en vérifiant le message envoyé à l\'adresse que vous avez saisie : </span><span style="font-variant:all-petite-caps;font-size:15px;color:#424242;text-decoration:none;cursor: pointer;font-family: proxyfontbold;">'.$email.'</span>
												</p>
											<p>
											<span style="font-variant:all-petite-caps;font-size:12px;color:#424242;font-family: proxyfontbold;">pour toute question ou information complémentaire merci de contacter notre support client.</span>
											<a style="font-variant:all-petite-caps;font-size:13px;color:#72c169;cursor: pointer;font-family: proxyfontbold;" class="proxy-link" data-link="index">retour à la page accueil</a>
												</p>';

		  					}else{
		  						$error = 'true';
		  						$output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> error d\'ajoute produit a la commande.';
		  					}

	  					}
   
	  				}else{
	  					$error = 'true';
	  					$output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> probleme d\'joute la commande.';
	  				}
	  				
	  				 
 					 
	  			}else{

		  			$error = 'true';
			  		$output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aucun produit selectionné ! Veuillez sélectionner un au minimum.';

	  			}
 
	  		}else{

		  		$error = 'true';
		  		$output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';
 
	  		}
	  	 
	
	};



	if ($_POST['action'] == 'new_contact'){


	  	 if (is_numeric($_POST['telephone']) && $_POST['responsable'] !='' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&  $_POST['description']!='') { 
 
  					$entreprise = strtolower(filter_var($_POST['entreprise'] , FILTER_SANITIZE_STRING));
  					$responsable = strtolower(filter_var($_POST['responsable'] , FILTER_SANITIZE_STRING));
  					$email = strtolower(filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL));
  					$telephone = filter_var($_POST['telephone'] , FILTER_SANITIZE_NUMBER_INT);
  					$description = strtolower(filter_var($_POST['description'] , FILTER_SANITIZE_STRING));
  				 	$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
  					$current_time = date("d-m-Y H:i");
  					$current_date = date("d-m-Y");

 					$query = 'INSERT INTO contacts (nom_entreprise,nom_responsable,email,phone,description,key_verification,verification,date_demande,date_confirmation,statut) VALUES ("'.$entreprise.'","'.$responsable.'","'.$email.'","'.$telephone.'","'.$description.'","'.$activationKey.'",0,"'.$current_time.'",0,0)';
	  				$statement = $connect->prepare($query);
 
					$mail=new PHPMailer(true); // Passing `true` enables exceptions  
					//settings
					$mail->SMTPDebug=0; // Enable verbose debug output
					$mail->isSMTP(); // Set mailer to use SMTP
					$mail->Host='smtp.gmail.com';
					$mail->SMTPAuth=true; // Enable SMTP authentication
					$mail->Username='proxymarketma@gmail.com'; // SMTP username
					$mail->Password='AQWzsx123'; // SMTP password
					$mail->SMTPSecure='ssl';
					$mail->Port=465; 
					$mail->setFrom('proxymarketma@gmail.com', 'PROXYMARKET'); 
					//recipient
					$mail->addAddress($email, $responsable);     // Add a recipient 
					//content
					$mail->isHTML(true); // Set email format to HTML
					$mail->Subject='Confirmation de contact PROXYMARKET du '.$current_date;
					$mail->Body='<div class="content-letter" style="padding: 40px 10px;background: whitesmoke;">
										<img src="http://proxymarketmaroc.com/public/images/logo_header.png" style="height: 100px;width: auto;margin-bottom: 20px;">
										<b style="display: block;font-size: 14px; color: #424242;padding-bottom: 10px;padding-top: 10px;">Bonjour '.$responsable.',</b>
														<span style="display: block;position: relative;color: #424242;font-size: 14px; padding-bottom: 10px;">Pour confirmer votre contact veuillez appuyer sur le bouton ci-dessous,</span> <a style="background:#72c169;padding:10px;color:white;font-family:arial;display: inline-block;border-radius: 25px;width: 200px;text-align: center;text-decoration: none;font-size: 18px;" href="http://www.proxymarketmaroc.com/contact?'.$activationKey.'"  >confirmer</a>
														<span style="display: block;padding-top: 10px;">ou vérifiez en utilisant ce lien: </span><a href="http://www.proxymarketmaroc.com/contact?'.$activationKey.'" style="display: block;">www.proxymarketmaroc.com/<wbr>contact?<wbr>2af592cdf11406c8e230c5687ff064<wbr>74</a>
														<span style="display: inline-block;color: #828282;padding-top: 10px;">si vous n\'avez pas commandé de notre site à l\'aide de cette adresse, veuillez ignorer cet e-mail.</span>
									</div>';
					$mail->AltBody='';
 					$mail->send();

	  				if ($statement->execute()) {

	  					 $error = 'false';
		  				 $output = '<p class="title-section-contact">Contactez-nous</p>
										 <div style="background: whitesmoke;padding: 10px;">
										 	<p style="margin: 0;">
											<span style="font-variant:all-petite-caps;font-size:14px;font-family: proxyfont;color: #424242;"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 15px;"></i> votre message a bien été enregistrée.<br>Veuillez le confirmer en vérifiant le message envoyé à l\'adresse que vous avez saisie : </span><span style="font-variant:all-petite-caps;font-size:15px;color:#424242;text-decoration:none;cursor: pointer;font-family: proxyfontbold;">'.$email.'</span>
												</p>
											<p>
											<span style="font-variant:all-petite-caps;font-size:12px;color:#424242;font-family: proxyfontbold;">pour toute question ou information complémentaire merci de contacter notre support client.</span>
											<a style="font-variant:all-petite-caps;font-size:13px;color:#72c169;cursor: pointer;font-family: proxyfontbold;" class="proxy-link" data-link="index">retour à la page accueil</a>
								 			</p>
	               						  </div>';
   
	  				}else{
	  					$error = 'true';
	  					$output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';
	  				}
	  				
	  				 
 				 
	  		}else{

		  		$error = 'true';
		  		$output = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';
 
	  		}
	  	 
	
	};

	  



	if ($_POST['action'] == 'update_type') {

	   		$query = "SELECT * FROM categories_types WHERE id = '".$_POST['id']."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$total_row = $statement->rowCount();
 			
 			if ($total_row != 0) {
 
	 			$query = "UPDATE categories_types SET types = '".$_POST['new_type']."'  WHERE id = '".$_POST['id']."'"; 
		  		$statement = $connect->prepare($query);
		  		$statement->execute();

		  		$error = 'false';
		  		$output = '';

 			}


	};
   

	 

 

};
 


$output = array(
		'error' => $error,
		'output' => $output
	);

	echo json_encode($output);

      
  ?>