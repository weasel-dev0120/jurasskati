@extends('pages::public.master')

@section('content')

<section class="js-home-section js-home-concept" id="{{ slugify(__('Terms and Conditions')) }}">
    <div class="container">
        <div class="js-editable">
            {!! Blocks::render('terms_conditions') !!}
        </div>
    </div>
</section>

@endsection
