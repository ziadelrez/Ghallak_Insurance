<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-client.clients.attach_title') }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href={{ URL::asset('adminassets/css/admin.rtl.css') }} rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Styles go here */

        .page-header, .page-header-space {
            height: 100px;
        }

        .page-footer, .page-footer-space {
            height: 50px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid black;
            background: #fefefe;
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            border-bottom: 1px solid black;
            background: #fefefe;
        }

        .page {
            page-break-after: always;
        }

        @page {
            margin: 20mm
        }

        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group;}

            /*button {display: none;}*/
            #printbtn {
                display :  none;
            }
            body {margin: 0;}
        }

        /* Style buttons */
        .btn {
            background-color: DodgerBlue; /* Blue background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 12px 16px; /* Some padding */
            font-size: 16px; /* Set a font size */
            cursor: pointer; /* Mouse pointer on hover */
        }

        /* Darker background on mouse-over */
        .btn:hover {
            background-color: RoyalBlue;
        }

    </style>
</head>

<body>

<div class="page-header" style="text-align: center">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
           <h4>{{ trans('page-client.clients.docname') }}<span style="color:black"> : </span><span style="color:red">{{$rec2}}</span ></h4>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <h3>{{$branchname}}</h3>
            <button  id="printbtn" type="button" onClick="window.print()" class="btn"><i class="fa fa-print" style="font-size:24px"></i>
                {{ trans('page-client.clients.printout') }}
            </button>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <img class="card-img-top "  src={{'/adminassets/img/logo.jpg'}} style="width:200px;height:90px;">
        </div>
    </div>
</div>

<div class="page-footer">

</div>
<div class="page-header-space"></div>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <img class="card-img-top "  src={{'/files/clients/'.$rec1.'/'.$rec3}} >
        </div>
    </div>

</div>
</body>

</html>
