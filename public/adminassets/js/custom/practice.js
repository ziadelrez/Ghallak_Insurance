// let name = 'ziad';
// let age = 40;

// Create Objects
// let person = {
//     name:'wassim',
//     age:'30'
// }

// Array
// let selectedColors =['red','blue'];
// selectedColors[2]='1500';

// Functions -> Perform a Tasks

// function greet(name,lastName){
//     if (name == 'ziad'){
//         console.log('Name : ' + ' ' + name + ' ' + lastName);
//     }
//     else{
//         console.log('Ungranted User');
//     }
// }
//
// greet('ziad','El Rez');
// greet('Wassim','El Rez');
//
//
// // Functions -> Calculate a Values
//
// function getsum(num){
//    return  num * num;
// }
//
// let num = getsum(2);
// console.log(num);

$(document).ready(function(){
    $('#btnid').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            }
        })

        $.ajax({
            url:"{{url('/ajax')}}",
            method:'POST',
            data:{
                file : $('#fileid').val()
            },
            success:function(result){

            }

        })

        // console.log('Here Im');
        // $('#showlbl').show();
    })
});

