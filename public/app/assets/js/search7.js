( function($) {
  
    $(document).ready(function(){
    $('#search7').keyup(function(){
        var Search = $('#search7').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search7.php?search7=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#content7').html(data);
                }
            })
        }
        else{
            $('#content7').html('');
        }
       
    })
  })
  } ) ( jQuery );

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