( function($) {
  
    $(document).ready(function(){
    $('#search3').keyup(function(){
        var Search3 = $('#search3').val();
  
        if(Search3!= ""){
            $.ajax({
                url: 'inter.php?search3=1',
                type: 'POST',
                data:{s:Search3},
                success: function(data){
                    $('#content3').html(data);
                }
            })
        }
        else{
            $('#content3').html('');
        }
    })
  
  }) 
}) ( jQuery );

( function($) {
  
    $(document).ready(function(){
    $('#car_search').keyup(function(){
        var car_search = $('#car_search').val();
  
        if(car_search!= ""){
            $.ajax({
                url: 'inter1.php?car_search=1',
                type: 'POST',
                data:{s:car_search},
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
}) ( jQuery );