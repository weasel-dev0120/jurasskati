<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
<!-- Start cookieyes banner --> <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/1136c60aa013bbe0e523fe59/script.js"></script> <!-- End cookieyes banner -->
	
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-9L3GJNX3NB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-9L3GJNX3NB');
</script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    	@section('page-title')
    		<title>{{ $page->title.' – '.$websiteTitle }}</title>
	@show
    
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">

    <meta property="og:site_name" content="{{ $websiteTitle }}">
    <meta property="og:title" content="{{ $page->title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ URL::full() }}">
    <meta property="og:image" content="{{ $page->image ? $page->present()->image(1200, 630) : '' }}">

    @if (config('typicms.twitter_site') !== null)
    <meta name="twitter:site" content="{{ config('typicms.twitter_site') }}">
    <meta name="twitter:card" content="summary_large_image">
    @endif

    @if (config('typicms.facebook_app_id') !== null)
    <meta property="fb:app_id" content="{{ config('typicms.facebook_app_id') }}">
    @endif

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#a8692c">
    <meta name="msapplication-TileColor" content="#a8692c">
    <meta name="theme-color" content="#ffffff">

    {{-- @vite('resources/scss/public.scss') --}}

    {{-- @include('core::public._feed-links') --}}

    <link rel="stylesheet" href="/css/app.css" media="all">
    <link rel="stylesheet" href="/css/jquery-ui.css" media="all">
    <link rel="stylesheet" href="/css/flickity.css" media="all">
    <link rel="stylesheet" href="/css/modal-popup.css" media="all">
    <link rel="stylesheet" href="/css/custom.css" media="all">
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" media="all"-->

    @stack('css')
    @if ($page->css)
        <style type="text/css">{{ $page->css }}</style>
    @endif

    {{-- @vite('resources/js/public.js') --}}

    <script src="/js/jquery.js" defer></script>
    <script src="/js/jquery-ui.js" defer></script>
    <script src="/js/jquery.ui.touch-punch.js" defer></script>
    <script src="/js/flickity.js" defer></script>
    <script src="/js/app.js" defer></script>
    	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    @stack('js')
    @if ($page->js)
        <script>{!! $page->js !!}</script>
    @endif
	
	<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '2075296526281115');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=2075296526281115&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
	
</head>

