 $(document).ready(function () {

 

$(document).on('click','.bars-icons ul li a',function (event) {
 
$('.bars-icons-details').toggleClass('barsOn');

})

$(document).on('click','.container-content',function (event) {
 
if ($('.bars-icons-details').hasClass('barsOn')) {
  $('.bars-icons-details').removeClass('barsOn');
} 

})



// GLOBAL VAR 
 
 var currentLocationFolder =document.URL.split('/').slice(0, -1).join('/');
 var currentLocation = '{"params":"'+window.location+'"}';
 var params = currentLocation.replace(currentLocationFolder+'/', '');
 // window.history.pushState("object or string", "Title", "/new-url");





$(document).on('click','.switch',function (event) {

  if ($(this).hasClass('switch-categories')) {
     
    var action = 'switch_categories';
    var id = $(this).data("category"); 

     $.ajax({
          url: '../app/run.php',
          type: 'POST',
          context: this,
          data: {
            action: action,
            id: id
          },
          error: function() {
            alert('error');
          },
          beforeSend:function() {  
          },
          success: function(data)
          {   
                var data = $.parseJSON(data);
                if (data.error=='false') {
                  $(this).toggleClass("switchOn");
                  $(this).find("span").text(data.output); 
                } 
          } 
        });

  }else if($(this).hasClass('switch-types')){
    
    var action = 'switch_types';
    var id = $(this).data("type"); 

     $.ajax({
          url: '../app/run.php',
          type: 'POST',
          context: this,
          data: {
            action: action,
            id: id
          },
          error: function() {
            alert('error');
          },
          beforeSend:function() {  
          },
          success: function(data)
          {   
                var data = $.parseJSON(data);
                if (data.error=='false') {
                  $(this).toggleClass("switchOn");
                  $(this).find("span").text(data.output); 
                } 
          } 
        });

  }
 
 
});  




$(document).on('click','.btn-edit-types',function (event) {

  action = 'form_types_edit' ;
  categorie = $(this).data('category');
  type = $(this).data('type');

  $.ajax({
        url: '../app/get.php',
        type: 'GET',
        context: this,
        data: {
          action: action,
          categorie: categorie,
          type: type
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
          
              if (data.error == 'false') {
                 $('.contentu').html(data.output);
              }
             
        }
      });

})

 
var loadingContenu = function(params) {

  window.history.pushState("", "", currentLocationFolder+'/'+params);
  action = 'load';

  $.ajax({
        url: '../app/get.php',
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
              $('.contentu').html(data.output);
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

 
$(document).on('click','.btn-menu-categories',function (event) {
$(this).parent().parent().find('.btn-menu-categories').css({'background':'white','color':'#424242'});
$(this).css({'background':'#424242','color':'white'});
var params_new = $(this).data('type');  
loadingContenu(params_new);




})

$(document).on('click','.btn-menu-sub',function (event) {
  var params_new = $(this).data('category');  
  loadingContenu(params_new);
})

 
$(document).on('click','.btn-products-types',function (event) {
var params_new = $(this).data('type'); 
loadingContenu(params_new);
})




$(document).on('click keyup keydown','input[type=text], input[type=password]',function (event) {
  $(this).parent().removeClass('required-grid'); 
  $(this).removeClass('required-input'); 
  $(this).parent().find('span').removeClass('required-span'); 
  $(this).parent().find('i').removeClass('required-i'); 
  $('.succes-span').parent().addClass('hide');
  $('.incorrect-span').parent().addClass('hide'); 
})
// GLOBAL EVENT


// FINISH INCORRECT

$(document).on('click','#btn-ShowFromCategory',function (event) { 
  $('.content-form-categories').css('left','0');
})
 

$(document).on('click','#btn-ShowFromType',function (event) { 
  $('.content-form-types').css('left','0');
})
 

$(document).on('click','#btn-HideFromType, #btn-HideFromCategory, #btn-HideFromTypeEdit, #btn-HideFormProducts, #btn-HideFormProductEditing',function (event) {
  
 var currentLocationFolder =document.URL.split('/').slice(0, -1).join('/');
 var currentLocation = '{"params":"'+window.location+'"}';
 var params = currentLocation.replace(currentLocationFolder+'/', '');

  params = $.parseJSON(params);
  params = params.params;
  params = params.replace(/%20/g, ' '); 
  loadingContenu(params);

})


 

$(document).on('click','#addCategorie',function (event) {

  var categorie = $('#IDcategorie').val();

  if (categorie=='') {  
    $('#IDcategorie').parent().find('input').addClass('required-input'); 
    $('#IDcategorie').parent().find('span').addClass('required-span'); 
    $('#IDcategorie').parent().find('i').addClass('required-i'); 
  }else{

    var action = 'add_categorie'; 

    $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data: {
          action: action,
          categorie: categorie
        },
        error: function() {
          $('.incorrect-span').text("Error d'ajoute! Veuillez vérifier et réessayer.");
          $('.incorrect-span').parent().removeClass('hide');
          $('#IDcategorie').val('');
        },
        beforeSend:function() {
          // $('#login').attr('disabled','disabled');
          $('.btn-spin').removeClass('hide');
        },
        success: function(data)
        { 
            // $('#login').attr('disabled','disabled');
  
              var data = $.parseJSON(data);
 
              setTimeout(function() {
                
                  if (data.error == 'false'){

                    // alert(data.output);
                   $('.form-get-tables').parent().html(data.output);
                   // $('.ul-categories').html('');  
                   $('#addCategorie').parent().find('.btn-spin').addClass('hide');
                   $('.succes-span').parent().removeClass('hide');
                   $('#IDcategorie').val('');
                   setTimeout(function() {
                    $('.succes-span').parent().addClass('hide');
                   },2000)

                }else{

                  $('#addCategorie').parent().find('.btn-spin').addClass('hide');
                  $('.incorrect-span').text(data.output);
                  $('.incorrect-span').parent().removeClass('hide');
                  // $('#IDcategorie').val('');

                }

              },3000)
 

        } 
      });
  }

})
// ADD CATEGORY
  
$(document).on('click','#addType',function (event) {

  var type = $('#NameType').val();
  var id = $(this).data('category'); 
  var action = 'add_type'; 

  if (type=='') {  
    $('#NameType').parent().find('input').addClass('required-input'); 
    $('#NameType').parent().find('span').addClass('required-span'); 
    $('#NameType').parent().find('i').addClass('required-i'); 
  }else if (id==''||id===undefined) {
          $('.incorrect-span').text("Error #3031! Veuillez contacter l'administrateur.");
          $('.incorrect-span').parent().removeClass('hide'); 
  }else{
 
    $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data: {
          action: action,
          id: id,
          type:type
        },
        error: function() {
          $('.incorrect-span').text("Error d'ajoute! Veuillez vérifier et réessayer.");
          $('.incorrect-span').parent().removeClass('hide');
          $('#NameType').val('');
        },
        beforeSend:function() {
          // $('#login').attr('disabled','disabled');
          $('.btn-spin').removeClass('hide');
        },
        success: function(data)
        { 
            // $('#login').attr('disabled','disabled');
            // alert(data);
            
              var data = $.parseJSON(data); 
               
              setTimeout(function() {
                
                  if (data.error == 'false'){
 
                   $('.content-form-types .form-get-tables').parent().html(data.output);
                   // $('.ul-categories').html('');  
                   $('#addType').parent().find('.btn-spin').addClass('hide');
                   $('.succes-span').parent().removeClass('hide');
                   $('#NameType').val('');
                   setTimeout(function() {
                    $('.succes-span').parent().addClass('hide');
                   },2000)

                }else{

                  $('#addType').parent().find('.btn-spin').addClass('hide');
                  $('.incorrect-span').text(data.output);
                  $('.incorrect-span').parent().removeClass('hide');
                  // $('#IDcategorie').val('');

                }

              },3000)
 

        } 
      });
  }

})
// ADD TYPE



$(document).on('click','#BtnEditType',function (event) {

  var new_type = $('#NameTypeEdit').val();
  var id = $(this).data('id');
  var action = 'update_type'; 

  if (new_type=='') {  
    $('#NameTypeEdit').parent().find('input').addClass('required-input'); 
    $('#NameTypeEdit').parent().find('span').addClass('required-span'); 
    $('#NameTypeEdit').parent().find('i').addClass('required-i'); 
  }else{
  
    $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data: {
          action: action,
          new_type: new_type,
          id: id
        },
        error: function() {
          $('.incorrect-span').text("Error de modifier! Veuillez vérifier et réessayer.");
          $('.incorrect-span').parent().removeClass('hide');
          $('#NameTypeEdit').val('');
        },
        beforeSend:function() { 
          $('.btn-spin').removeClass('hide');
        },
        success: function(data)
        {  
 
              var data = $.parseJSON(data);
 
              setTimeout(function() {
                
                  if (data.error == 'false'){
  
                   $('#BtnEditType').parent().find('.btn-spin').addClass('hide');
                   $('.succes-span').parent().removeClass('hide');
                   $('#NameTypeEdit').val(new_type);
                   setTimeout(function() {
                    $('.succes-span').parent().addClass('hide');
                   },2000)

                }else{

                  $('#BtnEditType').parent().find('.btn-spin').addClass('hide');
                  $('.incorrect-span').text(data.output);
                  $('.incorrect-span').parent().removeClass('hide'); 

                }

              },3000)
 

        } 
      });
  }

})
// EDIT TYPE













