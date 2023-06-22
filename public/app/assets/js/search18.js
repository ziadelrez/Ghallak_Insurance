( function($) {
    $('#table1').hide();
    $(document).ready(function(){
        $('#contract_search').keyup(function(){
            $('#table1').show();
            var Search = $('#contract_search').val();
            var person = $('#client').val();
            console.log(Search);
            if(Search!= ""){
                $.ajax({
                    url: 'search18.php',
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