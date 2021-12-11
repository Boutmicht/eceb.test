<?php 

// $hash = password_hash('test', PASSWORD_DEFAULT);
// if (password_verify($password, $hash)) {

$connect = new PDO("mysql:host=localhost;dbname=eceb","root","");
 
session_start();

$error = '';
$output = '';

if ( isset($_POST['action']) && !empty($_POST['action']) ) {
	
	if ($_POST['action'] == 'login'){
	  	if ($_POST['email'] != '' || $_POST['password']!= '' ) {
	  		
	  		$data = array(
	  			':email' => $_POST['email']
	  		);

	  		$query = "SELECT * FROM admin WHERE email = :email";

	  		$statement = $connect->prepare($query);
	  		$statement->execute($data);

	  		$total_row = $statement->rowCount();

	  		if ($total_row == 0) {
	  			$error = 'true';
	  			$output = 'Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';
	  		}else{

	  			$result = $statement->fetchAll();

	  			foreach ($result as $row ) {
	  				
	  				$email = $row['email'];
	  				$password = $row['password'];
	  				$level = $row['level'];

	  				if (password_verify($_POST['password'], $password)) {

	  					if ($row['status'] == 'disabled') {
	  						$error = 'true';
	  						$output = 'Sorry! your account is disabled please contact admin manager.';
	  					}else{
	  						$error = 'false';
	  						$output = 'dashboard.php';
	  						
	  						$_SESSION['email'] = $email;
	  						$_SESSION['password'] = $password;
	  						$_SESSION['level'] = $level;
	  						
	  					}

	  				}else{
	  					$error = 'true';
	  					$output = 'Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';
	  				}
	  			}
	  			
	  		}

	  	}else{
	  		$error = 'true';
	  		$output = 'Certaines de vos informations sont incorrectes! Veuillez vérifier et réessayer.';
	  	}
	};

 
	if ($_POST['action'] == 'add_categorie'){
	  	if ($_POST['categorie'] != '' ) {
	  		
	  		$data = array(
	  			':categorie' => $_POST['categorie']
	  		);

	  		$query = "SELECT * FROM categories WHERE nom_categorie = :categorie"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute($data);

	  		$total_row = $statement->rowCount();

	  		if ($total_row != 0) {
	  			$error = 'true';
	  			$output = "Cette catégorie existé!";
	  		}else{ 

	  			$query = "SELECT MAX(classement) AS LastClassement FROM categories";
	  			$statement = $connect->prepare($query);
	  			$statement->execute(); 
	  			$result = $statement->fetchAll();

	  			foreach ($result as $row ) {
	  				 
	  				$classement = $row['LastClassement']+1; 
	  				$categorie = $_POST["categorie"];
 
	  			};

	  				$query = 'INSERT INTO categories (nom_categorie,statut,classement) VALUES ("'.$categorie.'","1","'.$classement.'")';
	  				$statement = $connect->prepare($query);
	  				$statement->execute();

	  				$query = 'SELECT * FROM categories WHERE statut="1"'; 
	  				$statement = $connect->prepare($query);
	  				$statement->execute();
	  				$result = $statement->fetchAll();

	  				$output = '<span class="form-get-tables" style="font-family: proxyFontBold;color: white;background: #72c169;">Liste des categories</span>';

	  				foreach ($result as $row ) { 
	  					$output .= '<span class="form-get-tables">'.$row['nom_categorie'].'</span>';
	  				};


	  				$error = 'false'; 
	  			
	  		}

	  	}else{
	  		$error = 'true';
	  		$output = "Error d'ajoute! Veuillez vérifier et réessayer.";
	  	}
	};

	if ($_POST['action'] == 'add_type') {
		if ($_POST['id']!="" && $_POST['type']!="") {
			 
			 $_POST['type'] = strtolower($_POST['type']);

	  		$query = "SELECT * FROM categories WHERE id = '".$_POST['id']."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$total_row = $statement->rowCount();

	  		if ($total_row != 0) {

	  			$result = $statement->fetchAll();
	  			foreach ($result as $row) {
	  				 $categorie = $row['nom_categorie'];
	  			};
 

		  		$query = "SELECT * FROM categories_types WHERE categories = '".$_POST['id']."' AND types = '".$_POST['type']."'"; 
		  		$statement = $connect->prepare($query);
		  		$statement->execute(); 
		  		$total_row = $statement->rowCount();

		  		if ($total_row == 0) { 

		  			$query = "SELECT MAX(classement) AS LastClassement FROM categories_types WHERE categories = '".$_POST['id']."'"; 
		  			$statement = $connect->prepare($query);
		  			$statement->execute(); 
		  			$result = $statement->fetchAll();
 
		  			foreach ($result as $row ) {
		  				 
		  				$classement = $row['LastClassement']+1;  

		  				$query = 'INSERT INTO categories_types (categories,types,statut,classement) VALUES ("'.$_POST['id'].'","'.$_POST['type'].'","1","'.$classement.'")';
		  				$statement = $connect->prepare($query);
		  				$statement->execute();

		  				$query = "SELECT * FROM categories_types WHERE categories='".$_POST['id']."' AND statut='1'"; 
		  				$statement = $connect->prepare($query);
		  				$statement->execute();
		  				$result = $statement->fetchAll();

		  				$output = '<span class="form-get-tables" style="font-family: proxyFontBold;color: white;background: #72c169;">'.$categorie.'</span>';

		  				foreach ($result as $row ) { 
		  					$output .= '<span class="form-get-tables">'.$row['types'].'</span>';
		  				};


		  				$error = 'false'; 
	   
		  			}

		  		}else{
		  			$error  = 'true';
	  				$output = 'Catégorie existe déja Veuillez sélectionner un nouveau type.';
		  		}

		  		

	  		}else{
	  			$error = 'true';
	  			$output = 'Veuillez sélectionner un catégorie existe.';
	  		}


		}else{
			$error = 'true';
	  		$output = "Error d'ajoute! Veuillez vérifier et réessayer.";
		}
	};
 
	 if ($_POST['action'] == 'switch_categories') {
			
		    $query = "SELECT * FROM categories WHERE id = '".$_POST['id']."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$total_row = $statement->rowCount();

	  		if ($total_row != 0) {

	  			$result = $statement->fetchAll();

	  			foreach ($result as $row ) {

	  				if ($row['statut']==0) {

	  					 $query = "UPDATE categories SET statut = 1 WHERE id = '".$_POST['id']."'"; 
	  					 $statement = $connect->prepare($query);
	  				     $statement->execute();

	  				     $error = 'false';
	  				     $output = "Enabled";

	  				}else{

	  					$query = "UPDATE categories SET statut = 0 WHERE id = '".$_POST['id']."'"; 
	  					 $statement = $connect->prepare($query);
	  				     $statement->execute();

	  				     $error = 'false';
	  				     $output = "Disabled";

	  				}
	  			}
	  		}
	};

	if ($_POST['action'] == 'switch_types') {
			
		    $query = "SELECT * FROM categories_types WHERE id = '".$_POST['id']."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$total_row = $statement->rowCount();

	  		if ($total_row != 0) {

	  			$result = $statement->fetchAll();

	  			foreach ($result as $row ) {

	  				if ($row['statut']==0) {

	  					 $query = "UPDATE categories_types SET statut = 1 WHERE id = '".$_POST['id']."'"; 
	  					 $statement = $connect->prepare($query);
	  				     $statement->execute();

	  				     $error = 'false';
	  				     $output = "Enabled";

	  				}else{

	  					$query = "UPDATE categories_types SET statut = 0 WHERE id = '".$_POST['id']."'"; 
	  					 $statement = $connect->prepare($query);
	  				     $statement->execute();

	  				     $error = 'false';
	  				     $output = "Disabled";

	  				}
	  			}
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


	if ( isset($_POST['action']) && $_POST['action'] == 'add_product_dimension' ) {

		if (is_numeric($_POST['product']) && is_numeric($_POST['qte_pcs']) && is_numeric($_POST['qte_pqt'])) {
			
			extract($_POST);

			$reference = strtolower($reference);
			$dimension = strtolower($dimension); 

	   		$query = "SELECT * FROM products WHERE id = '".$product."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$result = $statement->fetchAll();
	  		$total_row = $statement->rowCount();

 			if ($total_row != 0) {
 	
 				foreach ($result as $row ) {
 					$old_reference = $row['reference'];
 					$old_dimensions = $row['dimensions'];
 					$old_pieces = $row['pieces'];
 					$old_packing = $row['packing'];
 				};

 				$query = "SELECT MAX(classement) AS LastClassement FROM products_dimensions WHERE product_id = '".$product."'";
	  			$statement = $connect->prepare($query);
	  			$statement->execute(); 
	  			$result = $statement->fetchAll();

	  			foreach ($result as $row ) {
	  				 
	  				$classement = $row['LastClassement']+1;  
 
	  			};

	  			$query = "INSERT INTO products_dimensions (product_id,reference,dimensions,pieces,packing,statut,classement) VALUES ('".$product."','".$reference."','".$dimension."','".$qte_pcs."','".$qte_pqt."','1','".$classement."')";
	  			$statement = $connect->prepare($query);
	  			$statement->execute(); 


		  		$output .= '<tbody><tr><th>Reference</th><th>dimensions</th><th>pieces</th><th>packing</th></tr>';
		  		
		  		$output .='<tr>
						    <td>'.$old_reference.'</td><td>'.$old_dimensions.'</td><td>'.$old_pieces.'</td><td>'.$old_packing.'</td>
						  </tr>';
			  	
	  			$query = "SELECT * FROM products_dimensions WHERE product_id = '".$product."'"; 
		  		$statement = $connect->prepare($query);
		  		$statement->execute(); 
		  		$result = $statement->fetchAll();

		  		foreach ($result as $row) {
		  		 	
		  			$output .='<tr>
						    <td>'.$row['reference'].'</td><td>'.$row['dimensions'].'</td><td>'.$row['pieces'].'</td><td>'.$row['packing'].'</td>
						  </tr>';

		  		};

		  		$output .= '</tbody>';
 
		  		$error = 'false'; 

 			}else{

			$error = 'true';
	  		$output = "Erreur de trouvé le produits! Veuillez vérifier et réessayer.";

			}

		}else{

			$error = 'true';
	  		$output = "Error d'ajoute! Veuillez vérifier et réessayer.";

		}
 
	};








		if ( isset($_POST['action']) && $_POST['action'] == 'delete_reference' ) {

		if (is_numeric($_POST['reference']) ) {
			
			extract($_POST);

			$id = $reference; 

	   		$query = "SELECT * FROM products_dimensions WHERE id = '".$id."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$result = $statement->fetchAll();
	  		$total_row = $statement->rowCount();

 			if ($total_row != 0) {
 	
 	 
 				foreach ($result as $row ) {
 					$product = $row['product_id']; 
 				};

 				$query = "DELETE from products_dimensions WHERE id = '".$id."'";
	  			$statement = $connect->prepare($query);
	  			$statement->execute();


	  			$query = "SELECT * FROM products WHERE id = '".$product."'"; 
		  		$statement = $connect->prepare($query);
		  		$statement->execute(); 

		  		foreach ($result as $row ) {
 					
 					$old_reference = $row['reference'];
					$old_dimensions = $row['dimensions'];
					$old_pieces = $row['pieces'];
					$old_packing = $row['packing'];
  
 				};
 
		  		$output .= '<tbody><tr><th>Reference</th><th>dimensions</th><th>pieces</th><th>packing</th></tr>';
		  		
		  		$output .='<tr>
						    <td>'.$old_reference.'</td><td>'.$old_dimensions.'</td><td>'.$old_pieces.'</td><td>'.$old_packing.'</td>
						  </tr>';
			  	
	  			$query = "SELECT * FROM products_dimensions WHERE product_id = '".$product."'"; 
		  		$statement = $connect->prepare($query);
		  		$statement->execute(); 
		  		$result = $statement->fetchAll();

		  		foreach ($result as $row) {
		  		 	
		  			$output .='<tr>
						    <td>'.$row['reference'].'</td><td>'.$row['dimensions'].'</td><td>'.$row['pieces'].'</td><td>'.$row['packing'].'</td>
						  </tr>';

		  		};

		  		$output .= '</tbody>';
 
		  		$error = 'false'; 

 			}else{

			$error = 'true';
	  		$output = "Erreur de trouvé le reference! Veuillez vérifier et réessayer.";

			}

		}else{

			$error = 'true';
	  		$output = "Error de supprimer ! Veuillez vérifier et réessayer.";

		}
 
	};










	 if (isset($_FILES) && isset($_POST) && $_POST['action'] == 'add_product') {
 
		  
		if ($_POST['type']!="" && is_numeric($_POST['type']) && is_numeric($_POST['qte_pcs']) && is_numeric($_POST['qte_pqt']) ) {

			extract($_POST);

			$description = strtolower($description);
			$reference = strtolower($reference);
			$dimension = strtolower($dimension);
			$image = $_FILES['picture'];

			if ($qte_pqt=='') {
				$qte_pqt = 1;
			};

	  		$query = "SELECT * FROM categories_types WHERE id = '".$type."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$total_row = $statement->rowCount();

	  		if ($total_row != 0) {
    
		  			$query = "SELECT MAX(classement) AS LastClassement FROM products WHERE statut = 1 AND types = ".$type.""; 
		  			$statement = $connect->prepare($query);
		  			$statement->execute(); 
		  			$result = $statement->fetchAll(); 

		  			foreach ($result as $row ) {

		  				$classement = $row['LastClassement']+1;  
   
							$nom=$image['name'];
							$tmp=$image['tmp_name'];
							$infor_fichier = pathinfo($nom);
							$extension=$infor_fichier['extension'];
							$autorise=array('jpeg','jpg','png');
							$taille=filesize($tmp);
							$newnom=sha1(date("Y-m-d h:i:s")).".".$extension;

							if($taille > 8000000){ 

								$error  = 'true';
	  							$output = "Erreur de telecharger la photo! le fichier est top volumineux , choisissez un fichier de taille < 8Mo"; 

							}elseif (! in_array(strtolower($extension), $autorise)) {

								$error  = 'true';
	  							$output = "Erreur de telecharger la photo! Veuillez choisir autre format de photos et réessayer."; 

							}elseif(move_uploaded_file($tmp, "../public/files/uploads/products/".$newnom)){

								$sourcefile = "./public/files/uploads/products/".$newnom; 
								$query = 'INSERT INTO products (types,description,reference,dimensions,pieces,packing,images,statut,classement) VALUES ("'.$type.'","'.$description.'","'.$reference.'","'.$dimension.'","'.$qte_pcs.'","'.$qte_pqt.'","'.$sourcefile.'","1","'.$classement.'")';
				  				$statement = $connect->prepare($query);
				  				$statement->execute();

				  				$error = 'false';
	  							$output = "Produit a été ajouté avec succès.";
							 
							}else {

							    $error = 'true';
	  							$output = "Erreur de telecharger la photo! Veuillez contacter le developpeur.";

							}; 
 						  
		  			}

		   

	  		}else{
	  			$error = 'true';
	  			$output = "Error d'ajoute! Veuillez vérifier et réessayer.";
	  		}


		}else{
			$error = 'true';
	  		$output = "Error d'ajoute! Veuillez vérifier et réessayer.";
		}
	}elseif (isset($_FILES) && isset($_POST) && $_POST['action'] == 'edit_product') {

	  
		if ($_POST['product']!="" && is_numeric($_POST['product']) && is_numeric($_POST['qte_pcs']) && is_numeric($_POST['qte_pqt']) ) {

			extract($_POST);

			$description = strtolower($description);
			$reference = strtolower($reference);
			$dimension = strtolower($dimension);

			if ($qte_pqt=='') {
				$qte_pqt = 1;
			};

			$query = "SELECT * FROM products WHERE id = '".$product."'"; 
	  		$statement = $connect->prepare($query);
	  		$statement->execute(); 
	  		$total_row = $statement->rowCount();

	  		if ($total_row != 0) {

	  						if (!empty($_FILES)) {
				 
								$image = $_FILES['picture'];

								$nom=$image['name'];
								$tmp=$image['tmp_name'];
								$infor_fichier = pathinfo($nom);
								$extension=$infor_fichier['extension'];
								$autorise=array('jpeg','jpg','png');
								$taille=filesize($tmp);
								$newnom=sha1(date("Y-m-d h:i:s")).".".$extension;

								if($taille > 8000000){ 

									$error  = 'true';
		  							$output = "Erreur de telecharger la photo! le fichier est top volumineux , choisissez un fichier de taille < 8Mo"; 

								}elseif (! in_array(strtolower($extension), $autorise)) {

									$error  = 'true';
		  							$output = "Erreur de telecharger la photo! Veuillez choisir autre format de photos et réessayer."; 

								}elseif(move_uploaded_file($tmp, "../public/files/uploads/products/".$newnom)){

									$sourcefile = "./public/files/uploads/products/".$newnom; 
									$query = 'UPDATE products SET  description="'.$description.'", reference="'.$reference.'",dimensions="'.$dimension.'",pieces="'.$qte_pcs.'",packing="'.$qte_pqt.'",images="'.$sourcefile.'" WHERE id='.$product;
					  				$statement = $connect->prepare($query);
					  				
					  				if ($statement->execute()) {
					  					$error = 'false';
		  								$output = "Produit a été modifié avec succès.";
					  				}else{
					  					$error = 'true';
		  								$output = "Erreur de modifier produit! Veuillez contacter le developpeur.";
					  				}

					  				
								 
								}else {

								    $error = 'true';
		  							$output = "Erreur de telecharger la photo! Veuillez contacter le developpeur.";

								}; 

							}else{	

								$query = 'UPDATE products SET  description="'.$description.'", reference="'.$reference.'",dimensions="'.$dimension.'",pieces="'.$qte_pcs.'",packing="'.$qte_pqt.'" WHERE id='.$product;
				  				$statement = $connect->prepare($query);
				  				
				  				if ($statement->execute()) {
				  					$error = 'false';
	  								$output = "Produit a été modifié avec succès.";
				  				}else{
				  					$error = 'true';
	  								$output = "Erreur de modifier produit! Veuillez contacter le developpeur.";
				  				}

							};
     
							
 						  
		  			 

		   

	  		}else{
	  			$error = 'true';
	  			$output = "Error de modifier! Veuillez vérifier et réessayer.";
	  		};
  

		}else{
			$error = 'true';
	  		$output = "Error d'ajoute! Veuillez vérifier et réessayer.";
		}
	};


 

};


if (isset($_POST['update'])) {
	
	foreach ($_POST['positions'] as $position) {
		$id = $position[0];
		$position = $position[1];

		 $query = "UPDATE products SET classement = '".$position."' WHERE id = '".$id."'"; 
		 $statement = $connect->prepare($query);
	     
	     if ($statement->execute()) {
	     	$error = 'false';
	        $output = "Les produits a été placé avec succès.";
	     }else{
	     	$error = 'true';
	     	$output = "Les produits n'ont pas été placés avec succès.";
	     } 

	}
};


$output = array(
		'error' => $error,
		'output' => $output
	);

	echo json_encode($output);

      
  ?>