// PRODUCTS FUNCS

// DISPLAY PHOTO PRODUCTS
var showImageURL = function(input) {
      
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file = input.files[0];
            reader.onload = function (e) { 
                $('.display-product').attr('src', e.target.result);
                $('.display-product').parent().css({'padding-top':'150px'});
            };

            reader.readAsDataURL(input.files[0]);
        }
 }
 //  ON CHOSE PICTURE PRODUCTS   
$(document).on('change','#product-photo',function (event) {
  return showImageURL(this);
})





$('#btnSendAdded').on('click',function() {
 

    if (caty==''||sub_caty==''||reference==''||description=='') {
       alert('Veuillez remplir les champs !')
       return false;
    }else if (photos_chosed=='') {
       alert('Veuillez choisir une photo !')
       return false;
    }else{
                
                $.ajax({
                  url:"./dashboard.php",
                  method:"POST",
                  data:{
                    action:action, 
                    catygorie:caty,
                    sub_caty:sub_caty,
                    reference:reference,
                    description:description,
                    pcs:pcs
                  }, 
                success:function(data)
                { 
                  
                  // alert(data);

                  var form_data = new FormData();
                  form_data.append("picture", document.getElementById('file-photo').files[0]);   
                
                    $.ajax({
                      url: './dashboard.php',
                      type: 'POST',
                      data:form_data,
                      contentType: false,
                      cache: false,
                      processData: false, 
                    error: function() {
                     alert(data)
                    },
                    beforeSend: function() {
                     // alert(data)
                    },
                    success: function(data) {  
                     alert("success added article !") 
                    } 
                    });

                }
                });
    }
})




