@extends('pages::public.master')

@section('content')

<section class="js-home-top">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <img class="js-slider-slide-background" src="/images/top-about.jpg" alt="">
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col text-right">
                            <h1 class="js-h1">
                                @if ($lang == 'lv')
                                    Par projektu
                                @endif
                                @if ($lang == 'en')
                                    About The Project
                                @endif
                                @if ($lang == 'ru')
                                    О проекте
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="js-home-section js-home-concept" id="{{ slugify(__('Concept')) }}">
    <div class="container">
        <img class="js-home-concept-image" src="/images/home-concept.jpg" alt="">
        <h2 class="js-home-section-heading">
            @lang('Concept')
        </h2>
        <div class="js-editable">
            {!! Blocks::render('about_concept') !!}
        </div>
        {{--
        <br><br>
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
        <br><br>
        <br>
        <div class="js-editable">
        </div>
        --}}
    </div>
</section>

<div class="js-home-slider">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <img class="js-slider-slide-background" src="/images/juras_skati_sea.jpg" alt="">
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
            @lang('Roof Terrace')
        </h2>
        {!! Blocks::render('about_terrace') !!}
    </div>
</section>

<section class="js-home-section js-home-space" id="{{ slugify(__('Territory')) }}">
    <div class="container">
        <h2 class="js-home-section-heading">
            @lang('Territory')
        </h2>
        <div class="js-editable">
            {!! Blocks::render('about_territory') !!}
        </div>
        {{--
        <div class="js-home-section-readmore">
            <a class="js-readmore" href="#">
                Lasīt vairāk
                <?php include(resource_path('images/readmore.svg')) ?>
            </a>
        </div>
        --}}
        
        <ul class="js-home-space-list">
            <li>
                <img class="icon" src="/images/feat-grill.svg" alt="">
                <h3 class="js-h3">@lang('Grill area')</h3>
                @if ($lang == 'en')
                    <p>Space with modern outdoor cooking equipment.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Telpa ar modernu āra gatavošanas aprīkojumu. </p>
                @endif
                @if ($lang == 'ru')
                    <p>Пространство с современным оборудованием для готовки под открытым небом.</p>
                @endif
            </li>
            <li>
                <img class="icon" src="/images/feat-picnic.svg" alt="">
                <h3 class="js-h3">@lang('Picnic area')</h3>
                @if ($lang == 'en')
                    <p>Arranged areas for unforgettable outdoor recreation.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Ideāli piemērotas ģimenes vakariņām, lasīšanai vai darbam brīvā dabā.</p>
                @endif
                @if ($lang == 'ru')
                    <p>Обустроенные площадки для незабываемого отдыха на природе.</p>
                @endif
            </li>
            <!--li>
                <img class="icon" src="/images/feat-gazebo.svg" alt="">
                <h3 class="js-h3">@lang('Gazebos')</h3>
                @if ($lang == 'en')
                    <p>Great for secluded family meals, reading or working outdoors.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Ideāli piemērotas ģimenes vakariņām, lasīšanai vai darbam brīvā dabā.</p>
                @endif
                @if ($lang == 'ru')
                    <p>Отлично подходят для уединенных семейных трапез, чтения или работы на свежем воздухе.</p>
                @endif
            </li-->
            <li>
                <img class="icon" src="/images/feat-velo.svg" alt="">
                <h3 class="js-h3">@lang('Parking for bycicles')</h3>
                @if ($lang == 'en')
                    <p>Maintain an active lifestyle and take the whole family on bike rides.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Esiet aktīvi un brauciet ar velosipēdu kopā ar ģimeni.</p>
                @endif
                @if ($lang == 'ru')
                    <p>Поддерживайте активный образ жизни и устраивайте велопрогулки всей семьей.</p>
                @endif
            </li>
            <li>
                <img class="icon" src="/images/feat-play.svg" alt="">
                <h3 class="js-h3">@lang('Playground')</h3>
                @if ($lang == 'en')
                    <p>A safe area for play, physical activity and socializing.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Droša zona spēlēm, fiziskām aktivitātēm un socializācijai.</p>
                @endif
                @if ($lang == 'ru')
                    <p>Безопасная зона для игр, физической активности и общения.</p>
                @endif
            </li>
            <!--li>
                <img class="icon" src="/images/feat-charge.svg" alt="">
                <h3 class="js-h3">@lang('Charging station for scooters')</h3>
                @if ($lang == 'en')
                    <p>Electric cars allow you to move around the city comfortably and quickly.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Elektriskie skrejriteņi ļauj ātri un ērti pārvietoties pa pilsētu.</p>
                @endif
                @if ($lang == 'ru')
                    <p>Электромобили позволяют передвигаться по городу удобно и быстро.</p>
                @endif
            </li-->
            <li>
                <img class="icon" src="/images/feat-parking.svg" alt="">
                <h3 class="js-h3">@lang('Parking lot')</h3>
                @if ($lang == 'en')
                    <p>Convenient parking spaces, including charging stations for electric cars.</p>
                @endif
                @if ($lang == 'lv')
                    <p>Ērtas autostāvvietas, tostarp elektromobiļu uzlādes stacijas.</p>
                @endif
                @if ($lang == 'ru')
                    <p>Удобные парковочные места, в том числе с зарядными станциями для электромобилей.</p>
                @endif
            </li>
        </ul>

    </div>
</section>

<div class="js-home-slider">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <img class="js-slider-slide-background" src="/images/about-smarthome.jpg" alt="">
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

<section class="js-home-section js-home-apartments" id="{{ slugify(__('Smart Home')) }}">
    <div class="container">
        <h2 class="js-home-section-heading js-home-apartments-heading">
            @lang('Safety')
        </h2>
        {!! Blocks::render('about_smarthome') !!}
        <br>
        <br>
        <br>
    </div>
</section>

@endsection
