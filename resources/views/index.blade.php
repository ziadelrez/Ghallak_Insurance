<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HALLAK | INSURANCE BROKER OFFICE</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href={{URL::asset('index_files/css/icons.css')}} rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href={{URL::asset('index_files/css/easy-responsive-tabs.css')}} />
    <link rel="stylesheet" type="text/css" href={{URL::asset('index_files/css/flexslider.css')}} />
    <link rel="stylesheet" type="text/css" href={{URL::asset('index_files/css/owl.carousel.css')}}>
    <!--[if lt IE 8]><!-->
    <link rel="stylesheet" href="ie7/ie7.css">
    <!--<![endif]-->
    <link href={{URL::asset('index_files/css/style.css')}} rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target=".navbar-fixed-top">
@include('includes.adminpanel.landingheader')
<div class="clear"></div>
<div id="page-content">
    <section class="flexslider">
        <ul class="slides">
            @foreach($inslist as $ilist)
                <li>
                    <img src={{URL::asset('index_files/images/slider-img.jpg')}} />
                    <div class="slide-info">
                        <div class="slide-con">
                            <b>{{$ilist -> instype}}</b>
                            <h3>{{$ilist -> insname}}</h3>
                            <p>{{$ilist -> details}}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
    <section class="partners">
        <div class="container">
            <div class="row">
                <div class="parner-slider-mn">
                    <div class="col-sm-3">
                        <h2>
                            <b>HALLAK</b> Partners
                        </h2>
                    </div>
                    <div class="col-sm-9">
                        <div class="partner-slider owl-carousel">
                            @foreach($complist as $clist)
                                <div>
                                    <div class="partner-logo">
                                        <h2>{{$clist->compname}}</h2>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="clear"></div>
@include('includes.adminpanel.landingfooter')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src={{URL::asset('index_files/js/jquery.flexslider-min.js')}}></script>
<script src={{URL::asset('index_files/js/easyResponsiveTabs.js')}}></script>
<script src={{URL::asset('index_files/js/owl.carousel.js')}}></script>
<script src={{URL::asset('index_files/js/custom.js')}}></script>
</body>

</html>
