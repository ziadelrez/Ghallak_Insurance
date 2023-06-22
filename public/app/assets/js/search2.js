( function($) {
  
    $(document).ready(function(){
    $('#search2').keyup(function(){
        var Search2 = $('#search2').val();
  
        if(Search2!= ""){
            $.ajax({
                url: 'search2.php?search2=1',
                type: 'POST',
                data:{s:Search2},
                success: function(data){
                    $('#content2').html(data);
                }
            })
        }
        else{
            $('#content2').html('');
        }
    })
})

    //     $(document).ready(function(){
    //         $('#search2').onChange(function(){
    //             var person = document.getElementById("search2").value;
          
    //             if(person!= ""){
    //                 $.ajax({
    //                     url: 'contracts.php?person='+person,
    //                     type: 'POST',
    //                     data:{person:person},
    //                     success: function(data){
    //                        var person2 = data;
    //                     }
    //                 })
    //             }
    //         })
    // })
  
  } ) ( jQuery );