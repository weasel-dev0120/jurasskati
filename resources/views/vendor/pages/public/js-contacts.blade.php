@extends('pages::public.master')

@section('content')

{{--
<section class="js-home-top">
    <div class="js-slider">
        <div class="js-slider-slide active">
            <img class="js-slider-slide-background" src="/images/home-top.jpg" alt="">
            <div class="js-slider-slide-content">
                <div class="container">
                    <div class="row">
                        <div class="col text-right">
                            <h1 class="js-h1">
                                @if ($lang == 'lv')
                                    Sazinieties ar mums
                                @endif
                                @if ($lang == 'en')
                                    Get in touch with us
                                @endif
                                @if ($lang == 'ru')
                                    Связаться с нами
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
--}}
<section class="js-home-section js-contacts-text">
    <div class="container">
        {{--
        <h2 class="js-home-section-heading">
            @if ($lang == 'lv')
                Sazinieties ar mums
            @endif
            @if ($lang == 'en')
                Get in touch with us
            @endif
            @if ($lang == 'ru')
                Связаться с нами
            @endif
            {{--
            @if ($lang == 'lv')
                Kontakti
            @endif
            @if ($lang == 'en')
                Contacts
            @endif
            @if ($lang == 'ru')
                Контакты
            @endif
            -}}
        </h2>
        --}}
        <div class="">
            <br><br>
            <div class="row">
                <div class="col-12 col-md-6 js-editable">
                    {!! Blocks::render('contacts_left') !!}
                    <br>
                </div>
                <div class="col-12 col-md-6 js-editable">
                    {!! Blocks::render('contacts_right') !!}
                </div>
            </div>
        </div>
    </div>
</section>

@if (Contactpersons::published()->count() > 0)
<section class="js-contacts-persons js-home-section">
    <div class="container">
        <!--h2 class="js-contacts-persons-heading js-home-section-heading">
            @if ($lang == 'lv')
                Pārdošanas speciālisti
            @endif
            @if ($lang == 'en')
                Sales managers
            @endif
            @if ($lang == 'ru')
                Менеджеры продаж
            @endif
        </h2-->
        <div class="row">
            @foreach(Contactpersons::published()->get() as $person)
            <div class="col-12 col-sm-6 item">
                <img class="portrait" src="{{ asset('storage/'.$person->image->path) }}" alt="">
                <h3 class="name">{{ $person->title }}</h3>
                <div class="position">{{ $person->position }}</div>
                <div class="phone">
                    <img class="icon" src="/images/contacts-phone.svg" alt="">
                    <a href="tel:{{ $person->phone }}">{{ $person->phone }}</a>
                </div>
                <div class="email">
                    <img class="icon" src="/images/contacts-email.svg" alt="">
                    <a href="mailto:{{ $person->email }}">{{ $person->email }}</a>
                </div>
            </div>
            @endforeach
            <div class="col-12 col-sm-6 item">
            <!--div class="mapouter"><div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=500&amp;height=615&amp;hl=en&amp;q=Universihttps://www.google.com/maps/place/Dubultu+prospekts+101,+J%C5%ABrmala,+LV-2008,+Latvia/@56.9647262,23.7378856,17z/data=!3m1!4b1!4m6!3m5!1s0x46eedd84a6d2e4c7:0x9fc3ce0715a2dced!8m2!3d56.9647262!4d23.7378856!16s%2Fg%2F11q3r7qsn7?entry=ttu&g_ep=EgoyMDI0MTEwNS4wIKXMDSoASAFQAw%3D%3Dty of Oxford&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div><style>.mapouter{position:relative;text-align:right;width:100%;height:600px;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:630px;}.gmap_iframe {height:615px!important;}</style></div-->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2175.0704222998693!2d23.735310677628835!3d56.96472617355689!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eedd84a6d2e4c7%3A0x9fc3ce0715a2dced!2sDubultu%20prospekts%20101%2C%20J%C5%ABrmala%2C%20LV-2008%2C%20Latvia!5e0!3m2!1sen!2sin!4v1731069279844!5m2!1sen!2sin" width="100%" height="615" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        </div>
        
    </div>
</section>
@endif

<section class="js-home-section js-home-contacts">
    <div class="container">
        <h2 class="js-home-section-heading">
            @if ($lang == 'lv')
                Sazinieties ar mums
            @endif
            @if ($lang == 'en')
                Get in touch with us
            @endif
            @if ($lang == 'ru')
                Связаться с нами
            @endif
        </h2>

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
                    <div class="col-md-12 text-center">
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

@endsection
