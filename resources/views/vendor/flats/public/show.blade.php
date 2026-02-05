@extends('core::public.master')

@section('title', $model->title.' – '.__('Flats').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->image(1200, 630))
@section('bodyClass', 'body-flats body-flat-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

<article class="flat">
    <header class="flat-header">
        <div class="flat-header-container">
            <div class="flat-header-navigator">
                @include('core::public._items-navigator', ['module' => 'Flats', 'model' => $model])
            </div>
            <h1 class="flat-title">{{ $model->title }}</h1>
        </div>
    </header>
    <div class="flat-body">
        @include('flats::public._json-ld', ['flat' => $model])
        @empty(!$model->summary)
        <p class="flat-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->image)
        <picture class="flat-picture">
            <img class="flat-picture-image" src="{{ $model->present()->image(2000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="">
            @empty(!$model->image->description)
            <legend class="flat-picture-legend">{{ $model->image->description }}</legend>
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
