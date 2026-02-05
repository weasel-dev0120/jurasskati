@extends('core::admin.master')

@section('title', $model->present()->number)

@section('content')

    {!! BootForm::open()->put()->action(route('admin::update-flat', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('flats::admin._form')
    {!! BootForm::close() !!}

@endsection
