@extends('pages::public.master')

@section('page-title')
@if ($lang == 'lv')
<title>Pirkt dzīvokli Jūrmalā – Ekskluzīvi īpašumi pie jūras | Jūras Skati</title>
@endif
@if ($lang == 'en')
<title>Buy an Apartment in Jūrmala – Exclusive Seaside Property | Jūras Skati</title>
@endif
    
@endsection

@section('content')


<?php 
$coverImageUrl = config('typicms.home_cover_image');
if ($coverImageUrl) {
    $coverImageUrl = '/storage/settings/' . config('typicms.home_cover_image');
} else {
    $coverImageUrl = '/images/top-home-2.jpg'; 
}

$introImageUrl = config('typicms.home_intro_image');
if ($introImageUrl) {
    $introImageUrl = '/storage/settings/' . config('typicms.home_intro_image');
} else {
    $introImageUrl = '/images/home-concept.jpg'; 
}
?>

<section class="js-home-top">
    <div class="js-slider">
        <div class="js-slider-slide active">
		<?php
			$title = '';		
			if ($lang == 'lv'){
		            $title="Jūras Skati dzīvojamais komplekss ar skatu uz jūru";		       
		        }if ($lang == 'en'){
		            $title="Jūras Skati residential complex with a sea view";
		            }
                ?>
                {!! picture_source($coverImageUrl, [['(max-width: 414px)', 450, 600], ['(max-width: 1200px)', 1200, 710]]) !!}
                <--img class="js-slider-slide-background" src="{{ resize($coverImageUrl, 1440, 791) }}" srcset="{{ resize($coverImageUrl, 1440, 791, 'webp') }} 1x, {{ resize($coverImageUrl, 2880, 1582, 'webp') }} 2x" alt=""-->
            <--/picture-->
            <video width="100%" class="js-slider-slide-background" title="{{ $title }}"  preload='metadata' height:auto; autoplay muted loop playsinline>
		  <source src="/videos/D101_3in1_AI.mp4" type="video/mp4" />
	    </video>
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col text-right">
                            <h1 class="js-h1">
                                @if ($lang == 'lv')
                                    Moderns dzīvojamais komplekss "Jūras skati"
                                @endif
                                @if ($lang == 'en')
                                    Modern residential complex "Jūras skati"
                                @endif
                                @if ($lang == 'ru')
                                    Современный жилой комплекс «Jūras skati»
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="js-home-section js-home-concept">
    <div class="container">
        <picture>
            {!! picture_source($introImageUrl, [['(max-width: 1200px)', 200, 244]]) !!}
            <img class="js-home-concept-image" src="{{ resize($introImageUrl, 446, 554) }}" srcset="{{ resize($introImageUrl, 446, 554, 'webp') }} 1x, {{ resize($introImageUrl, 892, 1108, 'webp') }} 2x" alt="">
        </picture>
        <h2 class="js-home-section-heading">
            @if ($lang == 'lv')
                Komfortabla un harmoniska dzīve Jūrmalā
            @endif
            @if ($lang == 'en')
                A Life Full of Comfort & Harmony in Jurmala
            @endif
            @if ($lang == 'ru')
                Комфортная и гармоничная жизнь в Юрмале
            @endif
        </h2>
        <div class="js-editable">
            {!! Blocks::render('home_intro') !!}
        </div>
        <div class="row">
            <div class="col-lg-9">
                <ul class="js-home-concept-list">
                    <li>
                        <img class="icon" src="/images/home-eco.svg" alt="">
                        @lang('Clean and healthy environment')
                    </li>
                    <li>
                        <img class="icon" src="/images/home-picturesque.svg" alt="">
                        @lang('Scenic coastal nature')
                    </li>
                    <li>
                        <img class="icon" src="/images/home-views.svg" alt="">
                        @lang('Stunning views')
                    </li>
                    <li>
                        <img class="icon" src="/images/home-prestige.svg" alt="">
                        @lang('Prestige of living in the main Baltic resort city')
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 text-center text-lg-right align-self-center">
                <img src="/images/home-concept-drawing.svg" alt="" class="js-home-concept-drawing">
            </div>
        </div>
    </div>
</section>

