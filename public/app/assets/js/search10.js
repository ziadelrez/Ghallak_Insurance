
  ( function($) {
  
    $(document).ready(function(){
    $('#company_search').keyup(function(){
        var Search = $('#company_search').val();
   
        if(Search!= ""){
            $.ajax({
                url: 'search13.php?search13=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#company_content').html(data);
                }
            })
        }
        else{
            $('#company_content').html('');
        }
       
    })
  })
  } ) ( jQuery );

  ( function($) {
  
    $(document).ready(function(){
    $('#comp').keyup(function(){
        var Search = $('#comp').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search14.php?search14=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#comp_content').html(data);
                }
            })
        }
        else{
            $('#comp_content').html('');
        }
       
    })
  })
  } ) ( jQuery );

