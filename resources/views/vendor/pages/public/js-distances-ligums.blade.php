@extends('pages::public.master')

@section('content')

<section class="js-home-section js-home-concept" id="{{ slugify(__('Distances ligums')) }}">
    <div class="container">
        <div class="js-editable">
            {!! Blocks::render('distances-ligums') !!}
        </div>
    </div>
</section>

@endsection