<div class="js-home-section js-home-values">
    <div class="container">
        <h2 class="js-home-section-heading">
            @lang('Our values:')
        </h2>
        <ul class="js-home-values-list">
            <li>
                <img class="icon" src="/images/values-family.svg" alt="">
                @lang('Family')
            </li>
            <li>
                <img class="icon" src="/images/values-security.svg" alt="">
                @lang('Safety')
            </li>
            <li>
                <img class="icon" src="/images/values-technology.svg" alt="">
                @lang('Innovations')
            </li>
            <li>
                <img class="icon" src="/images/values-ecology.svg" alt="">
                @lang('Eco-friendliness')
            </li>
            <li>
                <img class="icon" src="/images/values-efficiency.svg" alt="">
                @lang('Energy efficiency')
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>


<div class="js-home-gradient">
    <section class="js-home-section js-home-jurmala">
        <div class="container">
        <picture>
            {!! picture_source('/images/home-jurmala.jpg', [['(max-width: 1200px)', 210, 283]]) !!}
            <img class="js-home-jurmala-image" src="{{ resize('/images/home-jurmala.jpg', 446, 600) }}" srcset="{{ resize('/images/home-jurmala.jpg', 446, 600, 'webp') }} 1x, {{ resize('/images/home-jurmala.jpg', 892, 1200, 'webp') }} 2x" alt="">
        </picture>
            <h2 class="js-home-section-heading js-home-jurmala-heading">
                @lang('Quiet Jurmala')
            </h2>
            <div class="js-editable">
                {!! Blocks::render('home_jurmala') !!}
            </div>
            {{--
            <div class="js-home-section-readmore">
                <a class="js-readmore" href="#">
                    {{ __('Read more') }}
                    <?php include(resource_path('images/readmore.svg')) ?>
                </a>
            </div>
            --}}
        </div>
    </section>

    <div class="clearfix"></div>

    <section class="js-home-section js-home-space">
        <div class="container">
            <h2 class="js-home-section-heading">
                @if ($lang == 'lv')
                    Telpa
                @endif
                @if ($lang == 'en')
                    Features
                @endif
                @if ($lang == 'ru')
                    Территория
                @endif
            </h2>
            <div class="js-editable">
                {!! Blocks::render('home_features') !!}
            </div>
            
            <ul class="js-home-space-list">
                <li>
                    <img class="icon" src="/images/feat-lobby.svg" alt="">
                    @lang('Lobby')
                </li>
                <li>
                    <img class="icon" src="/images/feat-grill.svg" alt="">
                    @lang('Grill area')
                </li>
                <li>
                    <img class="icon" src="/images/feat-picnic.svg" alt="">
                    @lang('Picnic area')
                </li>
                <!--li>
                    <img class="icon" src="/images/feat-gazebo.svg" alt="">
                    @lang('Gazebos')
                </li-->
                <li>
                    <img class="icon" src="/images/feat-velo.svg" alt="">
                    @lang('Parking for bycicles')
                </li>
                <li>
                    <img class="icon" src="/images/feat-play.svg" alt="">
                    @lang('Playground')
                </li>
                <!--li>
                    <img class="icon" src="/images/feat-charge.svg" alt="">
                    @lang('Charging station for scooters')
                </li-->
                <li>
                    <img class="icon" src="/images/feat-parking.svg" alt="">
                    @lang('Parking lot')
                </li>
            </ul>
    
        </div>
    </section>
</div>

<div class="js-home-slider">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <picture>
                {!! picture_source('/images/juras_skati_sea.jpg', [['(max-width: 414px)', 414, 144], ['(max-width: 1200px)', 1200, 417]]) !!}
                <?php
			$title1 = '';		
			if ($lang == 'lv'){
		            $title1="Jūras Skati jumta terase ar skatu uz saulrietu";		       
		        }if ($lang == 'en'){
		            $title1="Jūras Skati rooftop terrace with sunset view";
		            }
                ?>
                <img class="js-slider-slide-background" src="{{ resize('/images/juras_skati_sea.jpg', 1440, 500) }}" srcset="{{ resize('/images/juras_skati_sea.jpg', 1440, 500, 'webp') }} 1x, {{ resize('/images/juras_skati_sea.jpg', 2880, 1000, 'webp') }} 2x" alt="{{ $title1 }}">
            </picture>
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="js-home-section js-home-terrace">
    <div class="container">
        <h2 class="js-home-section-heading js-home-terrace-heading">
            @lang('Rooftop Terrace')
        </h2>
        {!! Blocks::render('home_terrace') !!}
    </div>
