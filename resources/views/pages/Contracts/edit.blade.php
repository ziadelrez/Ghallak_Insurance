@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.contract.titleupdate') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
@endpush

@section('content')

    @include('includes.adminpanel.header')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="breadcrumbs">

        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">

                </div>
            </div>
        </div>
    </div>
    <div class="content mt-1">
        <div class="animated fadeIn">

        <div class="container">
            <form class="needs-validation" novalidate method="POST" action="{{ route('contract-details.update',$contractdetails[0]->id)}}" >
                {{--                {{ csrf_field() }}--}}
                <input id="flag" type="hidden" name="flag" value="{{$flag}}">
                <input id="contid" type="hidden" name="contid" value="{{$contractdetails[0]->cont}}">
                <input id="contdetid" type="hidden" name="contdetid" value="{{$contractdetails[0]->id}}">

                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-contract.contract.updatecontract')}} - {{ trans('page-contract.contract.titlecard') }}</strong>
                            </div>

                            <!-- Credit Card -->
                            <div id="pay-invoice">
                                <div class="card-body">

                                    {{--##Code Insurance --}}


                                    {{--##Code Insurance & Follow Person--}}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="ccode" class="control-label mb-1">{{trans('page-client.clients.fields.ccode')}}</label>
                                                <input id="ccode" name="ccode" type="text"
                                                       class="form-control middle-name valid"
                                                       value="{{$contractdetails[0]->ccode}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.clients.ccode_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group" data-label="12">
                                                <label class="required" class="control-label col-sm-4" for="followby">{{trans('page-contract.contract.fields.followby')}}</label>
                                                <select id="followby" name="followby" class="form-control p selectionfollowby"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($followlist as $flist)
                                                        @if($flist -> id == $contractdetails[0]->followby)
                                                            <option selected
                                                                    value="{{$flist -> id}}">{{$flist -> Description}}</option>
                                                        @else
                                                            <option
                                                                value="{{$flist -> id}}">{{$flist -> Description}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.followby_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##Select Company & Insurance Name--}}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group" data-label="1">
                                                <label class="required" class="control-label col-sm-4" for="compname">{{trans('page-contract.contract.fields.compname')}}</label>
                                                <select id="compname" name="compname" class="form-control p selectioncompname"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($companieslist as $colist)
                                                        @if($colist -> id == $contractdetails[0]->companyid)
                                                            <option selected
                                                                    value="{{$colist -> id}}">{{$colist -> compname}}</option>
                                                        @else
                                                            <option
                                                                value="{{$colist -> id}}">{{$colist -> compname}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.compname_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group" data-label="2">
                                                <label class="required" class="control-label col-sm-4" for="insname">{{trans('page-contract.contract.fields.insname')}}</label>
                                                <select id="insname" name="insname" class="form-control p "
                                                        aria-required="true" aria-invalid="false" required>


                                                </select>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.insname_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##Select Car--}}
                                    <div class="form-group" data-label="1">
                                        <label class="required" class="control-label col-sm-4" for="carname">{{trans('page-contract.contract.fields.carname')}}</label>
                                        <select id="carname" name="carname" class="form-control p selectioncarname"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($carslist as $carlist)
                                                @if($carlist -> id == $contractdetails[0]->carid)
                                                    <option selected
                                                            value="{{$carlist -> id}}">{{$carlist -> carname}} - {{$carlist -> platnumber}}</option>
                                                @else
                                                    <option
                                                        value="{{$carlist -> id}}">{{$carlist -> carname}} - {{$carlist -> platnumber}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.contractsdet.carname_required')}}
                                        </div>
                                    </div>

                                    {{--##Select Maids--}}
                                    <div class="form-group" data-label="100">
                                        <label class="required" class="control-label col-sm-4" for="maidname">{{trans('page-contract.contract.fields.maidname')}}</label>
                                        <select id="maidname" name="maidname" class="form-control p selectionmaid"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($maidslist as $mlist)
                                                @if($mlist -> id == $contractdetails[0]->maidid)
                                                    <option selected
                                                            value="{{$mlist -> id}}">{{$mlist -> maidname}} - {{$mlist -> passport}}</option>
                                                @else
                                                    <option
                                                        value="{{$mlist -> id}}">{{$mlist -> maidname}} - {{$mlist -> passport}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            {{trans('validation.contractsdet.maidname_required')}}
                                        </div>
                                    </div>

                                    {{--##Sdate & Edate--}}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="sdate"
                                                       class="control-label mb-1">{{trans('page-contract.contract.fields.sdate')}}</label>
                                                <input id="sdate" name="sdate" type="date"
                                                       class="form-control sdate valid"
                                                       value="{{$contractdetails[0]->sdate}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.sdate_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="edate"
                                                       class="control-label mb-1">{{trans('page-contract.contract.fields.edate')}}</label>
                                                <input id="edate" name="edate" type="date"
                                                       class="form-control edate valid"
                                                       value="{{$contractdetails[0]->edate}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.edate_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##Days & Totalcost--}}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="days" class="control-label mb-1">{{trans('page-contract.contract.fields.days')}}</label>
                                                <input id="days" name="days" type="number"
                                                       class="form-control days valid" value="{{$contractdetails[0]->days}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.days_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="totalcost" class="control-label mb-1">{{trans('page-contract.contract.fields.totalcost')}}</label>
                                                <input id="totalcost" name="totalcost" type="number"
                                                       class="form-control totalcost valid" value="{{$contractdetails[0]->totalcost}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.totalcost_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--## Country--}}
                                    <div class="form-group" data-label="8">
                                        <label class="required" class="control-label col-sm-4" for="country">{{trans('page-contract.contract.fields.country')}}</label>
                                        <select id="country" name="country" class="form-control p selectioncountry"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($countrylist as $rlist)
                                                @if($rlist -> id == $contractdetails[0]->country)
                                                    <option selected
                                                            value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                                @else
                                                    <option
                                                        value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.contracts.country_required')}}
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div> <!-- .card -->

                    </div><!--/.col-->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-contract.contract.shares')}}</strong>
                            </div>
                            <div class="card-body">


                                {{--## Iqar & Employee Number--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label for="iqar" class="control-label mb-1">{{ trans('page-contract.contract.fields.iqar') }}</label>
                                            <input id="iqar" name="iqar" type="text"
                                                   class="form-control iqar valid" value="{{$contractdetails[0]->iqar}}" >
                                        </div>
                                        <div class="invalid-feedback">
                                            {{trans('validation.contractsdet.iqar_required')}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="employeenum" class="control-label mb-1">{{trans('page-contract.contract.fields.employeenum')}}</label>
                                            <input id="employeenum" name="employeenum" type="number"
                                                   class="form-control employeenum valid" value="{{$contractdetails[0]->employeenum}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.employeenum_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{--##Iqar place--}}
                                <div class="form-group has-success">
                                    <label class="required" for="iqarplace" class="control-label mb-1">{{ trans('page-contract.contract.fields.iqarplace') }}</label>
                                    <input id="iqarplace" name="iqarplace" type="text"
                                           class="form-control iqarplace valid" value="{{$contractdetails[0]->iqarplace}}" required>
                                    <div class="invalid-feedback">
                                        {{trans('validation.contractsdet.iqarplace_required')}}
                                    </div>
                                </div>

                                {{--##Office & Officeper & Office Share--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="4">
                                            <label class="required" class="control-label col-sm-4" for="office">{{trans('page-contract.contract.fields.office')}}</label>
                                            <select id="office" name="office" class="form-control p selectionoffice"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($officelist as $olist)
                                                    @if($olist -> id == $contractdetails[0]->officeid)
                                                        <option selected
                                                                value="{{$olist -> id}}">{{$olist -> cname}}</option>
                                                    @else
                                                        <option
                                                            value="{{$olist -> id}}">{{$olist -> cname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.office_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="officeper" class="control-label mb-1">{{trans('page-contract.contract.fields.officeper')}}</label>
                                            <input id="officeper" name="officeper" type="text"
                                                   class="form-control officeper valid" value="{{$contractdetails[0]->officeper}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.officeper_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="officeshare" class="control-label mb-1">{{trans('page-contract.contract.fields.officeshare')}}</label>
                                            <input id="officeshare" name="officeshare" type="text"
                                                   class="form-control officeshare valid" value="{{$contractdetails[0]->officeshare}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.officeshare_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--##Broker & Brokerper & Broker Share--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="5">
                                            <label class="required" class="control-label col-sm-4" for="broker">{{trans('page-contract.contract.fields.broker')}}</label>
                                            <select id="broker" name="broker" class="form-control p selectionbroker"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($brokerlist as $blist)
                                                    @if($blist -> id == $contractdetails[0]->brokerid)
                                                        <option selected
                                                                value="{{$blist -> id}}">{{$blist -> cname}}</option>
                                                    @else
                                                        <option
                                                            value="{{$blist -> id}}">{{$blist -> cname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.broker_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="brokerper" class="control-label mb-1">{{trans('page-contract.contract.fields.brokerper')}}</label>
                                            <input id="brokerper" name="brokerper" type="text"
                                                   class="form-control brokerper valid" value="{{$contractdetails[0]->brokerper}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.brokerper_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="brokershare" class="control-label mb-1">{{trans('page-contract.contract.fields.brokershare')}}</label>
                                            <input id="brokershare" name="brokershare" type="text"
                                                   class="form-control brokershare valid" value="{{$contractdetails[0]->brokershare}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.brokershare_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                {{--##Total & Currency--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="netcost" class="control-label mb-1">{{trans('page-contract.contract.fields.netcost')}}</label>
                                            <input id="netcost" name="netcost" type="text"
                                                   class="form-control netcost valid" value="{{$contractdetails[0]->netcost}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.netcost_required')}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="6">
                                            <label class="required" class="control-label col-sm-4" for="curr">{{trans('page-contract.contract.fields.curr')}}</label>
                                            <select id="curr" name="curr" class="form-control p "
                                                    aria-required="true" aria-invalid="false" required>

                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.curr_required')}}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{--##Stop Cont--}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <input name="stopcont" id="stopcont" type="checkbox"
                                                   @if(isset($contractdetails[0]->stopcont))
                                                   {!!  $contractdetails[0]->stopcont ? "checked" : ""!!}
                                                   @endif;
                                                   class="switchery">
                                            <label for="stopcont" class="card-title ">{{trans('page-contract.contract.fields.stopcont')}} </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <a class="btn btn-success btn-block" id="calculate_btn" href="javascript:;">
                                                    {{ trans('global.calculateins') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block" type="submit" id="btn_save">
                                                    {{ trans('global.saveins') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <a class="btn btn-danger btn-block" href="{{ route('contract-details',$contractdetails[0]->cont)}}">
                                                    {{ trans('global.cancelins') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </form>
        </div>
        </div><!-- .animated -->
        <div class="hide" id="hidden-values">
            <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEFCONT')}}">
            <input id="deposit_id_lbl" type="hidden" value="{{ trans('page-contract.contract.fields.deposit')}}">
            {{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
            {{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
            {{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
            {{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
        </div>
    </div><!-- .content -->

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/newcontractdet.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush



