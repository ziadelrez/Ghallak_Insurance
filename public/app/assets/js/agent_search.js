( function($) {
  
    $(document).ready(function(){
    $('#agent1').keyup(function(){
        var agent1 = $('#agent1').val();
  
        if(agent1!= ""){
            $.ajax({
                url: 'agent_search.php?agent1=1',
                type: 'POST',
                data:{s:agent1},
                success: function(data){
                    $('#agent1_content').html(data);
                }
            })
        }
        else{
            $('#agent1_content').html('');
        }
    })
  
  }) 
}) ( jQuery );