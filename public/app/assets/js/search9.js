( function($) {
  
    $(document).ready(function(){
    $('#expert_search').keyup(function(){
        var Search = $('#expert_search').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search9.php?search9=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#expert_content').html(data);
                }
            })
        }
        else{
            $('#expert_content').html('');
        }
       
    })
  })
  } ) ( jQuery );

  ( function($) {
  
    $(document).ready(function(){
    $('#expert').keyup(function(){
        var Search = $('#expert').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search10.php?search10=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#contentsss').html(data);
                }
            })
        }
        else{
            $('#contentsss').html('');
        }
       
    })
  })
  } ) ( jQuery );

  ( function($) {
  
    $(document).ready(function(){
    $('#garage_search').keyup(function(){
        var Search = $('#garage_search').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search11.php?search11=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#garage_contents').html(data);
                }
            })
        }
        else{
            $('#garage_contents').html('');
        }
       
    })
  })
  } ) ( jQuery );

  ( function($) {
  
    $(document).ready(function(){
    $('#garage').keyup(function(){
        var Search = $('#garage').val();
  
        if(Search!= ""){
            $.ajax({
                url: 'search12.php?search12=1',
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#garage_content').html(data);
                }
            })
        }
        else{
            $('#garage_content').html('');
        }
       
    })
  })
  } ) ( jQuery );