$(document).on('click','.btn-ajouter-show-produit-form',function (event) {
  
    var action = 'form_product'; 
    var type = $(this).data('type');
 
      $.ajax({
        url: '../app/get.php',
        type: 'GET',
        context: this,
        data: {
          action: action, 
          type: type
        },
        error: function() {
          alert('error');
        },
        beforeSend:function() {  
        },
        success: function(data)
        {  
         
          
              var data = $.parseJSON(data);
          
              if (data.error == 'false') {
                 $('.content-products').prepend(data.output);
              }else{
                $('.contentu').html(data.output);
              }
             
        }
      });

})


$(document).on('click','.btn-edit-show-produit-form',function (event) {
  
    var action = 'form_product_editing'; 
    var product = $(this).data('product');

      $.ajax({
        url: '../app/get.php',
        type: 'GET',
        context: this,
        data: {
          action: action, 
          product: product
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
          
              if (data.error == 'false') {
                 $('.content-products').prepend(data.output);
              }else{
                $('.contentu').html(data.output);
              }
             
        }
      });

})


$(document).on('click','#addProductDimensions',function (event) {
  
    var action = 'form_product_more'; 
    var product = $(this).data('product');

      $.ajax({
        url: '../app/get.php',
        type: 'GET',
        context: this,
        data: {
          action: action, 
          product: product
        },
        error: function() {
          alert('error');
        },
        beforeSend:function() {  
        },
        success: function(data)
        {  

              var data = $.parseJSON(data);
          
              if (data.error == 'false') {
                 $('.container-form').html(data.output);
              }else{
                $('.contentu').html(data.output);
              }
             
        }
      });

})




