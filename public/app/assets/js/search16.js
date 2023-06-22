( function($) {
  
    $(document).ready(function(){
    $('#contract').keyup(function(){
        var Search = $('#contract').val();
        var person = $('#person').val();
        if(Search!= ""){
            $.ajax({
                url: 'search16.php?person='+person,
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#contract_content').html(data);
                }
            })
        }
        else{
            $('#contract_content').html('');
        }
       
    })
  })
  } ) ( jQuery );
  ( function($) {
  
    $(document).ready(function(){
    $('#car').keyup(function(){
        var Search = $('#car').val();
        var person = $('#person').val();
        if(Search!= ""){
            $.ajax({
                url: 'search17.php?person='+person,
                type: 'POST',
                data:{s:Search},
                success: function(data){
                    $('#car_content').html(data);
                }
            })
        }
        else{
            $('#car_content').html('');
        }
       
    })
  })
  } ) ( jQuery );