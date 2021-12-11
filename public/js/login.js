 $(document).ready(function () {
     

 // GLOBAL VAR 
   
$(document).on('click keyup keydown','input[type=text]',function (event) {
  $(this).removeClass('required-input'); 
  $(this).parent().find('span').removeClass('required-span'); 
  $(this).parent().find('i').removeClass('required-i');  
})
 



$(document).on('click','#loginAdmin',function (event) {

  action = 'login';

  email = $('#emailID').val();
  pass = $('#passID').val(); 
  
  if (email==''&&pass=='') {
    $('.input-login').addClass('required-input'); 
    $('.input-login').parent().find('span').addClass('required-span'); 
    $('.input-login').parent().find('i').addClass('required-i'); 
  }else{
    
      $.ajax({
        url: './index.php',
        type: 'POST',
        context: this,
        data: {
          action: action,
          email: email,
          password: pass 
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
                   
                    location.reload(); 

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



 


 


 


 


 


 


 


 


 


 


 