$(document).on('click','#addProduct',function (event) {

  var reference   = $('#IDreference').val();
  var description = $('#IDdescription').val();
  var dimension = $('#IDdimension').val();
  var qte_pcs     = $('#IDqte_pcs').val();
  var qte_pqt     = $('#IDqte_pqt').val();
  var photo       = $('#product-photo').val();

  var type = $(this).data('type'); 
  var action = 'add_product'; 

  if (reference==''&&description==''&&dimension==''&&qte_pcs==''&&qte_pqt=='') { 
    $('input[type="text"]').parent().find('input').addClass('required-input'); 
    $('input[type="text"]').parent().find('span').addClass('required-span'); 
    $('input[type="text"]').parent().find('i').addClass('required-i'); 
  }if (reference=='') { 
    $('#IDreference').parent().find('input').addClass('required-input'); 
    $('#IDreference').parent().find('span').addClass('required-span'); 
    $('#IDreference').parent().find('i').addClass('required-i'); 
  }else if (description=='') { 
    $('#IDdescription').parent().find('input').addClass('required-input'); 
    $('#IDdescription').parent().find('span').addClass('required-span'); 
    $('#IDdescription').parent().find('i').addClass('required-i'); 
  }else if (dimension=='') { 
    $('#IDdimension').parent().find('input').addClass('required-input'); 
    $('#IDdimension').parent().find('span').addClass('required-span'); 
    $('#IDdimension').parent().find('i').addClass('required-i'); 
  }else if(qte_pcs=='') { 
    $('#IDqte_pcs').parent().find('input').addClass('required-input'); 
    $('#IDqte_pcs').parent().find('span').addClass('required-span'); 
    $('#IDqte_pcs').parent().find('i').addClass('required-i'); 
  }else if (qte_pqt=='') { 
    $('#IDqte_pqt').parent().find('input').addClass('required-input'); 
    $('#IDqte_pqt').parent().find('span').addClass('required-span'); 
    $('#IDqte_pqt').parent().find('i').addClass('required-i'); 
  }else if(photo==''){
    alert('Veuillez choisir une photo !');
    return false;
  }else if (type==''||type===undefined) {
          $('.incorrect-span').text("Error #3031! Veuillez contacter l'administrateur.");
          $('.incorrect-span').parent().removeClass('hide'); 
  }else{
    
    var form_data = new FormData();
    form_data.append("picture", document.getElementById('product-photo').files[0]); 
    form_data.append( "action",action);
    form_data.append( "type",type);
    form_data.append( "reference",reference);
    form_data.append( "description",description);
    form_data.append( "dimension",dimension);
    form_data.append( "qte_pcs",qte_pcs);
    form_data.append( "qte_pqt",qte_pqt);

                
      $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data:form_data,
        contentType: false, 
        cache: false,
        processData: false, 
        error: function() {
            $('.incorrect-span').text("Error d'ajoute! Veuillez vérifier et réessayer.");
            $('.incorrect-span').parent().removeClass('hide');
        },
        beforeSend: function() {
         $('.btn-spin').removeClass('hide');
        },
        success: function(data) { 
 
            var data = $.parseJSON(data); 

            setTimeout(function() {
              
                if (data.error == 'false'){

                 $('#addProduct').parent().find('.btn-spin').addClass('hide');
                 $('.succes-span').parent().removeClass('hide');
                 $('.display-product').removeAttr('src');
                 $('.display-product').parent().css({'padding-top':'0'});
                 $("#product-photo").val('');
                 $('input[type="text"]').val('');
                 setTimeout(function() {
                  $('.succes-span').parent().addClass('hide');
                 },2000)

              }else{

                $('#addProduct').parent().find('.btn-spin').addClass('hide');
                $('.incorrect-span').text(data.output);
                $('.incorrect-span').parent().removeClass('hide');
                
              }

            },3000)

        } 

      });
 
  }

})
// ADD PRODUCT

