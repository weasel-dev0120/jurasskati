@extends('pages::public.master')

@section('content')

<section class="js-home-top js-gallery rel">
    <div class="js-slider">
        <div class="js-slider-slide slide active" data-id="intro">
            <aside class="sidebar">
                <h3 class="heading">
                    @if ($lang == 'en')
                        watch<br> galleries
                    @endif
                    @if ($lang == 'lv')
                        skatīties<br> galerijas
                    @endif
                    @if ($lang == 'ru')
                        смотреть<br> галлереи
                    @endif
                </h3>
                <hr>
                <ul class="menu">
                    @foreach (Galleries::published()->get() as $gallery)
                    <li>
                        <a class="js-gallery-selector" href="#" data-target="{{ slugify($gallery->title) }}">
                            {{ $gallery->title }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            <img class="js-slider-slide-background" src="/images/top-gallery.jpg" alt="">
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col text-right">
                            <h1 class="js-h1 d-none d-sm-block">

                                @if ($lang == 'lv')
                                    Pilsētas gars<br> harmoniskā vidē
                                @endif
                                @if ($lang == 'en')
                                    Spirit of the city<br> in a harmonious environment
                                @endif
                                @if ($lang == 'ru')
                                    Дух города<Br> в гармоничной среде
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach (Galleries::published()->get() as $gallery)
        <div class="js-slider-slide slide" data-id="{{ slugify($gallery->title) }}">
            <aside class="sidebar transparent short">
                <?php include(resource_path('images/selector-arrow-left.svg')) ?>
                <ul class="menu">
                    <li>
                        <a class="js-gallery-selector" href="#" data-target="intro">
                            @lang('Back')
                        </a>
                    </li>
                </ul>
            </aside>
            <div class="js-gallery-flickable">
                @foreach ($gallery->files as $file)
                	@php
                		$array = json_decode($file);
                	@endphp
                    <img src="{{ asset('storage/'.$array->path) }}" alt="" class="item">
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        let flickableGalleries = document.querySelectorAll('.js-gallery-flickable');
        if (flickableGalleries) {
            flickableGalleries.forEach((gallery) => {
                new Flickity(gallery, {
                    prevNextButtons: true,
                    pageDots: true,
                });
            });
        }
        let gallerySelectors = document.querySelectorAll('.js-gallery-selector');
        gallerySelectors.forEach((selector) => {
            selector.addEventListener('click', (ev) => {
                ev.preventDefault();
                let targetId = ev.target.dataset.target;
                if ( ! targetId)
                    return;
                let slides = document.querySelectorAll('.js-gallery .slide');
                slides.forEach((slide) => {
                    if (slide.dataset.id == targetId)
                        slide.classList.add('active');
                    else
                        slide.classList.remove('active');
                });
            });
        });
    });
</script>

@endsection
