( function($) {
  
    $(document).ready(function(){
    $('#search4').keyup(function(){
        var Search4 = $('#search4').val();
  
        if(Search4!= ""){
            $.ajax({
                url: 'search4.php?search4=1',
                type: 'POST',
                data:{s:Search4},
                success: function(data){
                    $('#content4').html(data);
                }
            })
        }
        else{
            $('#content4').html('');
        }
       
    })
  })
  } ) ( jQuery );