</section>

<div class="js-home-slider">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <picture>
                {!! picture_source('/images/home-apartments.jpg', [['(max-width: 414px)', 414, 144], ['(max-width: 1200px)', 1200, 417]]) !!}
                <img class="js-slider-slide-background" src="{{ resize('/images/home-apartments.jpg', 1440, 500) }}" srcset="{{ resize('/images/home-apartments.jpg', 1440, 500, 'webp') }} 1x, {{ resize('/images/home-apartments.jpg', 2880, 1000, 'webp') }} 2x" alt="">
            </picture>
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="js-home-section js-home-apartments">
    <div class="container">
        <h2 class="js-home-section-heading js-home-apartments-heading">
            @lang('Flats')
        </h2>
        {!! Blocks::render('home_apartments') !!}
        {{--
        <div class="js-home-section-readmore">
            <a class="js-readmore" href="#">
                {{ __('Read more') }}
                <?php include(resource_path('images/readmore.svg')) ?>
            </a>
        </div>
        --}}
    </div>
</section>
<section class="js-home-section js-home-lofts">
    <div class="container">
        <h2 class="js-home-section-heading">
            @if ($lang == 'lv')
                Lofti
            @endif
            @if ($lang == 'en')
                Lofts
            @endif
            @if ($lang == 'ru')
                Лофты
            @endif
        </h2>
        {!! Blocks::render('home_lofts') !!}
        {{--
        <div class="js-home-section-readmore">
            <a class="js-readmore" href="#">
                {{ __('Read more') }}
                <?php include(resource_path('images/readmore.svg')) ?>
            </a>
        </div>
        --}}
</section>
<section class="js-home-section js-home-smart">
    <div class="container">
        <!-- <h2 class="js-home-section-heading">
            @lang('Smart Home')
        </h2>
        {!! Blocks::render('home_smart') !!} -->

        <div class="js-home-smart-list">
            <li>
                <img class="icon" src="/images/home-energy.svg" alt="">
                <h3>@lang('Energy efficiency')</h3>
                <p style="text-align:left;">@lang('Low utility bills.')</p>
            </li>
            <li>
                <img class="icon" src="/images/home-climate.svg" alt="">
                <h3>@lang('Flexible climate control')</h3>
                <p style="text-align:left;">@lang('Comfortable temperature in every room.')</p>
            </li>
            <li>
                <img class="icon" src="/images/home-security.svg" alt="">
                <h3>@lang('Security')</h3>
                <p style="text-align:left;">@lang('Keyless entry system and 24-hour video surveillance.')</p>
            </li>
        </div>

        {{--
        <div class="js-home-section-readmore">
            <a class="js-readmore" href="#">
                {{ __('Read more') }}
                <?php include(resource_path('images/readmore.svg')) ?>
            </a>
        </div>
        --}}
    </div>
</section>

