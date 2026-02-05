@extends('core::admin.master')

@section('title', __('New gallery'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-galleries'))->multipart()->role('form') !!}
        @include('galleries::admin._form')
    {!! BootForm::close() !!}

@endsection
