( function($) {
  
    $(document).ready(function(){
    $('#comp1').keyup(function(){
        var Search = $('#comp1').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search15.php?search15=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#comp_contents').html(data);
                }
            })
        }
        else{
            $('#comp_contents').html('');
        }
       
    })
  })
  } ) ( jQuery );