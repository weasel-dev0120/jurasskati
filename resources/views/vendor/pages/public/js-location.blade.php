@extends('pages::public.master')

@section('content')

<section class="js-home-top">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <img class="js-slider-slide-background" src="/images/top-location-2.jpg" alt="">
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col text-right">
                            <h1 class="js-h1">
                                @if ($lang == 'lv')
                                    Atrašanās vieta
                                @endif
                                @if ($lang == 'en')
                                    Location
                                @endif
                                @if ($lang == 'ru')
                                    Расположение
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="js-home-section js-home-concept" id="{{ slugify(__('Quiet Jurmala')) }}">
    <div class="container">
        <h2 class="js-home-section-heading">
            @lang('Quiet Jurmala')
        </h2>
        <div class="js-editable">
            {!! Blocks::render('location_jurmala') !!}
        </div>
    </div>
</section>

<a name="{{ slugify(__('Transport')) }}"></a>
<a name="{{ slugify(__('Infrastructure')) }}"></a>
<section class="js-location-map">
    <div class="container">
        <hr class="js-location-map-hr">
    </div>

    <div class="js-location-tabs">
        <input id="tab-transport" type="radio" name="tabradio" class="tab-input">
        <input id="tab-infrastructure" type="radio" name="tabradio" class="tab-input" checked>
        <div class="tab-labels container">
            <label for="tab-transport"><h2>{{ __('Transport') }}</h2></label>
            <label for="tab-infrastructure"><h2>{{ __('Infrastructure') }}</h2></label>
        </div>
        <div class="tab-panels">
            <div class="tab-panel panel-transport">
                <img class="js-location-tabs-map" src="/images/map1.jpg" alt="">
                <div class="container">

                    <ul class="js-location-tabs-list-new js-home-space-list">
                        <li>
                            <a href="#{{ slugify(__('Transport')) }}-{{ slugify(__('Pumpuri Railway Station')) }}">
                                <img src="/images/tr-train.svg" alt="" class="icon">
                                @lang('Pumpuri Railway Station')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Transport')) }}-{{ slugify(__('Taxi')) }}">
                                <img src="/images/tr-taxi.svg" alt="" class="icon">
                                @lang('Taxi')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Transport')) }}-{{ slugify(__('Pumpuri Bus Stop')) }}">
                                <img src="/images/tr-bus.svg" alt="" class="icon">
                                @lang('Pumpuri Bus Stop')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Transport')) }}-{{ slugify(__('Car')) }}">
                                <img src="/images/tr-car.svg" alt="" class="icon">
                                @lang('Car')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Transport')) }}-{{ slugify(__('Airport')) }}">
                                <img src="/images/tr-plane.svg" alt="" class="icon">
                                @lang('Airport')
                            </a>
                        </li>
                    </ul>

                    <div class="js-editable js-autoanchors" data-anchor-prefix="{{ slugify(__('Transport')) }}">
                        {!! Blocks::render('location_transport') !!}
                    </div>


                </div>
            </div>
            <div class="tab-panel panel-infrastructure">
                <img class="js-location-tabs-map" src="/images/map2.jpg" alt="">
                <div class="container">

                    <ul class="js-location-tabs-list-new js-home-space-list">
                        <li>
                            <a href="#{{ slugify(__('Infrastructure')) }}-{{ slugify(__('Recreation and Health')) }}">
                                <img src="/images/map-health.svg" alt="" class="icon">
                                @lang('Recreation and Health')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Infrastructure')) }}-{{ slugify(__('Shopping')) }}">
                                <img src="/images/map-shop.svg" alt="" class="icon">
                                @lang('Shopping')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Infrastructure')) }}-{{ slugify(__('Education')) }}">
                                <img src="/images/map-education.svg" alt="" class="icon">
                                @lang('Education')
                            </a>
                        </li>
                        <li>
                            <a href="#{{ slugify(__('Infrastructure')) }}-{{ slugify(__('Restaurants')) }}">
                                <img src="/images/map-catering.svg" alt="" class="icon">
                                @lang('Restaurants')
                            </a>
                        </li>
                    </ul>

                    <div class="js-editable js-autoanchors" data-anchor-prefix="{{ slugify(__('Infrastructure')) }}">
                        {!! Blocks::render('location_infrastructure') !!}
                    </div>

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</section>

@endsection
