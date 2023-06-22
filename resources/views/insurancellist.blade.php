<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>INSURANCE PLANS | HALLAK INSURANCE BROKER</title>
    <link rel="shortcut icon" href="images/favicon.png" />
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
    <section class="product-tab">
        <div class="container">
            <div class="row">
                <div id="parentVerticalTab">
                    <h2>Products</h2>
                    <ul class="resp-tabs-list hor_1 col-sm-3 col-md-3 col-lg-3">
                        <li><i class="ti-home"></i> House Insurance</li>
                        <li><i class="fa fa-plane"></i> Travel Insurance</li>
                        <li><i class="ti-heart-broken"></i> Life Insurance</li>
                        <li><i class="ti-car"></i> Car Insurance</li>
                    </ul>
                    <div class="col-sm-5 col-md-5 col-lg-5 resp-tabs-container hor_1">
                        <div>
                            <div class="prod-tab-content">
                                <h4>
                                    <span class="prod-cion"><i class="ti-home"></i></span>
                                    House Insurance
                                </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer</p>
                                <p>et placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. </p>
                                <p class="tel">
                                    <i class="fa fa-phone"></i> +123 456 7890 <span>Toll Free</span>
                                </p>
                                <p>
                                    <a class="btn-default" href="product-houseinsurance.html">Get Free Quote</a>
                                </p>
                            </div>
                            <img src={{URL::asset('index_files/images/product-img.jpg')}} alt="" class="img-responsive" />
                        </div>
                        <div>
                            <div class="prod-tab-content">
                                <h4>
                                    <span class="prod-cion"><i class="fa fa-plane"></i></span>
                                    Travel Insurance
                                </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer</p>
                                <p>et placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. </p>
                                <p class="tel">
                                    <i class="fa fa-phone"></i> +123 456 7890 <span>Toll Free</span>
                                </p>
                                <p>
                                    <a class="btn-default" href="#">Get Free Quote</a>
                                </p>
                            </div>
                            <img src={{URL::asset('index_files/images/1.jpg')}} alt="" class="img-responsive" />
                        </div>
                        <div>
                            <div class="prod-tab-content">
                                <h4>
                                    <span class="prod-cion"><i class="ti-heart-broken"></i></span>
                                    Life Insurance
                                </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer</p>
                                <p>et placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. </p>
                                <p class="tel">
                                    <i class="fa fa-phone"></i> +123 456 7890 <span>Toll Free</span>
                                </p>
                                <p>
                                    <a class="btn-default" href="#">Get Free Quote</a>
                                </p>
                            </div>
                            <img src={{URL::asset('index_files/images/3.jpg')}} alt="" class="img-responsive" />
                        </div>
                        <div>
                            <div class="prod-tab-content">
                                <h4>
                                    <span class="prod-cion"><i class="ti-car"></i></span>
                                    Car Insurance
                                </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer</p>
                                <p>et placerat suscipit. Sed sodales scelerisque commodo. Nam porta cursus lectus. </p>
                                <p class="tel">
                                    <i class="fa fa-phone"></i> +123 456 7890 <span>Toll Free</span>
                                </p>
                                <p>
                                    <a class="btn-default" href="#">Get Free Quote</a>
                                </p>
                            </div>
                            <img src={{URL::asset('index_files/images/2.jpg')}} alt="" class="img-responsive" />
                        </div>
                    </div>
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
