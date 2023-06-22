$(document).ready(function () {
    // console.log("Hello Ziad");
    getpayments($('#client_id').val());
    getsum();
});

function getsum(){
    var totaldep = 0;
    var totalamount = 0;
    var totalreceived = 0;
    var totalremain = 0;

    $("#tablecontract tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(3)").html();
        var stval = parseFloat(value);
        totaldep += isNaN(stval) ? 0 : stval;
    });
    // console.log(totaldep);
    $("#totaldeposits").val(totaldep);

    $("#tablecontract tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(6)").html();
        var stval = parseFloat(value);
        totalamount += isNaN(stval) ? 0 : stval;
    });
    // console.log(totalamount);
    $("#totalamounts").val(totalamount);

    $("#tablepayments tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(6)").html();
        var stval = parseFloat(value);
        totalreceived += isNaN(stval) ? 0 : stval;
    });
    // console.log(totalreceived);
    $("#totalreceived").val(totalreceived);

    totalremain = totalamount - totalreceived;
    $("#totalremain").val(totalremain);

}

function getsumpayments(){
    $("#tablepayments tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(6)").html();
        var stval = parseFloat(value);
        totalreceived += isNaN(stval) ? 0 : stval;
    });
    // console.log(totalreceived);
    $("#totalreceived").val(totalreceived);
}

function getpayments(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getprintpaymentslist',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'clientid' : ccid
        },
        dataType:'json',
        success: function(data){
            // console.log(data.length)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    console.log(val[0]);
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#tablepayments').html(data.payment_data);
                getsum();
                if(data.rflagpayment == "1"){
                    document.getElementById("noresultpayment").style.display = "none";
                }
            }
        },
    });
}

