( function($) {
  
    $(document).ready(function(){
    $('#client').keyup(function(){
        var Search = $('#client').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search6.php?search5=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#contents').html(data);
                }
            })
        }
        else{
            $('#content6').html('');
        }
       
    })
  })
  } ) ( jQuery );