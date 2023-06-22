( function($) {
    $('#table1').hide();
    $(document).ready(function(){
        $('#accident_search').keyup(function(){
            $('#table1').show();
            var Search = $('#accident_search').val();
            var person = $('#comp1').val();
            console.log(Search);
            if(Search!= ""){
                $.ajax({
                    url: 'search23.php',
                    type: 'POST',
                    data:{s:Search, person: person},
                    success: function(data){
                        $('#accident_table').html(data);
                    }
                })
            }
            else{
                $('#accident_table').html('');
            }
           
        })
      })
      } ) ( jQuery );