<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        @yield('title')
    </title>

    <link href={{ URL::asset('adminassets/vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link href={{ URL::asset('adminassets/css/admin.rtl.css') }} rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">



@stack('css_content')

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('includes.adminpanel.slider')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        @yield('content')

        <input id="del_msg" type="hidden" value="{{trans('global.DELETE_MESSAGE')}}">
        <input id="CONFIRM" type="hidden" value="{{trans('global.CONFIRM')}}">
        <input id="YES" type="hidden" value="{{trans('global.YES')}}">
        <input id="CANCEL" type="hidden" value="{{trans('global.CANCEL')}}">
        <input id="deleteconfid" type="hidden" name="deleteconfid" value="{{ trans('validation.deleteconfirmation.delete_confirmation') }}">
        <!-- End of Main Content -->

        <!-- Footer -->
    @include('includes.adminpanel.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Modal -->
<div class="modal fade" id="exampleModal"
     tabindex="-1"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-10">
                        <h5 class="modal-title"
                            id="exampleModalLabel">
                            {{trans('global.confirmation')}}
                        </h5>
                    </div>

                    <div class="col-md-2">
                        <button type="button"
                                class="close float-right"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>
                </div>



            </div>

            <div class="modal-body">
                <h6 id="modal_body"></h6>

            </div>
        </div>
    </div>
</div>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('global.titlelogout') }}</h5>
{{--                <button class="close" type="button" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">×</span>--}}
{{--                </button>--}}
            </div>
            <div class="modal-body">{{ trans('global.msglogout') }}</div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">{{ trans('global.cancellogout') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" >{{ trans('global.logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>


<script src={{ URL::asset('adminassets/vendor/jquery/jquery.min.js') }}></script>
<script src={{ URL::asset('adminassets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
<script src={{ URL::asset('adminassets/vendor/chart.js/Chart.min.js') }}></script>
<script src={{ URL::asset('adminassets/vendor/jquery-easing/jquery.easing.min.js') }}></script>
<script src={{ URL::asset('adminassets/js/sb-admin-2.min.js') }}></script>
<script src={{ URL::asset('adminassets/js/custom/checkbox-toggle.js') }}></script>
<script src={{ URL::asset('adminassets/js/custom/lbl-tables.js') }}></script>
<script src={{ URL::asset('adminassets/js/custom/validation_elements.js') }}></script>
<script src={{ URL::asset('adminassets/js/demo/chart-area-demo.js') }}></script>
<script src={{ URL::asset('adminassets/js/demo/chart-pie-demo.js') }}></script>
<script src="{{ URL::asset('adminassets/vendor/bootbox/bootbox.min.js') }}" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

<script src="{{ URL::asset('js/main.js') }}"></script>

{{--<script>--}}
{{--    $(function() {--}}
{{--        let languages = {--}}
{{--            'ara': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'--}}
{{--        };--}}
{{--       });--}}

{{--</script>--}}

@stack('js_content')

</body>

</html>
