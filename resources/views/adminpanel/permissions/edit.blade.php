@extends('layouts.masteradminpanel')

@section('title')
    {{ trans('cruds.permission.edit') }}
@endsection

@push('css_content')
    @include('includes.adminpanel.userscss')
@endpush

@section('content')

    @include('includes.adminpanel.header')
<div class="container">
<div class="card">
    <div class="card-header">
{{--        <span style="color:black">{{ trans('cruds.permission.edit') }}</span>--}}
{{--        <br><br><h6><a href="{{ route("adminpanel.permissions.index") }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtopermission') }}</a></h6>--}}
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('adminpanel.permissions.index') }}">{{ trans('global.backtopermission') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ trans('cruds.permission.edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("adminpanel.permissions.update", [$permission->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $permission->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
