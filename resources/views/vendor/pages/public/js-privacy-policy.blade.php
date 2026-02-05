@extends('pages::public.master')

@section('content')

<section class="js-home-section js-home-concept" id="{{ slugify(__('Privacy Policy')) }}">
    <div class="container">
        <div class="js-editable">
            {!! Blocks::render('privacy_policy') !!}
        </div>
    </div>
</section>

@endsection
