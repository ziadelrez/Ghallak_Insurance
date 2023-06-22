( function($) {
  
    $(document).ready(function(){
    $('#search5').keyup(function(){
        var Search = $('#search5').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search5.php?search5=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#content5').html(data);
                }
            })
        }
        else{
            $('#content5').html('');
        }
       
    })
  })
  } ) ( jQuery );