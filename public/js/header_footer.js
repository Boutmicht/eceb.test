 $(document).ready(function () {
     




 // GLOBAL VAR 
 
 var currentLocationFolder =document.URL.split('/').slice(0, -1).join('/');
 var currentLocation = '{"params":"'+window.location+'"}';
 var params = currentLocation.replace(currentLocationFolder+'/', '');

 var loadingContenu = function(params) {

  window.history.pushState("", "", currentLocationFolder+'/'+params);
  action = 'load';

  $.ajax({
        url: './app/index.php',
        type: 'GET',
        data: {
          action: action,
          params_new: params
        },
        error: function() {
          alert('error');
        },
        beforeSend:function() {  
        },
        success: function(data)
        {  
          // alert(data);
          // return false;
              var data = $.parseJSON(data);
              $('.content-posting').html(data.output);
              window.scrollTo(0, 0); 
        } 
      });

  return false;
}

var loadAuto = function() {

  params = $.parseJSON(params);
  params = params.params; 
  params = params.replace(/%20/g, ' ');

  loadingContenu(params);
  return false;

}

if (params!="") {
  loadAuto(); 
};

 
$(document).on('click','.proxy-link',function (event) {
  if (!$(this).parent().hasClass('dropdown')) {
    $('.proxy-link').parent().removeClass('active');
    $('.proxy-link').parent().parent().parent().removeClass('active');
   $(this).parent().addClass('active');
  }else{
    $('.proxy-link').parent().removeClass('active');
   $(this).parent().parent().parent().addClass('active');
  }
  
  params = $(this).data('link');
  loadingContenu(params);
  return false;

})

 

 
$(document).on('click','.span-choose-formation',function (event) {

$('.span-choose-formation').removeClass('formation-chosed');
$(this).addClass('formation-chosed');

})

$(document).on('click','.close-picture-view',function (event) {

$(this).parent().addClass('hide');

})


$(document).on('click','.ico-galerie-events',function (event) {

 var url = $(this).css("background-image"); 
 $('.picture-view').css("background", url);
 $('.picture-view').parent().removeClass('hide');
 
})

 







$(document).on('click','.grid-digital-photos li',function (event) {


 var url = $(this).css("background-image"); 
 $('.picture-view').css("background", url);
 $('.picture-view').parent().removeClass('hide');
 

})



 $('.dropdown-proxy-produits, .dropdown-liste-types').on('click', function() {
 	 //  $(this).parent().toggleClass('open');
 	 // return false;
 })


 $('.icon-cart-proxy').on('click', function() {
    $(this).parent().toggleClass('open'); 
    return false;
 })

// $('.content-posting').on('click', function() {
//     $('.icon-cart-proxy').parent().removeClass('open'); 
//  })
 

$(document).click(function(event) {
    if ( !$(event.target).hasClass('dropdowned')) {
         $(".dropdown-nos-produits").parent().removeClass('open');
    }; 
});

$(document).on('click','input[type=radio]',function (event) {

 $('#typeCommande').val($(this).val())

})

 


$(document).on('click keyup keydown','input[type=text]',function (event) {
  $(this).removeClass('required-input'); 
  $(this).parent().find('span').removeClass('required-span'); 
  $(this).parent().find('i').removeClass('required-i');  
})

$(document).on('click keyup keydown','textarea',function (event) {
  $(this).removeClass('required-input'); 
  $(this).parent().find('span').removeClass('required-span'); 
  $(this).parent().find('i').removeClass('required-i');  
})

$(document).on('click keyup keydown','.search-header',function (event) {
   $(this).css({'color':'#3e3e3e','border-bottom':'2px solid #72c169'});
})

$(document).on('click keyup keydown','.placeolderDescription, #Description',function (event) {
   $('.placeolderDescription').addClass('hide');
})

$(document).on('click keyup keydown','input[type=text]',function (event) {
   if ($('.placeolderDescription').val()=='') {
    $('.placeolderDescription').removeClass('hide');
   }
})



$(document).on('click','.btn-search-header',function (event) {

var recherche = $(this).parent().find('.search-header'); 
var recherche_val = recherche.val(); 

var action = 'search'; 

 if (recherche_val=='') { 
    recherche.css({'color':'#ff9e9e','border-bottom':'2px solid #ff9e9e'});
  }else{
    
    loadingContenu(action+'?'+recherche_val);
     return false;

  }



})


$(document).on('click','.btn-search-footer',function (event) {

  var recherche   = $('#IDrechercheFooter').val(); 
 
  var action = 'search'; 

  if (recherche=='') { 
    $('#IDrechercheFooter').addClass('required-input'); 
    $('#IDrechercheFooter').parent().find('span').addClass('required-span'); 
    $('#IDrechercheFooter').parent().find('i').addClass('required-i'); 
  }else{
  
    loadingContenu(action+'?'+recherche);
     return false;
 
  }

})

 
$(document).on('click','#btnPlusQte',function (event) {
  qte = $('#QteProduct').val();
  qte = parseInt(qte)
  $('#QteProduct').val(qte+1);
})

$(document).on('click','#btnMoinQte',function (event) {
  qte = $('#QteProduct').val();
  qte = parseInt(qte);
  minQte = $('#minQte').val();
  minQte = parseInt(minQte);
  if (minQte<qte) {
    $('#QteProduct').val(qte-1);
  }else{
    return false;
  }
  
})

$(document).on('click','.btn-moin-product',function (event) {
qte = $(this).parent().find('.qte-product').val();
qte = parseInt(qte);
min_qte = $(this).parent().find('.min-qte').val();
min_qte = parseInt(min_qte);
  if (min_qte<qte) {
    $(this).parent().find('.qte-product').val(qte-1);
  }else{
    return false;
  }
})

$(document).on('click','.btn-plus-product',function (event) {
qte = $(this).parent().find('.qte-product').val();
qte = parseInt(qte);
min_qte = $(this).parent().find('.min-qte').val();
min_qte = parseInt(min_qte);

  $(this).parent().find('.qte-product').val(qte+1);

})
 

 
 


$(document).on('click','.select-size',function (event) {

  id = $(this).data('reference');
  min = $(this).data('package'); 
  $('#minQte').val(min);
  $('#QteProduct').val(min);

  $('.select-size').removeClass('size-selected');
  $(this).addClass('size-selected');

  $('#IDrefDetailSelected').val(id);

})




$(document).on('click','#btnAddCart',function (event) {

  action = 'add_cart';
  product_ref = $('#IDreference').val();
  ref_details = $('#IDrefDetailSelected').val();
  qte         = $('#QteProduct').val();
  min         = $('#minQte').val();

  if (!$(this).hasClass('active')) {

      if (product_ref!=''&&ref_details!=''&&qte!=''&&min!='') {
  
      $.ajax({
        url: './app/produits.php',
        type: 'POST',
        context: this,
        data: {
          action: action,
          reference: product_ref,
          ref_details: ref_details,
          qte: qte,
          qte_min: min
        },
        error: function() {
          alert('error! function. Veuillez contactez le developpeur.');
        },
        beforeSend:function() {
          $(this).addClass('active');
        },
        success: function(data)
        { 

            var data = $.parseJSON(data); 

            $(this).removeClass('active');

              if (data.error == 'false'){

                  $('.notif-succees-panier').html('<i class="fa fa-check-circle-o" aria-hidden="true"></i> Le produit a été ajouté à votre panier.');
                  $('.notif-succees-panier').removeClass('hide');
                  $('.dropdown-cart-proxy').html(data.output);

                  setTimeout(function () {
                     $('.notif-succees-panier').addClass('hide');
                  },1500)

              }else{

                $('.notif-succees-panier').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '+data.output);
                $('.notif-succees-panier').removeClass('hide');

                setTimeout(function () {
                     $('.notif-succees-panier').addClass('hide');
                },2500)

              }
  
         } 

        });

    }

  }


})


$(document).on('click','.btn-delete-items-cart-proxy',function (event) {

  action = 'delete_item';
  product_ref = $(this).data('reference');
  ref_details = $(this).data('referencedetails'); 
  
  if (product_ref!==undefined&&ref_details!==undefined) {

      $.ajax({
        url: './app/produits.php',
        type: 'POST',
        data: {
          action: action,
          reference: product_ref,
          ref_details: ref_details
        },
        error: function() {
          alert('error! function. Veuillez contactez le developpeur.');
        },
        beforeSend:function() {
         
        },
        success: function(data)
        { 
            
           
            
              var data = $.parseJSON(data); 
               
              if (data.error == 'false'){
  
                  $('.dropdown-cart-proxy').html(data.output);

              }else{

                alert(data.output);

              }
 

        } 
      });

  }


})

$(document).on('click','.btn-delete-item',function (event) {

  action = 'delete_item_commandes';
  product_ref = $(this).data('reference');
  ref_details = $(this).data('referencedetails'); 
  
  if (product_ref!==undefined&&ref_details!==undefined) {

      $.ajax({
        url: './app/produits.php',
        type: 'POST',
        context: this,
        data: {
          action: action,
          reference: product_ref,
          ref_details: ref_details
        },
        error: function() {
          alert('error! function. Veuillez contactez le developpeur.');
        },
        beforeSend:function() {
         
        },
        success: function(data)
        { 
            
           // alert(data)
           // return false;
            
              var data = $.parseJSON(data); 
               
              if (data.error == 'false'){
                  
                  $('.dropdown-cart-proxy').html(data.output);
                  $(this).parent().parent().remove();

              }else{

                alert(data.output);

              }
 

        } 
      });

  }


})





$(document).on('click','#NewCommandes',function (event) {

  action = 'new_commandes';
  type_demmande = $('#typeCommande').val();
  entreprise = $('#entreprise').val();
  responsable = $('#nomresponsable').val();
  email = $('#emailid').val();
  telephone = $('#telephone').val();
  description = $('#Description').val();
  
  if (responsable==''&&email==''&&telephone=='') {
    $('input.important').parent().find('input').addClass('required-input'); 
    $('input.important').parent().find('span').addClass('required-span'); 
    $('input.important').parent().find('i').addClass('required-i'); 
  }

  else if (responsable=='') {
   $('#nomresponsable').parent().find('input').addClass('required-input'); 
    $('#nomresponsable').parent().find('span').addClass('required-span'); 
    $('#nomresponsable').parent().find('i').addClass('required-i'); 
  }else if (email=='') { 
    $('#emailid').parent().find('input').addClass('required-input'); 
    $('#emailid').parent().find('span').addClass('required-span'); 
    $('#emailid').parent().find('i').addClass('required-i'); 
  }else if (telephone==''||telephone.length!=10||isNaN(parseFloat(telephone)) ) { 
    $('#telephone').parent().find('input').addClass('required-input'); 
    $('#telephone').parent().find('span').addClass('required-span'); 
    $('#telephone').parent().find('i').addClass('required-i'); 
  }else{
    
      $.ajax({
        url: './app/produits.php',
        type: 'POST',
        context: this,
        data: {
          action: action,
          type_demmande:type_demmande,
          entreprise: entreprise,
          responsable: responsable,
          email:email,
          telephone:telephone,
          description:description
        },
        error: function() {
          alert('error! function. Veuillez contactez le developpeur.');
        },
        beforeSend:function() {
         $('.btn-spin').removeClass('hide');
        },
        success: function(data)
        { 
            
           // alert(data)
           // return false;
            
              var data = $.parseJSON(data); 
               
              if (data.error == 'false'){
                  
                  
                  setTimeout(function () {
                     $('.content-table-commandes').html(data.output);
                     $('.dropdown-cart-proxy').html(' <li><span class="title-cart-proxy">liste des produits demandé</span></li><li class="divider"></li><li class="dropdown-cart-infos-items"><span style="padding: 10px 30px 10px 10px;text-align: left;display: block;position: relative;color: #424242;font-size: 12px;">Aucun article ajouté.</span></li>')
                     $('.btn-spin').addClass('hide');
                  },2000)

              }else{
                  
                  setTimeout(function () {
                    $('.incorrect-span').html(data.output);
                    $('.btn-spin').addClass('hide');
                    $('.incorrect-span').parent().removeClass('hide');
                    setTimeout(function () {
                      $('.incorrect-span').parent().addClass('hide');
                    },2000)
                  },2000)
                
              }
 

        } 
      });

  }


})



$(document).on('click','#NewContact',function (event) {

  action = 'new_contact'; 
  nom = $('#nom').val();
  prenom = $('#prenom').val();
  email = $('#emailid').val();
  telephone = $('#telephone').val();
  description = $('#Description').val();
  
  if (nom==''&&prenom==''&&email==''&&telephone==''&&description=='') {
    $('.important').parent().find('.important').addClass('required-input'); 
    $('.important').parent().find('span').addClass('required-span'); 
    $('.important').parent().find('i').addClass('required-i'); 
  }

  else if (nom=='') {
   $('#nom').parent().find('input').addClass('required-input'); 
    $('#nom').parent().find('span').addClass('required-span'); 
    $('#nom').parent().find('i').addClass('required-i'); 
  }else if (prenom=='') {
   $('#prenom').parent().find('input').addClass('required-input'); 
    $('#prenom').parent().find('span').addClass('required-span'); 
    $('#prenom').parent().find('i').addClass('required-i'); 
  }else if (email=='') { 
    $('#emailid').parent().find('input').addClass('required-input'); 
    $('#emailid').parent().find('span').addClass('required-span'); 
    $('#emailid').parent().find('i').addClass('required-i'); 
  }else if (telephone==''||telephone.length!=10||isNaN(parseFloat(telephone)) ) { 
    $('#telephone').parent().find('input').addClass('required-input'); 
    $('#telephone').parent().find('span').addClass('required-span'); 
    $('#telephone').parent().find('i').addClass('required-i'); 
  }else if (description=='') { 
     $('#Description').addClass('required-input'); 
    $('#Description').parent().find('span').addClass('required-span'); 
    $('#Description').parent().find('i').addClass('required-i'); 
  }else{
    
      $.ajax({
        url: './app/produits.php',
        type: 'POST',
        context: this,
        data: {
          action: action,
          entreprise: entreprise,
          responsable: responsable,
          email:email,
          telephone:telephone,
          description:description
        },
        error: function() {
          alert('error! function. Veuillez contactez le developpeur.');
        },
        beforeSend:function() {
         $('.btn-spin').removeClass('hide');
        },
        success: function(data)
        { 

              var data = $.parseJSON(data); 
               
              if (data.error == 'false'){
                   
                  setTimeout(function () {
                     $('.section-form-contact').html(data.output); 
                  },2000)

              }else{
                  
                  setTimeout(function () {
                    $('.incorrect-span').html(data.output);
                    $('.btn-spin').addClass('hide');
                    $('.incorrect-span').parent().removeClass('hide');
                    setTimeout(function () {
                      $('.incorrect-span').parent().addClass('hide');
                    },2000)
                  },2000)
                
              }
 

        } 
      });

  }


})












// END SCRIPT
}); 



 


 


 


 


 


 


 


 


 


 


 


