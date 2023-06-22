<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CONTACT US | HALLAK INSURANCE BROKER</title>
    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="css/icons.css" rel="stylesheet" type="text/css">
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
    <div class="breadcrumbs">

        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">

                </div>
            </div>
        </div>
    </div>
        <div class="container">

            <div class="row">

                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-box">
                        <h2>Get in Touch</h2>
                        <div class="form-content">
                            <input type="text" name="name" placeholder="Your Name" />
                            <input type="text" name="email" placeholder="Email" />
                            <input type="text" name="subject" placeholder="Subject" />
                            <textarea rows="1" cols="1" name="message" placeholder="Message"></textarea>
                            <div class="text-center">
                                <input type="submit" class="btn-default" value="Submit" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="contact-info">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="contact-address">
                                    <h3>Address</h3>
                                    <div>
                                        <i class="icon ti-home"></i>
                                        <p>Tripoli
                                            <br/>North Lebanon
                                            <br/>El Sakafi Street</p>
                                        <p class="social">
                                            <a href="https://www.facebook.com/GhassanElHallak"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-instagram"></i></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="contact-dtl">
                                    <h3>Contact Details</h3>
                                    <div>
                                        <i class="icon fa fa-phone"></i>
                                        <p>+961 (70) 424 200</p>
                                    </div>
                                    <div>
                                        <i class="icon ti-email"></i>
                                        <p><a href="#">info@ghallakinsurance.com</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
{{--            <div class="contact-map">--}}
{{--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d235013.52897217585!2d72.43965449510691!3d23.02060002135479!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1474053074398" width="100%" height="260" frameborder="0" style="border:0" allowfullscreen></iframe>--}}
{{--            </div>--}}
        </div>

</div>
<div class="clear"></div>
@include('includes.adminpanel.landingfooter')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js"></script>
<script src={{URL::asset('index_files/js/custom.js')}}></script>
</body>

</html>
