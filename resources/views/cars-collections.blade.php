<!DOCTYPE html>
<html class="no-js" lang="">
<head>
    <!-- meta charset -->
    <meta charset="utf-8">
    <!-- site title -->
    <title>NAJIB | CARS COLLECTIONS</title>
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
        <div class="pt-tablecell page-works relative">
            <!-- .close -->
            <a href="./" class="page-close"><i class="tf-ion-close">    </i></a>
            <!-- /.close -->

            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                        <div class="page-title text-center">
                            <h2>Our <span class="primary">Cars Collections</span> <span class="title-bg">Cars</span></h2>
                            <p>Find Bellow And Dont Hesitate <br>
                                To Call Us On : 03 540 540 <br>
                                to Choose A Car From Our Collections.</p>
                        </div>
                    </div>
                </div> <!-- /.row -->

                <div class="row">
                    <div class="col-xs-12">
                        <ul class="filter list-inline">
                            <li><a href="#" class="active" data-filter="*">All</a></li>
                            @foreach($carstype as $ctype)
                                <li><a href="#" data-filter=".{{$ctype->id}}">{{$ctype->Description}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row isotope-gutter">
                    @foreach($carslist as $clist)
                        <div class="col-xs-12 col-sm-6 col-md-4 {{$clist->cartypeid}}">
                            <figure class="works-item">
                                <img src="{{asset('/files/cars/'. $clist->carid . '/' . $clist->img_filename)}}" alt="">
                                <div class="overlay"></div>
                                <figcaption class="works-inner">
                                    <h4>{{$clist->carname}}</h4>
                                    <p>{{$clist->enginetype}} - {{$clist->carcolor}}, {{$clist->caryear}}
                                        <br>
                                        <i class="tf-ion-fork-repo"></i> {{$clist->trasnmission}} ,  {{$clist->carrate}}  {{$clist->curr}} per day<br>

                                       <i class="tf-ion-android-people"></i> Passengers : {{$clist->passenger}}<br>
                                        <i class="tf-ion-bag"></i> Bags : {{$clist->bags}}<br>
                                           <i class="tf-ion-social-windows"></i> Doors : {{$clist->doors}}</p>

                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
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
            <!-- /.container -->

        </div> <!-- /.pt-tablecell -->
    </div> <!-- /.pt-table -->
</main> <!-- /.site-wrapper -->

<!-- ================================
JavaScript Libraries
================================= -->
<script src={{URL::asset('index_files/js/vendor/jquery-2.2.4.min.js')}}></script>
<script src={{URL::asset('index_files/js/vendor/bootstrap.min.js')}}></script>
<script src={{URL::asset('index_files/js/jquery.easing.min.js')}}></script>
<script src={{URL::asset('index_files/js/isotope.pkgd.min.js')}}></script>
<script src={{URL::asset('index_files/js/jquery.nicescroll.min.js')}}></script>
<script src={{URL::asset('index_files/js/owl.carousel.min.js')}}></script>
<script src={{URL::asset('index_files/js/jquery-validation.min.js')}}></script>
<script src={{URL::asset('index_files/js/form.min.js')}}></script>
<script src={{URL::asset('index_files/js/main.js')}}></script>
</body>
</html>
