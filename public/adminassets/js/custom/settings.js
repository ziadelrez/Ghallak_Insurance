$(document).ready(function () {

    $("#smsrenewlbl").text("عدد الأحرف المتبقية : " + (70 - document.getElementById('smsrenewdetails').value.length));
    $("#smspaymentlbl").text("عدد الأحرف المتبقية : " + (70 - document.getElementById('smspaymentdetails').value.length));

});

$("#smsrenewdetails").keyup(function(){
    $("#smsrenewlbl").text("عدد الأحرف المتبقية : " + (70 - $(this).val().length));
});

$("#smspaymentdetails").keyup(function(){
    $("#smspaymentlbl").text("عدد الأحرف المتبقية : " + (70 - $(this).val().length));
});