<body>

    {{-- @include('core::_navbar') --}}
    
    <?php
    	$currentPath = request()->path();
    	if ($lang == 'lv') {
    	    if (!Str::startsWith($currentPath, 'lv')) {
		$newUrl = url('kontakti');
	    } else {
		$newUrl = url('lv/kontakti');
	    }
	} elseif ($lang == 'ru') {
	    if (!Str::startsWith($currentPath, 'ru')) {
		$newUrl = url('kontakty');
	    } else {
		$newUrl = url('ru/kontakty');
	    }
	} elseif ($lang == 'en') {    	    

	    if (!Str::startsWith($currentPath, 'en')) {
		$newUrl = url('contacts');
	    } else {
		$newUrl = url('en/contacts');
	    }
	    
	}
    ?>

    <div class="js-mobmenu-background">
    </div>
    <nav class="js-mobmenu-content">
        <button class="js-burger js-menu-toggle">
            <?php include(resource_path('images/burger.svg')) ?>
        </button>
        <div class="container">
            <div class="text-center">
                <img class="js-mobmenu-logo" src="/images/logo-menu.svg" alt="">
            </div>
            <div class="row">
                <div class="col-6">
                    <nav class="js-mobmenu-menu">
                        <ul>
                            	@menu('primary')
                    		<li><a href="tel:+371-22-109-109">+371 22109109</a></li>
	    			<!--li><a id="registre_interest" class="box__link button-animation" data-toggle="modal" href="mailto:info@jurasskati.lv" data-target="#mc_embed_shell">@lang('Register your interest')</a></li-->
	    			<li><a id="registre_interest" class="box__link button-animation" href="{{ $newUrl }}"  >@lang('Register your interest')</a></li>
                        </ul>
                    </nav>

                    @if ($enabledLocales = TypiCMS::enabledLocales() and count($enabledLocales) > 1)
                    <nav class="js-mobmenu-lang">
                        <ul>
                            @foreach ($enabledLocales as $locale)
                                @if ($locale !== $lang)
                                    <li>
                                    @isset($page)
                                        @if ($page->isPublished($locale))
                                            <a class="lang-switcher-item dropdown-item" href="{{ isset($model) && $model->isPublished($locale) ? url($model->uri($locale)) : url($page->uri($locale)) }}">{{ $locale }}</a>
                                        @else
                                            <a class="lang-switcher-item dropdown-item" href="{{ url('/'.$locale) }}">{{ $locale }}</a>
                                        @endif
                                    @else
                                        <a class="lang-switcher-item dropdown-item" href="{{ url('/'.$locale) }}">{{ $locale }}</a>
                                    @endisset
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    
    <header class="js-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8 col-md-6 col-xl-3">
                    <a class="js-header-logo" href="{{ url('/'.$lang) }}">
                        <img src="/images/logo-header.svg" alt="">
                    </a>
                </div>
                <div class="col-xl-6 d-none d-xl-block text-right">
                    <nav class="js-header-menu">
                        <ul>
		                @menu('primary')
		        	<li><a href="tel:+371-22-109-109">+371 22109109</a></li>
			    	<!--li><a id="registre_interest" class="box__link button-animation" data-toggle="modal" href="javascript: return 0" data-target="#mc_embed_shell">@lang('Register your interest')</a></li-->
			    	<!--li><a id="registre_interest" class="box__link button-animation" href="" >@lang('Register your interest')</a></li-->
			    	<li><a id="registre_interest" class="box__link button-animation" href="{{ $newUrl }}" >@lang('Register your interest')</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-4 offset-md-4 offset-xl-0 col-md-2 col-xl-3 text-left">
                    @if ($enabledLocales = TypiCMS::enabledLocales() and count($enabledLocales) > 1)
                    <nav class="js-header-lang d-none d-xl-inline">
                        <ul>
                            @foreach ($enabledLocales as $locale)
                                @if ($locale !== $lang)
                                    <li>
                                    @isset($page)
                                        @if ($page->isPublished($locale))
                                            <a class="lang-switcher-item dropdown-item" href="{{ isset($model) && $model->isPublished($locale) ? url($model->uri($locale)) : url($page->uri($locale)) }}">{{ $locale }}</a>
                                        @else
                                            <a class="lang-switcher-item dropdown-item" href="{{ url('/'.$locale) }}">{{ $locale }}</a>
                                        @endif
                                    @else
                                        <a class="lang-switcher-item dropdown-item" href="{{ url('/'.$locale) }}">{{ $locale }}</a>
                                    @endisset
                                    </li>
                                    
                                @endif
                            @endforeach
                            
                        </ul>
                        <ul></ul>
                    </nav>
                    @endif
		    
                    <button class="js-burger js-menu-toggle d-xl-none">
                        <?php include(resource_path('images/burger.svg')) ?>
                    </button>
                </div>
            </div>
            
        </div>
    </header>

    @yield('content')

    <footer class="js-footer">
        <div class="container">
            <nav class="row">
                <div class="col-12 col-lg-3 text-center">
                    <a href="{{ url('/'.$lang) }}">
                        <img class="js-footer-logo" src="/images/logo-footer.svg" alt="">
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg order-lg-first text-center text-lg-left">
                    <ul class="js-footer-menu">
                        @menu('footer_left')
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg order-lg-last text-center text-lg-right">
                    <ul class="js-footer-menu">
                        @menu('footer_right')
                        <li>
                        	@if ($lang == 'lv')
                                   <a target="_" href="{{ asset('storage/files/d101-contract.pdf') }}">distances līgumam</a>
                                @endif
                                @if ($lang == 'en')
                                   <a target="_" href="{{ asset('storage/files/d101-contract.pdf') }}">distance contract</a>
                                @endif
                                @if ($lang == 'ru')
                                    <a target="_" href="{{ asset('storage/files/d101-contract.pdf') }}">договором дистанционной торговли</a>
                                @endif
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </footer>
    <section class="js-subfooter">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 text-center">
                    <ul class="js-subfooter-networks">
                        @if ($facebookUrl = config('typicms.facebook'))
                        <li>
                            <a href="{{ $facebookUrl }}"><img src="/images/fb.svg" alt=""></a>
                        </li>
                        @endif
                        @if ($instagramUrl = config('typicms.instagram'))
                        <li>
                            <a href="{{ $instagramUrl }}"><img src="/images/ig.svg" alt=""></a>
                        </li>
                        @endif
                        @if ($youtubeUrl = config('typicms.youtube'))
                        <li>
                            <a href="#"><img src="/images/yt.svg" alt=""></a>
                        </li>
                        @endif
                        <li>
                            <a href="#"><img src="/images/visa.svg" alt=""></a>
                        </li>
                        <li>
                            <a href="#"><img src="/images/master.svg" alt=""></a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md text-center text-md-right order-md-last">
                    {{--
                    <a href="#">Terms & Conditions</a>
                    --}}
                </div>
                <div class="col-12 col-md text-center text-md-left order-md-first">
                    Copyright by Juras skati. {{ date('Y') }}  all rights reserved
                </div>
            </div>
        </div>
    </section> 
   {{--
    @can('see unpublished items')
    @if (request('preview'))
    <script src="{{ asset('js/previewmode.js') }}"></script>
    @endif
    @endcan
    --}}

