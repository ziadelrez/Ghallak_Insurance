( function($) {
  
    $(document).ready(function(){
    $('#search').keyup(function(){
        var Search = $('#search').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search.php?search=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#content').html(data);
                }
            })
        }
        else{
            $('#content').html('');
        }
       
    })
  })
  } ) ( jQuery );