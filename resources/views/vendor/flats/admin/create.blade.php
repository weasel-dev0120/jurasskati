@extends('core::admin.master')

@section('title', __('New flat'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-flats'))->multipart()->role('form') !!}
        @include('flats::admin._form')
    {!! BootForm::close() !!}

@endsection
