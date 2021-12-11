<?php 


require_once('./mail/SMTP.php');
require_once('./mail/PHPMailer.php');
require_once('./mail/Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;



$connect = new PDO("mysql:host=localhost;dbname=eceb","root","");
session_start();


 
$error = '';
$output = '';

if (isset($_GET['action']) && !empty($_GET['action']) ) {
	
	if ($_GET['action'] == 'load') {
		
		$params = $_GET['params_new'];
		$params = explode("?", $params);

	 if( ($params[0] == 'search' || $params[0] == 'search.php') && !empty($params[1]) ){

	 	$params_target_1 = str_replace('_', ' ',  $params[1]);  

	 	$query = "SELECT * FROM products WHERE reference LIKE '%".$params_target_1."%' OR description LIKE '%".$params_target_1."%'"; 
		$statement = $connect->prepare($query);
		$statement->execute();
		$count = $statement->rowCount();

		if ($count!=0) {

			$products = $statement->fetchAll();

			if ($count>1) {
				$output .= '<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 directory-up-produits">
						<span style="color: #424242;font-size: 15px;font-variant: all-petite-caps;display: block;" >"'.$count.'" produits trouvés.</span>
						</div>';
			}else{
				$output .= '<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 directory-up-produits">
						<span style="color: #424242;font-size: 15px;font-variant: all-petite-caps;display: block;" >"'.$count.'" produit trouvé.</span>
						</div>';
			}

			foreach ($products as $product) {

				$query = "SELECT * FROM categories_types WHERE id='".$product['types']."'"; 
				$statement = $connect->prepare($query);
				$statement->execute(); 
				$types = $statement->fetchAll();

				foreach ($types as $type) {
						
					$query = "SELECT * FROM categories WHERE id='".$type['categories']."'"; 
					$statement = $connect->prepare($query);
					$statement->execute(); 
					$categories = $statement->fetchAll();

					foreach ($categories as $categorie) {
						
						$error = 'false';

						$nom_categorie = str_replace(' ', '_',  $categorie['nom_categorie']);
						$nom_type = str_replace(' ', '_',  $type['types']);

						$params1 = str_replace(' ', '_',  $categorie['nom_categorie']);
   
						$output .= '<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
								    <div class="grid-items-produits proxy-link" data-link="produits?'.$nom_categorie.'?'.$nom_type.'?'.$product['id'].'"> 
								         <span class="display-photo-product" style="background-image:url('.$product['images'].');"></span> 
								         <span class="description-products">'.$product['description'].'</span>
								         <span class="doubble-info-products">
								          <span class="span-key-reference"></span>
								          <span class="span-value-reference">'.$product['reference'].'</span>
								         </span>';

							if ($product['dimensions']!='-'&&$product['dimensions']!=' ') {
								$output .= ' <span class="doubble-info-products">
								          <span class="span-key-width"></span>
								          <span class="span-value-width">'.$product['dimensions'].'</span>
								         </span>';
							};
								        
							$output .= '<span class="doubble-info-products">
								          <span class="span-key-package"></span>
								          <span class="span-value-package">';
		  
								          if ($product['pieces']==1) {
								          	$output .= $product['pieces'].'pc';
								          }else{
								          	$output .= $product['pieces'].'pcs';
								          };

								         

								       $output .= '</span>
								         </span> 
								    </div> 
								   </div>';

					}

				};
				 

			}
   
		}else{

			$error = 'false'; 
			$output = '<div style="display: block;width: 100%;padding: 20px 10px 100px 10px;background: whitesmoke;border: 1px solid #e6e3e3;">
				<span style="color: #424242;font-size: 15px;font-variant: all-petite-caps;display:block;">"0" produit trouvé.<span>
				<span style="color: #939393;font-size: 13px;font-variant: all-petite-caps;display:block;font-family: proxyfontbold;">Nous vous proposons de voir nos différents produits disponibles en un clic ce lien : <a class="proxy-link" data-link="produits" style="color: #72c169;font-size: 15px;font-variant: all-petite-caps;cursor: pointer;">Nos produits<a><span>  
				</div>';

		}
 
	 	// END URL SEARCH

	 }elseif( ($params[0] == 'contact' || $params[0] == 'contact.php')){
 
	 	$error = 'false';
 
		if (!isset($params[1])) {
			  
					$output = '<div class="col-lg-12 content-contact"> 
								 <section class="col-lg-6 col-xl-6 col-md-12 col-xs-12  section-maps-contact" >
								 	<p  class="title-section-contact">Trouvez-nous facilement </p>
									<div class="contenu-maps"> 
								 	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13293.280836686881!2d-7.6414801!3d33.5969953!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x35af093e0ba2a66f!2sInstitute%20Hairdressing%20And%20Aesthetic%20Bourgogne!5e0!3m2!1sar!2sma!4v1639153572876!5m2!1sar!2sma" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
									</div>
								</section> 
								<section class="col-lg-6 col-xl-6 col-md-12 col-xs-12 section-form-contact">
									<p class="title-section-contact">Contactez-nous</p>
									<div class="grids-form hide">
										<span class="succes-span">
										<i class="fa fa-check" aria-hidden="true"></i> votre message a été envoyé avec succès.</span>
									</div>
									<div class="grids-form hide">
										<span class="incorrect-span">
										<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Erreur d\'envoyer ! Veuillez vérifier et réessayer.</span>
									</div> 
									 <div class="grids-form" style="z-index:6;">
					                    <i class="fa fa-user" aria-hidden="true"></i>
					                        <input type="text" class="important" id="nom" placeholder="Nom de famille..">
					                        <span class="required-slide">Champs obligatoires !</span>
					                  </div>
					                  <div class="grids-form" style="z-index:5;">
					                    <i class="fa fa-user" aria-hidden="true"></i>
					                        <input type="text" class="important" id="prenom" placeholder="Prénom..">
					                        <span class="required-slide">Champs obligatoires !</span>
					                  </div>
									<div class="grids-form" style="z-index:4;">
										<i class="fa fa-envelope" aria-hidden="true"></i>
												<input type="text" class="important" id="emailid" placeholder="Email..">
												<span class="required-slide">Champs obligatoires !</span>
									</div>
									<div class="grids-form" style="z-index:3;">
										<i class="fa fa-phone" aria-hidden="true"></i>
												<input type="text" class="important" maxlength="10" id="telephone" placeholder="Telephone EX:(0600123456)">
												<span class="required-slide">Champs obligatoires !</span>
									</div>
									<div class="grids-form" style="z-index:2;min-height: 180px;">
										<i class="fa fa-info-circle" aria-hidden="true"></i>
												<textarea id="Description" class="important"></textarea>
												<p class="placeolderDescription">Description..</p>
												<span class="required-slide" style="bottom: 14px;margin-top: 30px;">Champs obligatoires !</span>
									</div>
									<div class="grids-form">
										 <a id="NewContact" class="btn-save">
													<span><i class="fa fa-paper-plane" aria-hidden="true"></i> envoyer</span>
										 </a>
										 <a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
									</div>
								</section> 
							</div>';
   

		}else{

			$key_verification = $params[1];

			$length = strlen($key_verification);

			if ($length==32) {

				$key_verification = filter_var($key_verification , FILTER_SANITIZE_STRING);
				
				$query = "SELECT * FROM contacts WHERE key_verification='".$key_verification."' AND verification=0"; 
                $statement = $connect->prepare($query);
                $statement->execute(); 
                $count = $statement->rowCount();

                if ($count!=0) {
                	 
                	$contacts = $statement->fetchAll();

                	foreach ($contacts as $contact) {
                		$email = $contact['email'];
                		$entreprise = $contact['nom_entreprise'];
                		$responsable = $contact['nom_responsable'];
                		$telephone = $contact['phone'];
                		$message = $contact['description'];
                		$date = $contact['date_demande']; 
                	};

                	$current_time = date("d-m-Y H:i");


                	$query = "UPDATE contacts SET verification=1 , date_confirmation='".$current_time."' WHERE key_verification='".$key_verification."'"; 
	                $statement = $connect->prepare($query);

	                if ($statement->execute()) {

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
					$mail->Subject='PROXYMARKET nouveau contact de '.$email.' du '.$date;
					$mail->Body='<div class="content-letter" style="padding: 40px 10px;background: whitesmoke;">
										<img src="http://proxymarketmaroc.com/public/images/logo_header.png" style="height: 100px;width: auto;margin-bottom: 20px;">
										<b style="display: block;font-size: 14px; color: #424242;padding-bottom: 20px;padding-top: 10px;">Contact:</b>
										 <p style="font-size: 14px;">
										 	<span style="color: #646464;">Date : </span>
										 	<span style="color: black;">'.$date.'</span>
										 </p>
										 <p style="font-size: 14px;">
										 	<span style="color: #646464;">Nom d\'entreprise: </span>
										 	<span style="color: black;">'.$entreprise.'</span>
										 </p>
										 <p style="font-size: 14px;">
										 	<span style="color: #646464;">Nom du responsable: </span>
										 	<span style="color: black;">'.$responsable.'</span>
										 </p>
										 <p style="font-size: 14px;">
										 	<span style="color: #646464;">Adresse email : </span>
										 	<span style="color: black;">'.$email.'</span>
										 </p>
										 <p style="font-size: 14px;">
										 	<span style="color: #646464;">Telephone : </span>
										 	<span style="color: black;">'.$telephone.'</span>
										 </p>
										 <p style="font-size: 14px;">
										 	<span style="color: #646464;">Message : </span>
										 	<span style="color: black;">'.$message.'</span>
										 </p>
									</div>';
					$mail->AltBody='';
 					$mail->send();
	                	 
	                  $error = 'false';
                	  $output = '<p style="margin: 0;">
								<span style="font-variant:all-petite-caps;font-size:14px;font-family: proxyfont;color: #424242;"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 15px;"></i>  votre message a bien été envoyé. Notre équipe vous répondre le plutôt possible.</span>
								<p>
								<span style="font-variant:all-petite-caps;font-size:12px;color:#424242;font-family: proxyfontbold;">pour toute question ou information complémentaire merci de contacter notre support client.</span>
								<a style="font-variant:all-petite-caps;font-size:13px;color:#72c169;cursor: pointer;font-family: proxyfontbold;" class="proxy-link" data-link="index">retour à la page accueil</a>
								</p>';

		                }else{

			                $error = 'false';
		                	$output = '<p style="margin: 0;">
								<span style="font-variant:all-petite-caps;font-size:14px;font-family: proxyfont;color: #424242;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Erreur de verification. Veuillez réessayer plus tard.</span>
								<p>
								<span style="font-variant:all-petite-caps;font-size:12px;color:#424242;font-family: proxyfontbold;">pour toute question ou information complémentaire merci de contacter notre support client.</span>
								<a style="font-variant:all-petite-caps;font-size:13px;color:#72c169;cursor: pointer;font-family: proxyfontbold;" class="proxy-link" data-link="index">retour à la page accueil</a>
								</p>';

		                }
 

                }else{

                	$error = 'false';
                	$output = '<div class="col-lg-12 content-contact"> 
								 <section class="col-lg-6 col-xl-6 col-md-12 col-xs-12  section-maps-contact" >
								 	<p  class="title-section-contact">Trouvez-nous facilement </p>
									<div class="contenu-maps">
								 	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13297.542754049831!2d-7.6466198!3d33.5693339!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x36df923caf976453!2sProxy%20Market!5e0!3m2!1sfr!2sma!4v1577803868861!5m2!1sfr!2sma"  allowfullscreen="" width="100%" height="400" frameborder="0"></iframe>
									</div>
								</section> 
								<section class="col-lg-6 col-xl-6 col-md-12 col-xs-12 section-form-contact">
									<p class="title-section-contact">Contactez-nous</p>
									<div class="grids-form hide">
										<span class="succes-span">
										<i class="fa fa-check" aria-hidden="true"></i> votre message a été envoyé avec succès.</span>
									</div>
									<div class="grids-form hide">
										<span class="incorrect-span">
										<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Erreur d\'envoyer ! Veuillez vérifier et réessayer.</span>
									</div> 
									<div class="grids-form" style="z-index:6;">
										<i class="fa fa-briefcase" aria-hidden="true"></i>
												<input type="text" id="entreprise" placeholder="Nom du l\'entreprise..">
												<span class="required-slide">Champs obligatoires !</span>
									</div>
									<div class="grids-form" style="z-index:5;">
										<i class="fa fa-user" aria-hidden="true"></i>
												<input type="text" class="important" id="nomresponsable" placeholder="Nom du responsable..">
												<span class="required-slide">Champs obligatoires !</span>
									</div>
									<div class="grids-form" style="z-index:4;">
										<i class="fa fa-envelope" aria-hidden="true"></i>
												<input type="text" class="important" id="emailid" placeholder="Email..">
												<span class="required-slide">Champs obligatoires !</span>
									</div>
									<div class="grids-form" style="z-index:3;">
										<i class="fa fa-phone" aria-hidden="true"></i>
												<input type="text" class="important" maxlength="10" id="telephone" placeholder="Telephone EX:(0600123456)">
												<span class="required-slide">Champs obligatoires !</span>
									</div>
									<div class="grids-form" style="z-index:2;min-height: 180px;">
										<i class="fa fa-info-circle" aria-hidden="true"></i>
												<textarea id="Description" class="important"></textarea>
												<p class="placeolderDescription">Description..</p>
												<span class="required-slide" style="bottom: 14px;margin-top: 30px;">Champs obligatoires !</span>
									</div>
									<div class="grids-form">
										 <a id="NewContact" class="btn-save">
													<span><i class="fa fa-paper-plane" aria-hidden="true"></i> envoyer</span>
										 </a>
										 <a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
									</div>
								</section> 
							</div>';

                }
				  
			}else{
				
				$error = 'true';
				$output = '<div class="content-error-404">
				  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
				  <a class="proxy-link" data-link="index">retour à accueil page</a>
				</div>';

			}

		}

		 
		 
 

	 	// END URL PARAMS CONTACT
	 }elseif( ($params[0] == 'index' || $params[0] == 'index.php' || $params[0] == '')){
 
		 	$error = 'false';
			$output = '<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 content-section-categorie" style="background-image: url(./public/files/makeup.jpg);"> 
            <div class="section-infos" >
             <span class="bg-shadow bg-move-left"></span>
             <span class="title-info-image content-move-left">inscription 2022 ouvert</br>réservez votre place dès maintenant</span>
              <div class="grid-action-image content-move-left">
              <a  class="btn-savoir-plus proxy-link" data-link="signup" >réserver un rendez-vous</a>
              <a class="more-info-image proxy-link" data-link="formations"> Découvrir tous nos formations..</a> 
              </div>
            </div>
           </div>
 

           <section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-formations">
             <span class="title-formations-all">Nos formations diplômantes</span>
             <span class="description-formations-all">Forte d’une expérience dans la formation de plus de 15 ans en France, l’ISFEC est l’école des métiers de l’Esthétique et de la Coiffure
                L’ISFEC a conçu pour vous des formations en esthétique et en coiffure très performantes afin de vous permettre de devenir les meilleur(e)s professionnel(le)s de demain.</span>
              
              <div class="grids-formations-all">
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 grid-formation">
                  <div class="box-formation wallpaper-coiffure proxy-link" data-link="formations" >
                   <div class="action-formation">
                      <span class="icon-formation icon-coiffure"></span>
                     <span class="titre-formation">Coiffure Visagiste</span>
                   </div>
                  </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 grid-formation">
                  <div class="box-formation wallpaper-esthetique proxy-link" data-link="formations" style="border-radius: 0 50px 0 0;">
                   <div class="action-formation">
                      <span class="icon-formation icon-esthetique"></span>
                     <span class="titre-formation">Makeup Professionnel</span>
                   </div>
                  </div>
                </div>

              </div>

           </section>

  

           <section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-presentation-school" style="margin-top:40px;">
              <div class="box-wallpaper-school"></div>
              <div class="box-action-school">
                <span>Riche de 31 ans d’expérience.
                                  Ecole et CFA (certifié Qualité Qualiopi)
                                  Déclaration d’activité auprès de la Préfecture.
                                  Reconnue pour son excellence et son expertise : Titre de Meilleur Ouvrier de France : Virginie Cabaret, directrice  – Titre de Meilleur Apprenti de France Esthétique – Titre du meilleur Apprenti de France Coiffure
                                  En cas de situation de handicap, contacter nous pour l’étude de cette possibilité.
                                  Un bâtiment clair et spacieux de 1250 m2.
                                  Un grand parking et un espace boisé.
                                  2 cafétérias, vestiaire, salle de sport …</span>
              </div>
           </section>



          <section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-badge-confiance" style="margin-top:100px;margin-bottom:60px;">
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-diplome.svg);"></span>
               <span class="title-badge" >Diplôme d’État</span>
             </div>
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-eleves.svg);background-size: 80%;"></span>
               <span class="title-badge" >Élèves tous publics</span>
             </div> 
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-quality.svg);"></span>
               <span class="title-badge" >Excellent taux de réussite</span>
             </div>  
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-rigor.svg);background-size: 80%;"></span>
               <span class="title-badge" >Rigueur</span>
             </div>   
           </section>


           <section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-digitals">
             <span class="title-digitals-all">Actualités</span>
             <!-- <span class="description-digitals-all">Connectez-vous avec nous sur les réseaux sociaux : </span> -->
              
              <div class="grids-digitals-all">
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="grid-digital-video" >
                    <iframe src="https://www.youtube-nocookie.com/embed/uMsKe_gX8tc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  </div>

                  <div class="grid-view-pictures">
                    
                  </div>

                </div> 

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="grid-digital-photos">
                    <ul>
                      <li>
                        <span class="proxy-link" data-link="evenements">Voir plus</span>
                      </li>
                      <li style="background: url(./public/files/wallpaper-coiffure.jpg);" >
                        <span class="proxy-link" data-link="evenements">Voir plus</span>
                      </li>
                      <li style="background: url(./public/files/wallpaper-makeup.jpg);" >
                        <span class="proxy-link" data-link="evenements">Voir plus</span>
                      </li>
                      <li style="background: url(./public/files/wallpaper-microblading.jpg);" >
                        <span class="proxy-link" data-link="evenements">Voir plus</span>
                      </li>
                    </ul>
                  </div>
                </div>

              </div>

           </section>

           <section class="view-full-screen hide">
             <a class="close-picture-view"><span>Retour X</span></a>
             <span class="picture-view"></span>
           </section>';
     
	 	// END URL PARAMS INDEX
	 }elseif( ($params[0] == 'formations' || $params[0] == 'formations.php')){
 
		 	$error = 'false';
			$output = '<section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-formations-views">
          <ul class="ul-formation-view">

            <li> 
              <div class="container-formation-view">
                  <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12"> 
                  <div class="content-formation-view wallpaper-formation-coiffure">
                    <div class="action-formation-view">
                      <i class="icon-formation-view icon-formation-coiffure"></i>
                       <span class="title-formation-view">Coiffure Visagiste</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                  <span class="extension-formation-view">
                    La période d\'inscription à la formation complète d\'esthéticienne professionnelle est ouverte de Juin à Décembre. Les inscriptions aux spécialités sont disponibles toute l\'année. Vous pouvez vous inscrire en visitant notre école sur la ville d\'agrandir au Maroc ou en nous appelant au +212 5 28 84 67 65.
                  </span>
                </div>
              </div>
            </li>

            <li> 
              <div class="container-formation-view">
                  <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12"> 
                      <div class="content-formation-view wallpaper-formation-esthetique">
                        <div class="action-formation-view">
                          <i class="icon-formation-view icon-formation-esthetique"></i>
                           <span class="title-formation-view">Esthéticienne Cosméticienne</span>
                        </div>
                      </div> 
                  </div>
                  <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                      <span class="extension-formation-view">
                        La période d\'inscription à la formation complète d\'esthéticienne professionnelle est ouverte de Juin à Décembre. Les inscriptions aux spécialités sont disponibles toute l\'année. Vous pouvez vous inscrire en visitant notre école sur la ville d\'agrandir au Maroc ou en nous appelant au +212 5 28 84 67 65.
                      </span>
                    </div> 
            </li>

            <li> 
              <div class="container-formation-view">
                  <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12"> 
                  <div class="content-formation-view wallpaper-formation-microblading">
                    <div class="action-formation-view">
                      <i class="icon-formation-view icon-formation-microblading"></i>
                       <span class="title-formation-view">Microblading</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                  <span class="extension-formation-view">
                    La période d\'inscription à la formation complète d\'esthéticienne professionnelle est ouverte de Juin à Décembre. Les inscriptions aux spécialités sont disponibles toute l\'année. Vous pouvez vous inscrire en visitant notre école sur la ville d\'agrandir au Maroc ou en nous appelant au +212 5 28 84 67 65.
                  </span>
                </div>
              </div>
            </li>

            <li> 
              <div class="container-formation-view">
                 <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12"> 
                  <div class="content-formation-view wallpaper-formation-ongulaire">
                    <div class="action-formation-view">
                      <i class="icon-formation-view icon-formation-ongulaire"></i>
                       <span class="title-formation-view">Prothèsie Ongulaire</span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                  <span class="extension-formation-view">
                    La période d\'inscription à la formation complète d\'esthéticienne professionnelle est ouverte de Juin à Décembre. Les inscriptions aux spécialités sont disponibles toute l\'année. Vous pouvez vous inscrire en visitant notre école sur la ville d\'agrandir au Maroc ou en nous appelant au +212 5 28 84 67 65.
                  </span>
                </div>  
              </div>
            </li>

             <li> 
              <div class="container-formation-view">
                 <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12"> 
                  <div class="content-formation-view wallpaper-formation-makeup">
                    <div class="action-formation-view">
                      <i class="icon-formation-view icon-formation-makeup"></i>
                       <span class="title-formation-view">Makeup Professionnel</span>
                    </div>
                  </div>
                </div> 
                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
                  <span class="extension-formation-view">
                    La période d\'inscription à la formation complète d\'esthéticienne professionnelle est ouverte de Juin à Décembre. Les inscriptions aux spécialités sont disponibles toute l\'année. Vous pouvez vous inscrire en visitant notre école sur la ville d\'agrandir au Maroc ou en nous appelant au +212 5 28 84 67 65.
                  </span>
                </div> 
              </div>
            </li>
  
          </ul>
        </section>




         <section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-badge-confiance" style="margin-top:40px;margin-bottom:0px;">
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-diplome.svg);"></span>
               <span class="title-badge" >Diplôme d’État</span>
             </div>
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-eleves.svg);background-size: 80%;"></span>
               <span class="title-badge" >Élèves tous publics</span>
             </div> 
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-quality.svg);"></span>
               <span class="title-badge" >Excellent taux de réussite</span>
             </div>  
             <div class="col-lg-3 col-xl-3 col-md-3 col-sm-6 col-xs-6 grid-badge">
              <span class="icon-badge" style="background-image: url(./public/files/icon-rigor.svg);background-size: 80%;"></span>
               <span class="title-badge" >Rigueur</span>
             </div>   
           </section>';
     
	 	// END URL PARAMS formations
	 }elseif( ($params[0] == 'evenements' || $params[0] == 'evenements.php')){
 
		 	$error = 'false';
			$output = '<section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-galerie-events">
          <span class="time-galerie-events">2021-11-07</span>
          <span class="title-galerie-events">Ouverture d\'inscription 2021-2022</span>
          <span class="descr-galerie-events">Nous avons à cœur de former avec passion et rigueur les élèves de notre école privée de coiffure et d’esthétique. </span>
          
          <ul class="ul-galerie-events">
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
            <li class="li-galerie-events">
              <span class="ico-galerie-events"></span>
            </li>
          </ul>
        </section>

         <section class="view-full-screen hide">
             <a class="close-picture-view"><span>Retour X</span></a>
             <span class="picture-view"></span>
           </section>';
     
	 	// END URL PARAMS evenements
	 }elseif( ($params[0] == 'signup' || $params[0] == 'signup.php')){
 
		 	$error = 'false';
			$output = '<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 section-rendez-vous" >
          
           <span class="title-rendez-vous-all">Prenez rendez-vous.</span>
           <span class="description-rendez-vous-all"><b>L\'ECEB</b> se mobilise pour répondre à toutes vos questions par téléphone, visio-conférence ou bien sur place à l’école.</span>

        <div class="content-form-rendez-vous">
          <span class="icon-form"></span>
          <span class="title-form">Rendez-vous</span>

          <section class="col-lg-6 col-xl-6 col-md-6 col-xs-12 section-detail-rendez-vous">
            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12 grid-rendezvous-detail">
              <span class="title-detail-rendez-vous">Interlocuteur:</span>
              <span class="valeur-detail-rendez-vous"><i class="fa fa-user-circle" aria-hidden="true"></i> Direction de l\'ECEB </span>
            </div> 
            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12 grid-rendezvous-detail">
              <span class="title-detail-rendez-vous">Rendez-vous:</span>
              <span class="valeur-detail-rendez-vous">17 décembre 2021 </span>
              <span class="title-detail-rendez-vous">Heure locale:</span>
              <span class="valeur-detail-rendez-vous">14:30 </span>
            </div>  
            <div class="col-lg-12 col-xl-12 col-md-12 col-xs-12 section-select-formation">
               <span class="title-formation-selected">Formation souhaité:</span>
               <!--  <span class="valeur-formation-selected"><i class="fa fa-chain-broken" aria-hidden="true"></i> Coiffure Visagiste testetstets</span>  -->
                <ul class="ul-choose-formation">
                  <li class="li-choose-formation">
                    <span class="span-choose-formation"  ><i class="fa fa-chain-broken" aria-hidden="true"></i> Coiffure Visagiste  <span class="btn-savoir-plus proxy-link" data-link="formations">en savoir plus</span></span>
                    <span class="icon-formation-selected" style="background-image: url(./public/files/wallpaper-coiffure.jpg)"></span> 
                  </li>
                  <li class="li-choose-formation">
                    <span class="span-choose-formation" ><i class="fa fa-chain-broken" aria-hidden="true"></i> Esthéticienne Cosméticienne <span class="btn-savoir-plus proxy-link" data-link="formations">en savoir plus</span></span>
                    <span class="icon-formation-selected" style="background-image: url(./public/files/wallpaper-esthetique.jpg)"></span> 
                  </li>
                  <li class="li-choose-formation">
                    <span class="span-choose-formation"  ><i class="fa fa-chain-broken" aria-hidden="true"></i> Makeup Professionnel <span class="btn-savoir-plus proxy-link" data-link="formations">en savoir plus</span></span>
                    <span class="icon-formation-selected" style="background-image: url(./public/files/wallpaper-makeup.jpg)"></span> 
                  </li>
                  <li class="li-choose-formation">
                    <span class="span-choose-formation"  ><i class="fa fa-chain-broken" aria-hidden="true"></i> Microblanding <span class="btn-savoir-plus proxy-link" data-link="formations">en savoir plus</span></span>
                    <span class="icon-formation-selected" style="background-image: url(./public/files/wallpaper-microblading.jpg)"></span> 
                  </li>
                  <li class="li-choose-formation">
                    <span class="span-choose-formation"  ><i class="fa fa-chain-broken" aria-hidden="true"></i> Prothèsie Ongulaire <span class="btn-savoir-plus proxy-link" data-link="formations">en savoir plus</span></span>
                    <span class="icon-formation-selected" style="background-image: url(./public/files/wallpaper-ongulaire.jpg)"></span> 
                  </li>
                </ul>
            </div>
           
          </section>

          <section class="col-lg-6 col-xl-6 col-md-6 col-xs-12 section-form-detail">
                  <!-- <span class="title-section-contact">Contactez-nous</span> -->
                  <div class="grids-form hide">
                    <span class="succes-span">
                    <i class="fa fa-check" aria-hidden="true"></i> votre message a été envoyé avec succès.</span>
                  </div>
                  <div class="grids-form hide">
                    <span class="incorrect-span">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Erreur d\'envoyer ! Veuillez vérifier et réessayer.</span>
                  </div> 
                  <div class="grids-form" style="z-index:6;">
                    <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" class="important" id="nom" placeholder="Nom de famille..">
                        <span class="required-slide">Champs obligatoires !</span>
                  </div>
                  <div class="grids-form" style="z-index:5;">
                    <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" class="important" id="prenom" placeholder="Prénom..">
                        <span class="required-slide">Champs obligatoires !</span>
                  </div>
                  <div class="grids-form" style="z-index:4;">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                        <input type="text" class="important" id="emailid" placeholder="Email..">
                        <span class="required-slide">Champs obligatoires !</span>
                  </div>
                  <div class="grids-form" style="z-index:3;">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                        <input type="text" class="important" maxlength="10" id="telephone" placeholder="Telephone EX:(0600123456)">
                        <span class="required-slide">Champs obligatoires !</span>
                  </div>
                  <div class="grids-form" style="z-index:2;min-height: 180px;">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <textarea id="Description" class="important"></textarea>
                        <p class="placeolderDescription">Description..</p>
                        <span class="required-slide" style="bottom: 14px;margin-top: 30px;">Champs obligatoires !</span>
                  </div> 
            </section> 
            <section class="col-lg-12 col-xl-12 col-md-12 col-xs-12 section-form-detail">
              <div class="grids-form">
                     <a id="NewContact" class="btn-save">
                          <span><i class="fa fa-check" aria-hidden="true"></i> Confirmer</span>
                     </a>
                     <a class="btn-spin hide"><i class="fa fa-spinner" aria-hidden="true"></i></a>
                  </div>
            </section>

        </div>

      </div>';
     
	 	// END URL PARAMS evenements
	 }elseif( ($params[0] == 'entreprise' || $params[0] == 'entreprise.php')){
 
		 	$error = 'false';
			$output = '<section class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12">
							<div style="background-image: url(./public/files/vehicule.png);" class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 bg-image"></div>

							<span class="title-entreprise"  >Emballage fast food</span>
							<span class="parag-entreprise"  >Découvrez notre gamme d\'accessoires et d\'emballages adaptées à la restauration rapide - fast food. Vous trouverez tout ce dont vous avez besoin pour faire déguster et habiller les plus savoureuses préparations !
							Proxy propose des emballages pour le snacking à tarifs réduits et cela sans perte de qualité!
							Retrouvez notre gamme de gobelets, de barquettes et sacs de qualité qui garantiront une parfaite dégustation à vos clients ! pots carton wraps, couverts, barquettes salade, sacs à sandwich, carrés rainés, agitateurs, il y en a pour divers usages et pour des préparations de type snacking ou vente à emporter.</span>

							<span class="title-entreprise"  >Emballage restauration rapide</span>
							<span class="parag-entreprise"  >Devant la croissance du marché de la restauration rapide qui a pour but de faire gagner du temps au client nous devons en tant que fournisseur d\'emballages alimentaires vous proposer la meilleure offre d\'emballages pour le snacking. Nous nous adaptons à la demande et aux évolutions du marché, en été nous proposons un emballage qui fera le bonheur des vendeurs,barquette salade avec pot à sauce, ma touiallette café, le triangle rainée pour part à pizza, le sac poulet et pleins d\'autres produits.</span>

							</section>';
     
	 	// END URL PARAMS entreprise
	 }else{
		$error = 'true';
		$output = '<div class="content-error-404">
		  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
		  <a class="proxy-link" data-link="index">retour à accueil page</a>
		</div>';
	 };

 	// END ACTION

	}else{
		$error = 'true';
		$output = '<div class="content-error-404">
		  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
		  <a class="proxy-link" data-link="index">retour à accueil page</a>
		</div>';
	}

}else{
		$error = 'true';
		$output = '<div class="content-error-404">
		  <span><i class="fa fa-meh-o" aria-hidden="true"></i> Oops! Aucun répertoire ne correspond à votre requête.</span>
		  <a class="proxy-link" data-link="index">retour à accueil page</a>
		</div>';
}
 
$output = array(
		'error' => $error,
		'output' => $output
	);

echo json_encode($output);



 ?>