$(document).on('click','#editProduct',function (event) {

  var reference   = $('#IDreference').val();
  var description = $('#IDdescription').val();
  var dimension = $('#IDdimension').val();
  var qte_pcs     = $('#IDqte_pcs').val();
  var qte_pqt     = $('#IDqte_pqt').val();
  var photo       = $('#product-photo').val();

  var product = $(this).data('product'); 
  var action = 'edit_product'; 

  if (reference==''&&description==''&&dimension==''&&qte_pcs==''&&qte_pqt=='') { 
    $('input[type="text"]').parent().find('input').addClass('required-input'); 
    $('input[type="text"]').parent().find('span').addClass('required-span'); 
    $('input[type="text"]').parent().find('i').addClass('required-i'); 
  }if (reference=='') { 
    $('#IDreference').parent().find('input').addClass('required-input'); 
    $('#IDreference').parent().find('span').addClass('required-span'); 
    $('#IDreference').parent().find('i').addClass('required-i'); 
  }else if (description=='') { 
    $('#IDdescription').parent().find('input').addClass('required-input'); 
    $('#IDdescription').parent().find('span').addClass('required-span'); 
    $('#IDdescription').parent().find('i').addClass('required-i'); 
  }else if (dimension=='') { 
    $('#IDdimension').parent().find('input').addClass('required-input'); 
    $('#IDdimension').parent().find('span').addClass('required-span'); 
    $('#IDdimension').parent().find('i').addClass('required-i'); 
  }else if(qte_pcs=='') { 
    $('#IDqte_pcs').parent().find('input').addClass('required-input'); 
    $('#IDqte_pcs').parent().find('span').addClass('required-span'); 
    $('#IDqte_pcs').parent().find('i').addClass('required-i'); 
  }else if (qte_pqt=='') { 
    $('#IDqte_pqt').parent().find('input').addClass('required-input'); 
    $('#IDqte_pqt').parent().find('span').addClass('required-span'); 
    $('#IDqte_pqt').parent().find('i').addClass('required-i'); 
  }else if (product==''||product===undefined) {
          $('.incorrect-span').text("Error #3031! Veuillez contacter l'administrateur.");
          $('.incorrect-span').parent().removeClass('hide'); 
  }else{
    
    var form_data = new FormData();
    form_data.append("picture", document.getElementById('product-photo').files[0]); 
    form_data.append( "action",action);
    form_data.append( "product",product);
    form_data.append( "reference",reference);
    form_data.append( "description",description);
    form_data.append( "dimension",dimension);
    form_data.append( "qte_pcs",qte_pcs);
    form_data.append( "qte_pqt",qte_pqt);

                
      $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data:form_data,
        contentType: false, 
        cache: false,
        processData: false, 
        error: function() {
            $('.incorrect-span').text("Error de modifer! Veuillez vérifier et réessayer.");
            $('.incorrect-span').parent().removeClass('hide');
        },
        beforeSend: function() {
         $('.btn-spin').removeClass('hide');
        },
        success: function(data) { 

            alert(data);
            return false;
 
            var data = $.parseJSON(data); 

            setTimeout(function() {
              
                if (data.error == 'false'){

                 $('#addProduct').parent().find('.btn-spin').addClass('hide');
                 $('.succes-span').parent().removeClass('hide');
                 $('.display-product').removeAttr('src');
                 $('.display-product').parent().css({'padding-top':'0'});
                 $("#product-photo").val('');
                 $('input[type="text"]').val('');
                 setTimeout(function() {
                  $('.succes-span').parent().addClass('hide');
                 },2000)

              }else{

                $('#addProduct').parent().find('.btn-spin').addClass('hide');
                $('.incorrect-span').text(data.output);
                $('.incorrect-span').parent().removeClass('hide');
                
              }

            },3000)

        } 

      });
 
  }

})
// EDIT PRODUCT