<div class="js-home-slider">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <picture>
                {!! picture_source('/images/home-slider3.jpg', [['(max-width: 414px)', 414, 144], ['(max-width: 1200px)', 1200, 417]]) !!}
                <img class="js-slider-slide-background" src="{{ resize('/images/home-slider3.jpg', 1440, 500) }}" srcset="{{ resize('/images/home-slider3.jpg', 1440, 500, 'webp') }} 1x, {{ resize('/images/home-slider3.jpg', 2880, 1000, 'webp') }} 2x" alt="">
            </picture>
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="js-home-gradient2">
    <section class="js-home-section js-home-infrastructure">
        <div class="container">
    
            <h1 class="js-home-section-heading js-home-infrastructure-heading">
                @lang('Infrastructure')
            </h1>

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

            <div class="d-block d-md-none">
                <br>
                <br>
            </div>

            <div class="js-editable js-autoanchors" data-anchor-prefix="{{ slugify(__('Infrastructure')) }}">
                {!! Blocks::render('home_infrastructure') !!}
            </div>
    
            {{--
            <ul class="js-home-infrastructure-list">
                <li>
                    <img class="icon" src="/images/home-beach.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Pludmale</h3>
                        350 метров. 5 минут пешком по прямой.
                    @endif
                    @if ($lang == 'en')
                        <h3>Beach</h3>
                        350 метров. 5 минут пешком по прямой.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Пляж</h3>
                        350 метров. 5 минут пешком по прямой.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-school.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Pumpuru vidusskola</h3>
                        450 метров. 6 минут пешком.
                    @endif
                    @if ($lang == 'en')
                        <h3>Pumpuri Secondary School</h3>
                        450 метров. 6 минут пешком.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Средняя школа «Пумпури»</h3>
                        450 метров. 6 минут пешком.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-preschool.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Bērnudārzs “Namiņš”</h3>
                        550 метров. 7 минут пешком.
                    @endif
                    @if ($lang == 'en')
                        <h3>"Namiņš" Kindergarten</h3>
                        550 метров. 7 минут пешком.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Детский сад «Наминьш»</h3>
                        550 метров. 7 минут пешком.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-basket.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Veikals Rimi Mini</h3>
                        1,9 километра. 3 минуты на автомобиле.
                    @endif
                    @if ($lang == 'en')
                        <h3>Rimi Mini store</h3>
                        1,9 километра. 3 минуты на автомобиле.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Супермаркет Rimi Mini</h3>
                        1,9 километра. 3 минуты на автомобиле.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-cart.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Lielveikali Rimi un Maxima XX</h3>
                        7.7 километра. 10 минут на автомобиле.
                    @endif
                    @if ($lang == 'en')
                        <h3>Rimi and Maxima XX Supermarkets</h3>
                        7.7 километра. 10 минут на автомобиле.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Супермаркеты Rimi и Maxima XX</h3>
                        7.7 километра. 10 минут на автомобиле.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-gas.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Circle K degvielas uzpildes stacija</h3>
                        900 метров. 1 минута на автомобиле.
                    @endif
                    @if ($lang == 'en')
                        <h3>Circle K Gas Station</h3>
                        900 метров. 1 минута на автомобиле.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Автозаправочная станция Circle K</h3>
                        900 метров. 1 минута на автомобиле.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-music.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Mellužu estrāde</h3>
                        700 метров. 8 минут пешком.
                    @endif
                    @if ($lang == 'en')
                        <h3>Melluzi Open Air Stage & Park</h3>
                        700 метров. 8 минут пешком.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Эстрада «Меллужи»</h3>
                        700 метров. 8 минут пешком.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-coffee.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Kafejnīca “Madam Brioš”</h3>
                        650 метров. 8 минут пешком.
                    @endif
                    @if ($lang == 'en')
                        <h3>"Madam Brioš" Cafe</h3>
                        650 метров. 8 минут пешком.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Кафе «Мадам Бриош»</h3>
                        650 метров. 8 минут пешком.
                    @endif
                </li>
    
                <li>
                    <img class="icon" src="/images/home-rehab.svg" alt="">
                    @if ($lang == 'lv')
                        <h3>Rehabilitācijas centrs “Vaivari”</h3>
                        5.1 километра. 8 минут на автомобиле.
                    @endif
                    @if ($lang == 'en')
                        <h3>Vaivari National Rehabilitation Centre</h3>
                        5.1 километра. 8 минут на автомобиле.
                    @endif
                    @if ($lang == 'ru')
                        <h3>Реабилитационный центр «Вайвари»</h3>
                        5.1 километра. 8 минут на автомобиле.
                    @endif
                </li>
            </ul>
            --}}

        </div>
    </section>

    <section class="js-home-section js-home-contacts">
        <div class="container">
            <h2 class="js-home-section-heading">
                @lang('Contacts')
            </h2>
            <div style=""></div>

            <div class="js-contactform">
                <form action="{{ route('submit_contact_form') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="element">
                                <input id="name" 
                                    type="text" 
                                    name="name" 
                                    placeholder="@lang('Your name')"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="element">
                                <input id="email" 
                                    type="email" 
                                    name="email" 
                                    placeholder="@lang('Your email')"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="element">
                                <textarea id="message" 
                                    name="message" 
                                    placeholder="@lang('Your message')"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit">@lang('Ask a question')</button>
                        </div>
                        <div class="col-12">
                            <div class="message success d-none">@lang('Thank you! Your message has been sent.')</div>
                            <div class="message error user d-none">@lang('There was an error with your message! Please, check the values and try again.')</div>
                            <div class="message error server d-none">@lang('There was a server error! Please, try again later.')</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

