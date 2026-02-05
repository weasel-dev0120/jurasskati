@extends('core::public.master')

@section('title', $model->title.' – '.__('Contactpersons').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->image(1200, 630))
@section('bodyClass', 'body-contactpersons body-contactperson-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

<article class="contactperson">
    <header class="contactperson-header">
        <div class="contactperson-header-container">
            <div class="contactperson-header-navigator">
                @include('core::public._items-navigator', ['module' => 'Contactpersons', 'model' => $model])
            </div>
            <h1 class="contactperson-title">{{ $model->title }}</h1>
        </div>
    </header>
    <div class="contactperson-body">
        @include('contactpersons::public._json-ld', ['contactperson' => $model])
        @empty(!$model->summary)
        <p class="contactperson-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->image)
        <picture class="contactperson-picture">
            <img class="contactperson-picture-image" src="{{ asset('storage/'.$model->image->path) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="">
            @empty(!$model->image->description)
            <legend class="contactperson-picture-legend">{{ $model->image->description }}</legend>
            @endempty
        </picture>
        @endempty
        @empty(!$model->body)
        <div class="rich-content">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._document-list')
        @include('files::public._image-list')
    </div>
</article>

@endsection
