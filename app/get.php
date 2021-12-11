<?php 

$connect = new PDO("mysql:host=localhost;dbname=eceb","root","");
session_start();


 
$error = '';
$output = '';

if (isset($_GET['action']) && !empty($_GET['action']) ) {
	
	if ($_GET['action'] == 'load') {
		
		$params = $_GET['params_new'];
		$params = explode("?", $params);

	 if ($params[0] == 'category') {

		$query = "SELECT * FROM categories ORDER BY classement ASC"; 
		$statement = $connect->prepare($query);
		$statement->execute();
		$total_row = $statement->rowCount();
	  

		if ($total_row != 0) {

			$result = $statement->fetchAll();

			$error = 'false';
			$output = '<div class="ul-menu ul-categories">
		 		 <ul>
		 		 	<li>
		 		 		<a id="btn-ShowFromCategory" class="btn-added"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter une catégorie</a>
		 		 	</li>
		 		 	';
		 
			foreach ($result as $row ) {
				 $statut = 'Disabled';
				 $switch = '';
				 if ($row['statut'] == 1) {
				 	$switch = 'switchOn';
				 	$statut = 'Enabled';
				 };

				$output .= '<li>
	 		 		<a class="btn-menu-categories" data-type="category?'.$row['nom_categorie'].'">'.$row['nom_categorie'].'</a><div class="grid-action-menu">
	 		 			<a class="btn-edit-categories" data-id="'.$row['id'].'" ><i class="fa fa-pencil" aria-hidden="true"></i></a> 
					<!-- <a><i aria-hidden="true" class="fa fa-trash"></i></a> -->
						</div><div class="grid-switch" data-category="'.$row['id'].'" ><div data-category="'.$row['id'].'" class="switch-categories switch '.$switch.'"><span>'.$statut.'</span></div>
					</div>
	 		 	</li>';
 
			};

				 $output .='
					 		  </ul>
						 		 </div> 
						 		  <div class="content-form-categories">
						 		 	<div class="bg-form"></div>
						 		 	<div class="form-container">
					 		 			<div class="form-grids" style="margin-bottom: 20px;">
					 		 			<span class="form-get-tables" style="font-family: proxyFontBold;color: white;background: #72c169;">Liste des categories</span>
		 		 			';

 		 			foreach ($result as $row ) { 
						$output .= '<span data-type="'.$row['nom_categorie'].'" class="form-get-tables">'.$row['nom_categorie'].'</span>';
					}; 

		 		 	$output .= '
		 		 		</div>
		 		 		<div class="form-grids hide">
		 		 			<span class="succes-span">
		        				<i class="fa fa-check" aria-hidden="true"></i> Categorie a été ajouté avec succès.</span>
		 		 		</div>
		 		 		<div class="form-grids hide">
		 		 			<span class="incorrect-span">
		        				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error d\'ajoute! Veuillez vérifier et réessayer.</span>
		 		 		</div> 
		 		 		<div class="form-grids required-grid">
		 		 			<i class="fa fa-folder-open-o" aria-hidden="true" ></i> 
		 		 			<input type="text" id="IDcategorie" placeholder="Nom de categorie..">
		 		 			<span class="required-slide">Nom de categorie..</span>
		 		 		</div>
		 		 		<div class="form-grids">
		 		 			<a id="addCategorie" class="btn-save" >
		 		 				<span><i class="fa fa-plus" aria-hidden="true"></i> ajouter</span>
		 		 			</a>
		 		 			<a class="btn-spin hide" ><i class="fa fa-spinner" aria-hidden="true"></i></a>
		 		 		</div>
		 		 		<div class="form-grids">
		 		 			<a id="btn-HideFromCategory" data-category="category" class="btn-back" >
		 		 				<span><i class="fa fa-chevron-left" aria-hidden="true"></i> retour</span>
		 		 			</a>
		 		 		</div>
		 		 	</div>
		 		 </div>';


		if (isset($params[1]) && $params[1] != "") {
	  	
	 	$query = 'SELECT * FROM categories WHERE nom_categorie="'.$params[1].'"'; 
	 	$statement = $connect->prepare($query); 
		$statement->execute();
		$result = $statement->fetchAll();	
		$total_row = $statement->rowCount();

		if ($total_row != 0) {

		foreach ($result as $row) {
			$id = $row['id'];
		};

		$query = 'SELECT * FROM categories_types WHERE categories="'.$id.'" ORDER BY classement ASC'; 
		$statement = $connect->prepare($query); 
		$statement->execute();
		$total_row = $statement->rowCount();
		$result = $statement->fetchAll();	

		$output .= ' <div class="content-form-types">
						 		 	<div class="bg-form"></div>
						 		 	<div class="form-container">
					 		 			<div class="form-grids" style="margin-bottom: 20px;">
					 		 			<span class="form-get-tables" style="font-family: proxyFontBold;color: white;background: #72c169;">'.$params[1].'</span>
		 		 			';

		 		if ($total_row == 0) {
		 		   $output .= '<span style="display: block;padding: 1px 20px;text-align: left;background: whitesmoke;color: #424242;font-size: 15px;border-bottom: 2px solid #9d9d9d;">Aucun type de produit n\'a été trouvé.</span>';
			    };

 		 			foreach ($result as $row ) {
						$output .= '<span data-type="'.$row['types'].'" class="form-get-tables">'.$row['types'].'</span>';
					}; 
					
		 		 	$output .= '
		 		 		</div>
		 		 		<div class="form-grids hide">
		 		 			<span class="succes-span">
		        				<i class="fa fa-check" aria-hidden="true"></i> type a été ajouté avec succès.</span>
		 		 		</div>
		 		 		<div class="form-grids hide">
		 		 			<span class="incorrect-span">
		        				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error d\'ajoute! Veuillez vérifier et réessayer.</span>
		 		 		</div> 
		 		 		<div class="form-grids required-grid">
		 		 			<i class="fa fa-folder-open-o" aria-hidden="true" ></i> 
		 		 			<input type="text" id="NameType" placeholder="Nom de type..">
		 		 			<span class="required-slide">Nom de type..</span>
		 		 		</div>
		 		 		<div class="form-grids">
		 		 			<a id="addType" class="btn-save" data-category="'.$id.'">
		 		 				<span><i class="fa fa-plus" aria-hidden="true"></i> ajouter</span>
		 		 			</a>
		 		 			<a class="btn-spin hide" ><i class="fa fa-spinner" aria-hidden="true"></i></a>
		 		 		</div>
		 		 		<div class="form-grids">
		 		 			<a id="btn-HideFromType" class="btn-back" >
		 		 				<span><i class="fa fa-chevron-left" aria-hidden="true"></i> retour</span>
		 		 			</a>
		 		 		</div>
		 		 	</div>
		 		 </div>';
  
				if ($total_row != 0) {
  
				  $output .= '<div class="ul-menu">
				 		 <ul>
					 		 <li>
					 		 	<a id="btn-ShowFromType" class="btn-added"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un nouveau type de produit</a>
					 		 	</li>';

		  
				foreach ($result as $row ) {
							 $statut = 'Disabled';
							 $switch = '';
							 if ($row['statut'] == 1) {
							 	$switch = 'switchOn';
							 	$statut = 'Enabled';
							 };

							$output .= '<li>
				 		 		<a class="btn-menu-types" data-type="'.$row['types'].'">'.$row['types'].'</a><div class="grid-action-menu">
				 		 			<a class="btn-edit-types" data-category="'.$id.'" data-type="'.$row['id'].'" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<a><i aria-hidden="true" class="fa fa-trash"></i></a>
									</div><div class="grid-switch" data-type="'.$row['id'].'" ><div data-type="'.$row['id'].'" class="switch-types switch '.$switch.'"><span>'.$statut.'</span></div>
								</div>
				 		 	</li>';
			 
						};



				   
				 $output .= '</ul>
								</div>';

				}else{ 
			 
						$output .= '<div class="ul-menu">
				 		 <ul>
					 		 <li>
					 		 	<a id="btn-ShowFromType" class="btn-added"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un nouveau type de produit</a>
					 		 	<span style="color: #aaa;font-variant: all-petite-caps;font-family: proxyFont;font-size: 16px;display: block;">Aucun type de produit n\'a été trouvé.</span>
					 		 	</li>
					 		 	</ul>
					 	</div>';
				}

			}else{

				  	$output .= '<div class="content-error-404" style="min-height: auto;">
						  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
						</div>';

			}

	 	
		  
		 }





	  		
	  	}

	 }elseif ($params[0] == 'products' ) {
					

				if (!isset($params[1])) {
				 	

	 			$query = 'SELECT * FROM categories_types ORDER BY classement ASC'; 
				$statement = $connect->prepare($query); 
				$statement->execute();
				$total_row = $statement->rowCount();
				$result = $statement->fetchAll();	
 
				$output = '<div class="content-products">
							  <div class="container-products">
							 <ul>
							  <li>
							  <a class="a-title_categories">Emballage Alimentaire</a>
							  <ul>';


				foreach ($result as $row) {
					if ($row['categories'] == '1') {
						 $output .= '<li>
								  		<a class="btn-products-types" data-type="products?'.$row['id'].'" >'.$row['types'].'</a>
								  	 </li>';
					}
				};

							  	
				$output .= '</ul>
							   </li> 
							   <li>
							  <a class="a-title_categories">Emballage biodegradable</a>
							  <ul>';

				foreach ($result as $row) {
					if ($row['categories'] == '2') {
						 $output .= '<li>
								  		<a class="btn-products-types" data-type="products?'.$row['id'].'" >'.$row['types'].'</a>
								  	 </li>';
					}
				};		


				$output .= '</ul>
							</li>
							   <li>
							  <a class="a-title_categories">Hygiene</a>
							   <ul>';

				foreach ($result as $row) {
					if ($row['categories'] == '3') {
						 $output .= '<li>
								  		<a class="btn-products-types" data-type="products?'.$row['id'].'" >'.$row['types'].'</a>
								  	 </li>';
					}
				};	


				$output .= '</ul>
							 </li>
							  </ul>
							   </div>
								</div>';

				 }elseif (isset($params[1]) && is_numeric($params[1]) ) {
	  	
				 	$query = 'SELECT * FROM categories_types WHERE id="'.$params[1].'"'; 
				 	$statement = $connect->prepare($query); 
					$statement->execute();
					$result = $statement->fetchAll();	
					$total_row = $statement->rowCount();

					foreach ($result as $row ) {
						$types = $row['types'];
						$id = $row['id'];
					};

						if ($total_row != 0) {

							$error = 'false';
							$output .= '<div class="content-products"> 
							 			 <div class="container-products">
							 			 <div class="bars-products">
							 			 	<span class="span-products-title">'.$types.'</span>
							 			  <a class="btn-products-back"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
							 			 </div>

							 			 <div class="bars-options" >
											<a class="btn-ajouter-show-produit-form" data-type="'.$id.'"><i class="fa fa-plus" aria-hidden="true"></i> ajouter un produit</a>
										 </div>


							 			 <div class="content-grids-products">';

							$query = 'SELECT * FROM products WHERE types="'.$id.'" ORDER BY classement DESC'; 
						 	$statement = $connect->prepare($query); 
							$statement->execute();
							$result = $statement->fetchAll();	
							$total_row = $statement->rowCount();

							if ($total_row != 0) {

								foreach ($result as $row ) {

						 
									$output .= '<div class="grids-products" data-product="'.$row['id'].'" data-position="'.$row['classement'].'">
								 			    <div class="products-zone">
								 			    <a class="btn-edit-show-produit-form hide" data-product="'.$row['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i> modifier</a>
								 			     <span class="display-photo-product" style="background-image:url(.'.$row['images'].');"></span> 
								 			     <span class="description-products">'.$row['description'].'</span>
								 			     <span class="doubble-info-products">
								 			     	<span class="span-key-reference"></span>
								 			     	<span class="span-value-reference">'.$row['reference'].'</span>
								 			     </span>
								 			     <span class="doubble-info-products">
								 			     	<span class="span-key-width"></span>
								 			     	<span class="span-value-width">'.$row['dimensions'].'</span>
								 			     </span>
								 			     <span class="doubble-info-products">
								 			     	<span class="span-key-package"></span>
								 			     	<span class="span-value-package">'.$row['pieces'].'pcs - '.$row['packing'].'pqt</span>
								 			     </span>
								 			    </div>
								 			   </div>';

								}


							}else{

								$output .= '<span style="color: #717171;text-align: left;display: block;">Aucun produit été ajouté.</span>';

							};

							 

							 	$output .='</div>

							 			 </div>
							 			</div>';

						}else{
							$error = 'true';
							$output = '<div class="content-error-404">
							  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
							</div>';
						}

				}

 				// END PARAMS PRODUCTS

			}elseif ($params[0] == 'contacts' ) {
					 
					if (isset($params[1]) && !empty($params[1]) && is_numeric($params[1]) ) {
				
  
								$query = 'SELECT * FROM contacts WHERE id="'.$params[1].'"'; 
							 	$statement = $connect->prepare($query); 
								$statement->execute();
								 
								$count = $statement->rowCount();

								if ($count!=0) {

									$contacts = $statement->fetchAll();	
									
									foreach ($contacts as $contact) {
			 							$id = $contact['id'];
			 							$entreprise = $contact['nom_entreprise'];
			 							$responsable = $contact['nom_responsable'];
			 							$email = $contact['email'];
			 							$phone = $contact['phone'];
			 							$message = $contact['description'];
			 							$date = $contact['date_demande'];

			 							$etticket = '';

								 		if ($contact['verification']==0) {
								 			$etticket = '<span class="etticket-nonvalide">Non validé</span>';
								 		}else{
								 			$etticket = '<span class="etticket-valide">validé</span>';
								 		};


									};


									$output .= '<div class="col-lg-12" style="min-height: 400px;background: whitesmoke;">
												<div class="col-lg-12 col-xl-12 col-md-12" style="margin-top: 10px;">
													<a class="btn-back btn-menu-sub" data-category="contacts"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> retour</a>
												</div>
												<div class="col-lg-6 col-xl-6 col-md-6 section-infos-client">
													<div class="grids-line">
														<span class="title-info">Informations du client:</span> 
													</div>
													<div class="grids-line">
														<span class="titre-info">date:</span>
														<span class="value-info">'.$date.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Nom d\'entreprise:</span>
														<span class="value-info">'.$entreprise.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Nom du responsable:</span>
														<span class="value-info">'.$responsable.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">email:</span>
														<span class="value-info">'.$email.' '.$etticket.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">telephone:</span>
														<span class="value-info">'.$phone.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Message:</span>
														<span class="value-info">'.$message.'</span>
													</div>
												</div>';
  

								};
 


				}else{

  
						$query = 'SELECT * FROM contacts WHERE statut="0" ORDER BY id DESC'; 
					 	$statement = $connect->prepare($query); 
						$statement->execute();
						 
						$total_row = $statement->rowCount();
						
							
						 $output .= '<p class="title-section-contact" style="font-size: 20px;font-variant: all-petite-caps;font-family: proxyfont;color: #424242;text-align: left;display: block;padding: 5px 0;padding-left: 0px;padding-left: 0px;margin-bottom: 0;padding-left: 20px;font-family:proxyfontbold;padding:0;">liste des contacts</p><table class="table">
							  <thead>
							    <tr style="font-variant:all-petite-caps;">
							      <th scope="col">Entreprise</th>
							      <th scope="col">Responsable</th>
							      <th scope="col">email</th>
							      <th scope="col">telephone</th>
							      <th scope="col">date demande</th>
							    </tr>
							  </thead>
							  <tbody>';

							 if ($total_row!=0) {

							 	$contacts = $statement->fetchAll();	 

							 	foreach ($contacts as $contact) {

							 		$etticket = '';

							 		if ($contact['verification']==0) {
							 			$etticket = '<span class="etticket-nonvalide">Non validé</span>';
							 		}else{
							 			$etticket = '<span class="etticket-valide">validé</span>';
							 		};
							 		 
							 		 $output .='<tr class="btn-menu-sub tr-line" data-category="contacts?'.$contact['id'].'">
										      <th scope="row">'.$contact['nom_entreprise'].'</th>
										      <td>'.$contact['nom_responsable'].'</td>
										      <td>'.$contact['email'].' '.$etticket.'</td>
										      <td>'.$contact['phone'].'</td>
										      <td>'.$contact['date_demande'].'</td>
										    </tr>';

							 	};
							 	
							 	

							 };

								

							$output .= '</tbody>
										</table>';



				}




 				// END PARAMS CONTACTS
			}elseif ($params[0] == 'commandes' ) {

				if (isset($params[1]) && !empty($params[1]) && is_numeric($params[1]) ) {
				
  
								$query = 'SELECT * FROM demandes WHERE type_demande="commande" AND id="'.$params[1].'"'; 
							 	$statement = $connect->prepare($query); 
								$statement->execute();
								 
								$count = $statement->rowCount();

								if ($count!=0) {

									$commandes = $statement->fetchAll();	
									
									foreach ($commandes as $commande) {
			 							$id = $commande['id'];
			 							$entreprise = $commande['nom_entreprise'];
			 							$responsable = $commande['nom_responsable'];
			 							$email = $commande['email'];
			 							$phone = $commande['phone'];
			 							$message = $commande['description'];
			 							$date = $commande['date_demande'];

			 							$etticket = '';

								 		if ($commande['verification']!=0) {
								 			$etticket = '<span class="etticket-valide">validé</span>';
								 		}else{
								 			$etticket = '<span class="etticket-nonvalide">Non validé</span>';
								 		};


									};


									$output .= '<div class="col-lg-12" style="min-height: 400px;background: whitesmoke;">
												<div class="col-lg-12 col-xl-12 col-md-12" style="margin-top: 10px;">
													<a class="btn-back btn-menu-sub" data-category="commandes"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> retour</a>
												</div>
												<div class="col-lg-12 col-xl-12 col-md-12 section-infos-client">
													<div class="grids-line">
														<span class="title-info">Informations du client:</span> 
													</div>
													<div class="grids-line">
														<span class="titre-info">date:</span>
														<span class="value-info">'.$date.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Nom d\'entreprise:</span>
														<span class="value-info">'.$entreprise.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Nom du responsable:</span>
														<span class="value-info">'.$responsable.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">email:</span>
														<span class="value-info">'.$email.' '.$etticket.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">telephone:</span>
														<span class="value-info">'.$phone.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Message:</span>
														<span class="value-info">'.$message.'</span>
													</div>
												</div>
												<div class="col-lg-12 col-xl-12 col-md-12 section-infos-produits">
													<div class="grids-line">
														<span class="title-info">Informations produits:</span> 
													</div>
													<ul class="ul-title-table">
														  <li>image de produit</li>
														  <li>Reference</li>
														  <li style="width: 40%;">description</li>
														  <li>quantite (pqt)</li> 
													 </ul>';

									
									 
									$query = 'SELECT * FROM demandes_details WHERE demande_id="'.$id.'"'; 
								 	$statement = $connect->prepare($query); 
									$statement->execute();
									$count = $statement->rowCount();

									if ($count!=0) {
										
										$demandes_details = $statement->fetchAll();	

										foreach ($demandes_details as $demande_d) {
											
											$reference = $demande_d['reference'];
											$referencedetailID = $demande_d['id'];

											$query = 'SELECT * FROM products WHERE id="'.$reference.'"'; 
										 	$statement = $connect->prepare($query); 
											$statement->execute(); 
											$products = $statement->fetchAll();	

											foreach ($products as $product) {
												
												 $img = $product['images'];
												 $ref = $product['reference'];
												 $descri = $product['description'];
												 $dimensions = $product['dimensions'];
												 $pieces = $product['pieces'];
												 $packing = $product['packing'];

											};
			  
											if ($demande_d['reference_detail']!='0') {

											$query = 'SELECT * FROM products_dimensions WHERE id="'.$demande_d['reference_detail'].'"'; 
										 	$statement = $connect->prepare($query); 
											$statement->execute(); 
											$count = $statement->rowCount();

												if ($count!=0) {

													$products_details = $statement->fetchAll();

													foreach ($products_details as $p_detail) {

														 $ref = $p_detail['reference'];
														 $dimensions = $p_detail['dimensions'];
														 $pieces = $p_detail['pieces'];
														 $packing = $p_detail['packing'];

													}



													 
												};
												 
											};

											 $output .= '<ul class="ul-values-table">
														<li><span class="images-products" style="background-image: url(.'.$img.');"></span></li>
														   <li>
															 <span class="ref-products">'.$ref.'</span>
															</li> 
															<li style="width: 40%;">
															 <span class="description-products">'.$descri.'</span>
															 <span class="dimension-products">'.$dimensions.'</span>
															 <span class="dimension-products">'.$pieces.'pcs - 1pqt</span>
															</li>
															<li>
															 <span class="description-products">'.$demande_d['quantite'].'</span>
															</li> 
														</ul>';

										}

									};

									


								};

								

								 $output .= '</div>
										</div>';


				}else{



						$query = 'SELECT * FROM demandes WHERE type_demande="commande" ORDER BY id DESC'; 
					 	$statement = $connect->prepare($query); 
						$statement->execute();
						 
						$total_row = $statement->rowCount();
						
							
							$output .= '<p class="title-section-contact" style="font-size: 20px;font-variant: all-petite-caps;font-family: proxyfont;color: #424242;text-align: left;display: block;padding: 5px 0;padding-left: 0px;padding-left: 0px;margin-bottom: 0;padding-left: 20px;font-family:proxyfontbold;padding:0;">liste des commandes</p><table class="table">
										  <thead>
										    <tr style="font-variant:all-petite-caps;">
										      <th scope="col">Entreprise</th>
										      <th scope="col">Responsable</th>
										      <th scope="col">email</th>
										      <th scope="col">telephone</th>
										      <th scope="col">date demande</th>
										    </tr>
										  </thead>
										  <tbody>';

							 if ($total_row!=0) {

							 	$commandes = $statement->fetchAll();	 

							 	foreach ($commandes as $commande) {

							 		$etticket = '';

							 		if ($commande['verification']!=0) {
							 			$etticket = '<span class="etticket-valide">validé</span>';
							 		}else{
							 			$etticket = '<span class="etticket-nonvalide">Non validé</span>';
							 		};
							 		 
							 		 $output .='<tr class="btn-menu-sub tr-line" data-category="commandes?'.$commande['id'].'">
										      <th scope="row">'.$commande['nom_entreprise'].'</th>
										      <td>'.$commande['nom_responsable'].'</td>
										      <td>'.$commande['email'].' '.$etticket.'</td>
										      <td>'.$commande['phone'].'</td>
										      <td>'.$commande['date_demande'].'</td>
										    </tr>';

							 	};
							 	
							 	

							 };

								

							$output .= '</tbody>
										</table>';



				}

					
		

				

 				// END PARAMS ORDER
			}elseif ($params[0] == 'devis' ) {

				if (isset($params[1]) && !empty($params[1]) && is_numeric($params[1]) ) {
				
  
								$query = 'SELECT * FROM demandes WHERE type_demande="devis" AND id="'.$params[1].'"'; 
							 	$statement = $connect->prepare($query); 
								$statement->execute();
								 
								$count = $statement->rowCount();

								if ($count!=0) {

									$commandes = $statement->fetchAll();	
									
									foreach ($commandes as $commande) {
			 							$id = $commande['id'];
			 							$entreprise = $commande['nom_entreprise'];
			 							$responsable = $commande['nom_responsable'];
			 							$email = $commande['email'];
			 							$phone = $commande['phone'];
			 							$message = $commande['description'];
			 							$date = $commande['date_demande'];

			 							$etticket = '';

								 		if ($commande['verification']!=0) {
								 			$etticket = '<span class="etticket-valide">validé</span>';
								 		}else{
								 			$etticket = '<span class="etticket-nonvalide">Non validé</span>';
								 		};


									};


									$output .= '<div class="col-lg-12" style="min-height: 400px;background: whitesmoke;">
												<div class="col-lg-12 col-xl-12 col-md-12" style="margin-top: 10px;">
													<a class="btn-back btn-menu-sub" data-category="devis"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> retour</a>
												</div>
												<div class="col-lg-12 col-xl-12 col-md-12 section-infos-client">
													<div class="grids-line">
														<span class="title-info">Informations du client:</span> 
													</div>
													<div class="grids-line">
														<span class="titre-info">date:</span>
														<span class="value-info">'.$date.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Nom d\'entreprise:</span>
														<span class="value-info">'.$entreprise.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Nom du responsable:</span>
														<span class="value-info">'.$responsable.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">email:</span>
														<span class="value-info">'.$email.' '.$etticket.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">telephone:</span>
														<span class="value-info">'.$phone.'</span>
													</div>
													<div class="grids-line">
														<span class="titre-info">Message:</span>
														<span class="value-info">'.$message.'</span>
													</div>
												</div>
												<div class="col-lg-12 col-xl-12 col-md-12 section-infos-produits">
													<div class="grids-line">
														<span class="title-info">Informations produits:</span> 
													</div>
													<ul class="ul-title-table">
														  <li>image de produit</li>
														  <li>Reference</li>
														  <li style="width: 40%;">description</li>
														  <li>quantite (pqt)</li> 
													 </ul>';

									
									 
									$query = 'SELECT * FROM demandes_details WHERE demande_id="'.$id.'"'; 
								 	$statement = $connect->prepare($query); 
									$statement->execute();
									$count = $statement->rowCount();

									if ($count!=0) {
										
										$demandes_details = $statement->fetchAll();	

										foreach ($demandes_details as $demande_d) {
											
											$reference = $demande_d['reference'];
											$referencedetailID = $demande_d['id'];

											$query = 'SELECT * FROM products WHERE id="'.$reference.'"'; 
										 	$statement = $connect->prepare($query); 
											$statement->execute(); 
											$products = $statement->fetchAll();	

											foreach ($products as $product) {
												
												 $img = $product['images'];
												 $ref = $product['reference'];
												 $descri = $product['description'];
												 $dimensions = $product['dimensions'];
												 $pieces = $product['pieces'];
												 $packing = $product['packing'];

											};
			  
											if ($demande_d['reference_detail']!='0') {

											$query = 'SELECT * FROM products_dimensions WHERE id="'.$demande_d['reference_detail'].'"'; 
										 	$statement = $connect->prepare($query); 
											$statement->execute(); 
											$count = $statement->rowCount();

												if ($count!=0) {

													$products_details = $statement->fetchAll();

													foreach ($products_details as $p_detail) {

														 $ref = $p_detail['reference'];
														 $dimensions = $p_detail['dimensions'];
														 $pieces = $p_detail['pieces'];
														 $packing = $p_detail['packing'];

													}



													 
												};
												 
											};

											 $output .= '<ul class="ul-values-table">
														<li><span class="images-products" style="background-image: url(.'.$img.');"></span></li>
														   <li>
															 <span class="ref-products">'.$ref.'</span>
															</li> 
															<li style="width: 40%;">
															 <span class="description-products">'.$descri.'</span>
															 <span class="dimension-products">'.$dimensions.'</span>
															 <span class="dimension-products">'.$pieces.'pcs - 1pqt</span>
															</li>
															<li>
															 <span class="description-products">'.$demande_d['quantite'].'</span>
															</li> 
														</ul>';

										}

									};

									


								};

								

								 $output .= '</div>
										</div>';


				}else{



						$query = 'SELECT * FROM demandes WHERE type_demande="devis" ORDER BY id DESC'; 
					 	$statement = $connect->prepare($query); 
						$statement->execute();
						 
						$total_row = $statement->rowCount();
						 
						$output .= '<p class="title-section-contact" style="font-size: 20px;font-variant: all-petite-caps;font-family: proxyfont;color: #424242;text-align: left;display: block;padding: 5px 0;padding-left: 0px;padding-left: 0px;margin-bottom: 0;padding-left: 20px;font-family:proxyfontbold;padding:0;">liste des demandes devis</p><table class="table">
										  <thead>
										    <tr style="font-variant:all-petite-caps;">
										      <th scope="col">Entreprise</th>
										      <th scope="col">Responsable</th>
										      <th scope="col">email</th>
										      <th scope="col">telephone</th>
										      <th scope="col">date demande</th>
										    </tr>
										  </thead>
										  <tbody>';

							 if ($total_row!=0) {

							 	$commandes = $statement->fetchAll();	 

							 	foreach ($commandes as $commande) {

							 		$etticket = '';

							 		if ($commande['verification']!=0) {
							 			$etticket = '<span class="etticket-valide">validé</span>';
							 		}else{ 
							 			$etticket = '<span class="etticket-nonvalide">Non validé</span>';
							 		};
							 		 
							 		 $output .='<tr class="btn-menu-sub tr-line" data-category="devis?'.$commande['id'].'">
										      <th scope="row">'.$commande['nom_entreprise'].'</th>
										      <td>'.$commande['nom_responsable'].'</td>
										      <td>'.$commande['email'].' '.$etticket.'</td>
										      <td>'.$commande['phone'].'</td>
										      <td>'.$commande['date_demande'].'</td>
										    </tr>';

							 	};
							 	
							 	

							 };

								

							$output .= '</tbody>
										</table>';



				}

					
		

				

 				// END PARAMS ORDER
			}

 
	}elseif($_GET['action'] == 'form_types_edit'){
			
			$query = 'SELECT * FROM categories WHERE id="'.$_GET['categorie'].'"'; 
		 	$statement = $connect->prepare($query); 
			$statement->execute();
			$result = $statement->fetchAll();	 
			$total_row = $statement->rowCount();
 			// $nom_categorie = ''; 

			if ($total_row != 0) {
 
				$query = 'SELECT * FROM categories_types WHERE categories="'.$_GET['categorie'].'" AND id="'.$_GET['type'].'"'; 
			 	$statement = $connect->prepare($query); 
				$statement->execute(); 
				$total_row = $statement->rowCount();

				if ($total_row != 0) {

					$result = $statement->fetchAll();	 

					foreach ($result as $row) {

					$nom_type = $row['types']; 
					$id = $row['id'];  

					};
					
					$error  = 'false';  
					$output = '<div class="content-form-categories" style="left: 0px;">
								 		 	<div class="bg-form"></div>
								 		 	<div class="form-container">
							 		 			
				 		 		<div class="form-grids hide">
				 		 			<span class="succes-span">
				        				<i class="fa fa-check" aria-hidden="true"></i> type a été modifié avec succès.</span>
				 		 		</div>
				 		 		<div class="form-grids hide">
				 		 			<span class="incorrect-span">
				        				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error de modifié! Veuillez vérifier et réessayer.</span>
				 		 		</div> 
				 		 		<div class="form-grids required-grid">
				 		 			<i class="fa fa-folder-open-o" aria-hidden="true"></i> 
				 		 			<input type="text" id="NameTypeEdit" value="'.$nom_type.'" placeholder="Nom de type..">
				 		 			<span class="required-slide">Nom de type..</span>
				 		 		</div>
				 		 		<div class="form-grids">
				 		 			<a id="BtnEditType" class="btn-save" data-id="'.$id.'" >
				 		 				<span><i class="fa fa-pencil" aria-hidden="true"></i> modifier</span>
				 		 			</a>
				 		 			<a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
				 		 		</div>
				 		 		<div class="form-grids">
				 		 			<a id="btn-HideFromTypeEdit" class="btn-back">
				 		 				<span><i class="fa fa-chevron-left" aria-hidden="true"></i> retour</span>
				 		 			</a>
				 		 		</div>
				 		 	</div>
				 		 </div>';

				}else{

					$error = 'true';
					$output = 'Impossible to edit this categorie!';

				}
				 
			

			}else{

				$error = 'true';
				$output = 'Impossible to edit this categorie!';

			}

			

	}elseif ($_GET['action'] == 'form_product' && is_numeric($_GET['type']) ){

		extract($_GET); 

		$query = 'SELECT * FROM categories_types WHERE id='.$type; 
	 	$statement = $connect->prepare($query); 
		$statement->execute();
		$result = $statement->fetchAll();	
		$total_row = $statement->rowCount(); 

		if ($total_row!=0) {
			 
			foreach ($result as $row ) {
			$types = $row['types'];
			$id = $row['id'];
			};

			$error = 'false';
			$output .= '<div class="container-form">
													<div class="content-div-form">
														<div class="grids-form">
															<span class="title-form">'.$types.'</span>
														</div> 
														<div class="grids-form hide">
										 		 			<span class="succes-span">
										        				<i class="fa fa-check" aria-hidden="true"></i> Categorie a été ajouté avec succès.</span>
										 		 		</div>
										 		 		<div class="grids-form hide">
										 		 			<span class="incorrect-span">
										        				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error d\'ajoute! Veuillez vérifier et réessayer.</span>
										 		 		</div>
														<div class="grids-form" style="margin-bottom: 20px;text-align: center;">
															<img class="display-product"  >
															<input type="file" name="picture" data-type="picture" id="product-photo" accept=".jpeg,.jpg,.png" style="position: relative;">
														</div>
														<div class="grids-form" style="z-index:5;">
															<i class="fa fa-paperclip" aria-hidden="true"></i>
										 		 			<input type="text" id="IDreference" placeholder="Reference de produit..">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div> 
														<div class="grids-form" style="z-index:4;">
															<i class="fa fa-info-circle" aria-hidden="true"></i>
										 		 			<input type="text" id="IDdescription" placeholder="Descrition de produit..">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form" style="z-index:3;">
															<i class="fa fa-arrows" aria-hidden="true"></i>
										 		 			<input type="text" id="IDdimension" placeholder="Dimension de produit..">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form" style="z-index:2;">
															<i class="fa fa-pie-chart" aria-hidden="true"></i> 
										 		 			<input type="text" id="IDqte_pcs" placeholder="Quantité des pièces..">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form" style="z-index:1;">
															<i class="fa fa-archive" aria-hidden="true"></i>
										 		 			<input type="text" id="IDqte_pqt" placeholder="Quantité minimum des paquets..">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form">
															<a id="addProduct" data-type="'.$id.'" class="btn-save">
										 		 				<span><i class="fa fa-plus" aria-hidden="true"></i> ajouter</span>
										 		 			</a>
										 		 			<a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
														</div>
														<div class="grids-form" style="padding-top: 20px;">
										 		 			<a id="btn-HideFormProducts" class="btn-back">
										 		 				<span><i class="fa fa-chevron-left" aria-hidden="true"></i> retour</span>
										 		 			</a>
										 		 		</div>
													</div>
												</div>';

		}else{
			$error = 'true';
					$output = '<div class="content-error-404">
			  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
			</div>';
		}

		

	}elseif ($_GET['action'] == 'form_product_editing' && is_numeric($_GET['product']) ){

		extract($_GET); 

		$query = 'SELECT * FROM products WHERE id='.$product; 
	 	$statement = $connect->prepare($query); 
		$statement->execute();
		$result = $statement->fetchAll();	
		$total_row = $statement->rowCount(); 
  
		if ($total_row!=0) {
			 
			foreach ($result as $row ) {
			$types = $row['types'];
			$id = $row['id'];
			$description = $row['description'];
			$reference = $row['reference'];
			$dimension = $row['dimensions'];
			$pieces = $row['pieces'];
			$packing = $row['packing'];
			$image = $row['images'];
			};

			$query = 'SELECT * FROM categories_types WHERE id='.$types; 
		 	$statement = $connect->prepare($query); 
			$statement->execute();
			$result = $statement->fetchAll();

			foreach ($result as $row ) {
			$types = $row['types']; 
			};

			$error = 'false';
			$output .= '<div class="container-form">
													<div class="content-div-form">
														<div class="grids-form">
															<span class="title-form">'.$types.'</span>
														</div> 
														<div class="grids-form hide">
										 		 			<span class="succes-span">
										        				<i class="fa fa-check" aria-hidden="true"></i> Categorie a été modifié avec succès.</span>
										 		 		</div>
										 		 		<div class="grids-form hide">
										 		 			<span class="incorrect-span">
										        				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error de modifier! Veuillez vérifier et réessayer.</span>
										 		 		</div>
														<div class="grids-form" style="margin-bottom: 20px;text-align: center;padding-top: 150px;">
															<img class="display-product" src=".'.$image.'" >
															<input type="file" name="picture" data-type="picture" id="product-photo" accept=".jpeg,.jpg,.png" style="position: relative;">
														</div>
														<div class="grids-form" style="z-index:5;">
															<i class="fa fa-paperclip" aria-hidden="true"></i>
										 		 			<input type="text" id="IDreference" placeholder="Reference de produit.." value="'.$reference.'">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div> 
														<div class="grids-form" style="z-index:4;">
															<i class="fa fa-info-circle" aria-hidden="true"></i>
										 		 			<input type="text" id="IDdescription" placeholder="Descrition de produit.." value="'.$description.'">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form" style="z-index:3;">
															<i class="fa fa-arrows" aria-hidden="true"></i>
										 		 			<input type="text" id="IDdimension" placeholder="Dimension de produit.." value="'.$dimension.'">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form" style="z-index:2;">
															<i class="fa fa-pie-chart" aria-hidden="true"></i> 
										 		 			<input type="text" id="IDqte_pcs" placeholder="Quantité des pièces.." value="'.$pieces.'">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form" style="z-index:1;">
															<i class="fa fa-archive" aria-hidden="true"></i>
										 		 			<input type="text" id="IDqte_pqt" placeholder="Quantité minimum des paquets.." value="'.$packing.'">
										 		 			<span class="required-slide">Champs obligatoires !</span>
														</div>
														<div class="grids-form">
															<a id="editProduct" data-product="'.$id.'" class="btn-save">
										 		 				<span><i class="fa fa-pencil" aria-hidden="true"></i> modifier</span>
										 		 			</a>
										 		 			<a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
														</div>
														<div class="grids-form">
															<a data-product="'.$id.'" id="addProductDimensions" class="btn-added-dimensions">
										 		 				<span><i class="fa fa-plus" aria-hidden="true"></i> dimensions</span>
										 		 			</a> 
														</div>
														<div class="grids-form" style="padding-top: 20px;">
										 		 			<a id="btn-HideFormProductEditing" class="btn-back">
										 		 				<span><i class="fa fa-chevron-left" aria-hidden="true"></i> retour</span>
										 		 			</a>
										 		 		</div>
													</div>
												</div>';

		}else{
			$error = 'true';
					$output = '<div class="content-error-404">
			  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
			</div>';
		}

		

	}elseif ($_GET['action'] == 'form_product_more' && is_numeric($_GET['product']) ){

		extract($_GET); 
 

		$query = 'SELECT * FROM products WHERE id='.$product; 
	 	$statement = $connect->prepare($query); 
		$statement->execute();
		$result = $statement->fetchAll();	
		$total_row = $statement->rowCount(); 
  
		if ($total_row!=0) {

			foreach ($result as $row ) {
			$id = $row['id']; 
			$types = $row['types']; 
			$image = $row['images']; 
			$description = $row['description']; 
			$reference = $row['reference']; 
			$dimensions = $row['dimensions']; 
			$pieces = $row['pieces']; 
			$packing = $row['packing']; 
			
			};
	  
			$query_f = 'SELECT * FROM categories_types WHERE id='.$types; 
		 	$statement_f = $connect->prepare($query_f); 
			$statement_f->execute();
			$result_f = $statement_f->fetchAll();

			foreach ($result_f as $rows ) {
			$types = $rows['types']; 
			};

			$error = 'false';
			$output .= '<div class="content-div-form">
								<div class="grids-form">
									<span class="title-form">'.$types.'</span>
								</div> 
								<div class="grids-form hide">
				 		 			<span class="succes-span">
				        				<i class="fa fa-check" aria-hidden="true"></i> reference a été ajouté avec succès.</span>
				 		 		</div>
				 		 		<div class="grids-form hide">
				 		 			<span class="incorrect-span">
				        				<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error de modifier! Veuillez vérifier et réessayer.</span>
				 		 		</div>
								<div class="grids-form" style="margin-bottom: 20px;text-align: center;padding-top: 150px;">
									<img class="display-product" src=".'.$image.'" >
								</div>
								<div class="grids-form">
									<span class="title-form-description">'.$description.'</span>
								</div> 
								<div class="grids-form" style="z-index:5;">
									<table width="100%" class="table-product-dimensions">
									  <tr>
									    <th>Reference</th><th>dimensions</th><th>pieces</th><th>packing</th><th>-</th>
									  </tr>';


							$output .='<tr>
							    <td>'.$reference.'</td><td>'.$dimensions.'</td><td>'.$pieces.'</td><td>'.$packing.'</td><td><a style="color:#424242;">-</a></td>
							  </tr>';

			$query = 'SELECT * FROM products_dimensions WHERE product_id='.$product; 
		 	$statement = $connect->prepare($query); 
			$statement->execute();
			$result = $statement->fetchAll();		
			$total_row =  $statement->rowCount(); 

			if ($total_row!=0) {
				
				foreach ($result as $row ) {
						$output .='<tr>
						    <td>'.$row['reference'].'</td><td>'.$row['dimensions'].'</td><td>'.$row['pieces'].'</td><td>'.$row['packing'].'</td><td><a class="btn-detele-dimensions" data-id="'.$row['id'].'" >delete</a></td>
						  </tr>';
				};

			};
			
 

						$output .='</table>
								</div>
								<div class="grids-form" style="z-index:5;">
									<i class="fa fa-paperclip" aria-hidden="true"></i>
				 		 			<input type="text" id="IDreference" placeholder="Reference de produit.." >
				 		 			<span class="required-slide">Champs obligatoires !</span>
								</div>  
								<div class="grids-form" style="z-index:3;">
									<i class="fa fa-arrows" aria-hidden="true"></i>
				 		 			<input type="text" id="IDdimension" placeholder="Dimension de produit.." >
				 		 			<span class="required-slide">Champs obligatoires !</span>
								</div>
								<div class="grids-form" style="z-index:2;">
									<i class="fa fa-pie-chart" aria-hidden="true"></i> 
				 		 			<input type="text" id="IDqte_pcs" placeholder="Quantité des pièces.." >
				 		 			<span class="required-slide">Champs obligatoires !</span>
								</div>
								<div class="grids-form" style="z-index:1;">
									<i class="fa fa-archive" aria-hidden="true"></i>
				 		 			<input type="text" id="IDqte_pqt" placeholder="Quantité minimum des paquets.." >
				 		 			<span class="required-slide">Champs obligatoires !</span>
								</div>
								<div class="grids-form">
									<a id="addProduct_dimension" data-product="'.$id.'" class="btn-save">
				 		 				<span><i class="fa fa-plus" aria-hidden="true"></i> ajouter</span>
				 		 			</a>
				 		 			<a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
								</div> 
								<div class="grids-form" style="padding-top: 20px;">
				 		 			<a id="btn-HideFormProductEditing" class="btn-back">
				 		 				<span><i class="fa fa-chevron-left" aria-hidden="true"></i> retour</span>
				 		 			</a>
				 		 		</div>
							</div>';

		}else{
			$error = 'true';
					$output = '<div class="content-error-404">
			  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
			</div>';
		}

		

	}else{
		$error = 'true';
		$output = '<div class="content-error-404">
  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
</div>';
	}

}
 
$output = array(
		'error' => $error,
		'output' => $output
	);
echo json_encode($output);



 ?>