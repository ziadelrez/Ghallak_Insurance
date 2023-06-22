( function($) {
  
    $(document).ready(function(){
    $('#car_search2').keyup(function(){
        var car_search2 = $('#car_search2').val();
        var person = $('#person').val();
        console.log(car_search2 + " , " + person);
        if(car_search2!= ""){
            $.ajax({
                url: 'inter2.php?person='+person,
                type: 'POST',
                data:{s:car_search2},
                success: function(data){
                    $('#car_content2').html(data);
                }
            })
        }
        else{
            $('#car_content2').html('');
        }
    })
  
  }) 
}) ( jQuery );