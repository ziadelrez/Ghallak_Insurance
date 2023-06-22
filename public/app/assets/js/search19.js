( function($) {
    $('#table2').hide();
    $(document).ready(function(){
        $('#contract_search').keyup(function(){
            $('#table2').show();
            var Search = $('#contract_search').val();
            var person = $('#agent').val();
            console.log(Search);
            if(Search!= ""){
                $.ajax({
                    url: 'search19.php',
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