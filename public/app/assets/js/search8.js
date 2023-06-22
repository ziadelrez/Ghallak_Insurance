( function($) {
  
    $(document).ready(function(){
    $('#agent').keyup(function(){
        var Search = $('#agent').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search8.php?search8=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#agent_content').html(data);
                }
            })
        }
        else{
            $('#agent_content').html('');
        }
       
    })
  })
  } ) ( jQuery );