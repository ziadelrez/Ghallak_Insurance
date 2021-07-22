<!DOCTYPE html>
<html lang="ar">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Najib Rent A Cars</title>

    <!-- Custom fonts for this template-->
    <link href={{ asset('adminassets/vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href={{ asset('adminassets/css/admin.rtl.css') }} rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    {!! NoCaptcha::renderJs() !!}

</head>

<body class="bg-gradient-danger ">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block ">
                            <div class="p-5">
                            <img src={{ URL::asset('adminassets/img/najibcarlogin.jpg') }} style="width:100%">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome To Login To Dashboard Page !!!!</h1>
                                </div>
                                @include('includes.alerts.errors')
                                @include('includes.alerts.success')
                                <form class="user" method="POST" action="" id="loginform">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control  text-align:center @error('email') is-invalid @enderror" id="exampleInputEmail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control  @error('password') is-invalid @enderror" id="exampleInputPassword" name="password" required autocomplete="current-password" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

{{--                                <div class="g-recaptcha" data-sitekey="6LcQaqUbAAAAAAuBW2Kjok4gzDJP1C5gCYRazNEh"></div>--}}
                                    <div class="{{$errors->has('g-recaptcha-response')? 'has-error' : ''}}">
                                        {!! NoCaptcha::display() !!}
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                <br/>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>

                                <button type="button" class="btn btn-danger btn-user btn-block" onclick="window.location='{{ url("/") }}'">
                                    Cancel Login
                                </button>


                                </form>

                               </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src={{ asset('adminassets/vendor/jquery/jquery.min.js')}}></script>
<script src={{ asset('adminassets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}></script>

<!-- Core plugin JavaScript-->
<script src={{ asset('adminassets/vendor/jquery-easing/jquery.easing.min.js') }}></script>

<!-- Custom scripts for all pages-->
<script src={{ asset('adminassets/js/sb-admin-2.min.js') }}></script>

</body>

</html>