</body>
</html>
<!--link href="//cdn-images.mailchimp.com/embedcode/classic-061523.css" rel="stylesheet" type="text/css"-->
<div id="mc_embed_shell" class="modal fade" role="dialog">
	
  <div class="modal-dialog">
  	
    <div class="modal-content js-contactform">
    	<button type="button" class="button" style="float:right;"  data-dismiss="modal">×</button>
      <div class="modal-header">        
        <h4 class="modal-title" style="margin-top: 34px;">Send your contact information and get the BEST OFFER!</h4>        
      </div>
      <div class="modal-body">
        <div id="mc_embed_signup" class="modal-body">
          <form action="https://jurasskati.us8.list-manage.com/subscribe/post?u=75a1cadb310f0532517bde85f&amp;id=522f214723&amp;f_id=000b6de1f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
            <div id="mc_embed_signup_scroll">             
              
              <div class="mc-field-group element">
                <input type="email" name="EMAIL" placeholder="Email Address" class="email" id="mce-EMAIL" required value="">
              </div>
              <div class="mc-field-group element">
                <input type="text" placeholder="First Name" name="FNAME" class="text" id="mce-FNAME" value="">
              </div>
              <div class="mc-field-group element">
                <input type="text" placeholder="Last Name" name="LNAME" class="text" id="mce-LNAME" value="">
              </div>
              <div class="mc-field-group element">
                 <input type="text" placeholder="Phone Number" name="PHONE" class="REQ_CSS" id="mce-PHONE" value="">
              </div>
              <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display: none; font-size: 20px;"></div>
                <div class="response" id="mce-success-response" style="display: none; font-size: 20px;"></div>
              </div>
              <div aria-hidden="true" style="position: absolute; left: -5000px;">
                <input type="text" name="b_75a1cadb310f0532517bde85f_522f214723" tabindex="-1" value="">
              </div>
              <div class="clear text-center">
                <input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Subscribe">
              </div>
            </div>
          </form>
        </div>
        <script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[4]='PHONE';ftypes[4]='phone';fnames[3]='ADDRESS';ftypes[3]='address';fnames[5]='BIRTHDAY';ftypes[5]='birthday';fnames[6]='COMPANY';ftypes[6]='text';}(jQuery));var $mcj = jQuery.noConflict(true);
</script>