$(document).on('click','#addProduct_dimension',function (event) {

  var reference   = $('#IDreference').val(); 
  var dimension   = $('#IDdimension').val();
  var qte_pcs     = $('#IDqte_pcs').val();
  var qte_pqt     = $('#IDqte_pqt').val(); 

  var product = $(this).data('product'); 
  var action = 'add_product_dimension'; 

  if (reference==''&&dimension==''&&qte_pcs==''&&qte_pqt=='') { 
    $('input[type="text"]').parent().find('input').addClass('required-input'); 
    $('input[type="text"]').parent().find('span').addClass('required-span'); 
    $('input[type="text"]').parent().find('i').addClass('required-i'); 
  }if (reference=='') { 
    $('#IDreference').parent().find('input').addClass('required-input'); 
    $('#IDreference').parent().find('span').addClass('required-span'); 
    $('#IDreference').parent().find('i').addClass('required-i'); 
  }else if (dimension=='') { 
    $('#IDdimension').parent().find('input').addClass('required-input'); 
    $('#IDdimension').parent().find('span').addClass('required-span'); 
    $('#IDdimension').parent().find('i').addClass('required-i'); 
  }else if(qte_pcs=='') { 
    $('#IDqte_pcs').parent().find('input').addClass('required-input'); 
    $('#IDqte_pcs').parent().find('span').addClass('required-span'); 
    $('#IDqte_pcs').parent().find('i').addClass('required-i'); 
  }else if (qte_pqt=='') { 
    $('#IDqte_pqt').parent().find('input').addClass('required-input'); 
    $('#IDqte_pqt').parent().find('span').addClass('required-span'); 
    $('#IDqte_pqt').parent().find('i').addClass('required-i'); 
  }else if (product==''||product===undefined) {
          $('.incorrect-span').text("Error #3031! Veuillez contacter l'administrateur.");
          $('.incorrect-span').parent().removeClass('hide'); 
  }else{
      
                
      $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data:{
         action:action,
         product:product,
         reference:reference,
         dimension:dimension,
         qte_pcs:qte_pcs,
         qte_pqt:qte_pqt
        },
        error: function() {
            $('.incorrect-span').text("Error d'ajoute! Veuillez contacter le developpeur."); 
        },
        beforeSend: function() {
         $('.btn-spin').removeClass('hide');
        },
        success: function(data) { 

            var data = $.parseJSON(data); 

            setTimeout(function() {
              
                if (data.error == 'false'){
                 $('#addProduct_dimension').parent().find('.btn-spin').addClass('hide');
                 $('.table-product-dimensions').html(data.output);
                 $('.succes-span').parent().removeClass('hide');
                 $('input[type="text"]').val('');
                 setTimeout(function() {
                  $('.succes-span').parent().addClass('hide');
                 },2000)

              }else{

                $('#addProduct_dimension').parent().find('.btn-spin').addClass('hide');
                $('.incorrect-span').text(data.output);
                $('.incorrect-span').parent().removeClass('hide');
                
              }

            },3000)

        } 

      });
 
  }

})
// ADD DIMENSION PRODUCT


$(document).on('click','.btn-detele-dimensions',function (event) {

  reference = $(this).data('id');
  action = 'delete_reference';

  var agree = confirm("Vous êtes sûr de vouloir supprimer cette référence : "+reference+" ?");

  if(agree == true){
    
    
     $.ajax({
        url: '../app/run.php',
        type: 'POST',
        data:{
         action:action,
         reference:reference
        },
        error: function() {
            $('.incorrect-span').text("Error de supprimer! Veuillez contacter le developpeur."); 
        },
        beforeSend: function() {
         $('.btn-spin').removeClass('hide');
        },
        success: function(data) { 
  
            var data = $.parseJSON(data); 

            setTimeout(function() {
              
                if (data.error == 'false'){ 
                 $('.btn-spin').addClass('hide');
                 $('.table-product-dimensions').html(data.output); 
                 $('.success-span').html('<i class="fa fa-check" aria-hidden="true"></i> reference a été supprimé avec succès.');
                 $('.succes-span').parent().removeClass('hide');
                 setTimeout(function() {
                  $('.succes-span').parent().addClass('hide');
                 },2000)

              }else{
                
                $('.btn-spin').addClass('hide');
                $('.incorrect-span').text(data.output);
                $('.incorrect-span').parent().removeClass('hide');
                
              }

            },3000)

        } 

      });


  } 

})
// DELETE DIMENSION PRODUCT

$(document).on('click','.btn-products-back',function (event) {
  loadingContenu('products');
})


$(document).on('mouseenter','.products-zone',function (event) {
  $(this).find('.btn-edit-show-produit-form').removeClass('hide');
});

$(document).on('mouseleave','.products-zone',function (event) {
  $(this).find('.btn-edit-show-produit-form').addClass('hide');
});




$(document).on( "click", '.content-grids-products' , function( event) { 
  $('.content-grids-products').sortable({
    update:function(event, ui) {
      $(this).children().each(function (index) {
        if ($('.content-grids-products').attr('data-position') != (index+1) ) {
          $(this).attr('data-position', (index+1)).addClass('updated');
        }
      })
      saveNewPositions();
    }
  }); 
})


     

function saveNewPositions() {
   var positions = [];
   $('.updated').each(function() {
    positions.push([$(this).attr('data-product'),$(this).attr('data-position')]); 
    $(this).removeClass('updated');
   });

   $.ajax({
    url:'../app/run.php',
    method:'POST',
    dataType:'text',
    data:{
      update:1,
      positions:positions
    },success:function(response) {
      console.log(response);
    }
   })
}






}); 



 


 


 


 


 


 


 


 


 


 


 


