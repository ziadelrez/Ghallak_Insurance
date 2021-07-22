<!DOCTYPE html>
<html class="no-js" lang="">
<head>
    <!-- meta charset -->
    <meta charset="utf-8">
    <!-- site title -->
    <title>NAJIB | RENT A CAR</title>
    <!-- meta description -->
    <meta name="description" content="">
    <!-- mobile viwport meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- fevicon -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <!-- ================================
    CSS Files
    ================================= -->
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i|Open+Sans:400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href={{URL::asset('index_files/css/themefisher-fonts.min.css')}}>
    <link rel="stylesheet" href={{URL::asset('index_files/css/owl.carousel.min.css')}}>
    <link rel="stylesheet" href={{URL::asset('index_files/css/bootstrap.min.css')}}>
    <link rel="stylesheet" href={{URL::asset('index_files/css/main.css')}}>
    <link id="color-changer" rel="stylesheet" href={{URL::asset('index_files/css/colors/color-0.css')}}>
</head>

<body>

<div class="preloader">
    <div class="loading-mask"></div>
    <div class="loading-mask"></div>
    <div class="loading-mask"></div>
    <div class="loading-mask"></div>
    <div class="loading-mask"></div>
</div>

<main class="site-wrapper">
    <div class="pt-table">
        <div class="pt-tablecell page-home relative" style="background-image: url({{URL::asset('index_files/img/banner.jpg')}});">
            <div class="overlay"></div>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                        <div class="page-title home text-center">
                            <img src={{URL::asset('index_files/img/logo.png')}} alt="">
                            <p></p>
                        </div>

                        <div class="hexagon-menu clear">
                            {{--About Us--}}
                            <div class="hexagon-item">
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <a href="{{ route('aboutus') }}" class="hex-content">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i class="tf-profile-male"></i>
                                                </span>
                                                <span class="title">About</span>
                                            </span>
                                    <svg viewbox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path></svg>
                                </a>
                            </div>

                            {{--Cars Collections--}}
                            <div class="hexagon-item">
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <a href="{{ route('carscollections') }}" class="hex-content">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i class="tf-ion-android-car"></i>
                                                </span>
                                                <span class="title">Cars Collections</span>
                                            </span>
                                    <svg viewbox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path></svg>
                                </a>
                            </div>

                            {{--Contact Us--}}
                            <div class="hexagon-item">
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <a href="{{ route('contactus') }}" class="hex-content">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i class="tf-envelope2"></i>
                                                </span>
                                                <span class="title">Contact</span>
                                            </span>
                                    <svg viewbox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path></svg>
                                </a>
                            </div>

                            {{--Dashboard--}}
                            <div class="hexagon-item">
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <a href="{{ route('login') }}" class="hex-content">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i class="tf-ion-log-in"></i>
                                                </span>
                                                <span class="title">Log In</span>
                                            </span>
                                    <svg viewbox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path></svg>
                                </a>
                            </div>

                            {{--Our Branches--}}
                            <div class="hexagon-item">
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="hex-item">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <a href="{{ route('branches') }}" class="hex-content">
                                            <span class="hex-content-inner">
                                                <span class="icon">
                                                    <i class="tf-ion-android-pin"></i>
                                                </span>
                                                <span class="title">Our Branches</span>
                                            </span>
                                    <svg viewbox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path></svg>
                                </a>
                            </div>

                        </div> <!-- /.hexagon-menu -->

                    </div> <!-- /.col-xs-12 -->

                </div> <!-- /.row -->
            </div> <!-- /.container -->
            <nav class="page-nav clear">
                <div class="container">
                    <div class="flex flex-middle space-between">
                        <span class="prev-page"><a href="#" class="link"></a></span>
                        <span class="copyright hidden-xs">Copyright © Najib Rent a Car 2021, All Rights Reserved.</span>
                        <span class="next-page"><a href="#" class="link"></a></span>
                    </div>
                </div>
                <!-- /.page-nav -->
            </nav>
        </div> <!-- /.pt-tablecell -->
    </div> <!-- /.pt-table -->
</main> <!-- /.site-wrapper -->

<!-- ================================
JavaScript Libraries
================================= -->
<script src={{URL::asset('index_files/js/vendor/jquery-2.2.4.min.js')}}></script>
<script src={{URL::asset('index_files/js/vendor/bootstrap.min.js')}}></script>
<!-- <script src="js/jquery.easing.min.js"></script> -->
<script src={{URL::asset('index_files/js/isotope.pkgd.min.js')}}></script>
<script src={{URL::asset('index_files/js/jquery.nicescroll.min.js')}}></script>
<script src={{URL::asset('index_files/js/owl.carousel.min.js')}}></script>
<script src={{URL::asset('index_files/js/jquery-validation.min.js')}}></script>
<script src={{URL::asset('index_files/js/form.min.js')}}></script>
<script src={{URL::asset('index_files/js/main.js')}}></script>
</body>
</html>
