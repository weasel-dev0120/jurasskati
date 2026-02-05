@extends('core::admin.master')

@section('title', __('New contactperson'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-contactpersons'))->multipart()->role('form') !!}
        @include('contactpersons::admin._form')
    {!! BootForm::close() !!}

@endsection
