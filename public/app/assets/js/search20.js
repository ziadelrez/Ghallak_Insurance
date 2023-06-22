( function($) {
    $('#table3').hide();
    $(document).ready(function(){
        $('#contract_search').keyup(function(){
            $('#table3').show();
            var Search = $('#contract_search').val();
            var person = $('#comp').val();
            console.log(Search);
            if(Search!= ""){
                $.ajax({
                    url: 'search20.php',
                    type: 'POST',
                    data:{s:Search, person: person},
                    success: function(data){
                        $('#contract_table').html(data);
                    }
                })
            }
            else{
                $('#contract_table').html('');
            }
           
        })
      })
      } ) ( jQuery );