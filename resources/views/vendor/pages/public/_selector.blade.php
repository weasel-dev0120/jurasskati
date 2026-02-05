<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="slide buildings active">
    <img class="js-floors-realbackground" src="/images/selector-buildings-bg.jpg" alt="">
    <img class="js-floors-background" src="/images/selector-buildings-bg.jpg" alt="">

    <svg class="js-floors-overlay" viewBox="0 0 1440 790" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g class="floor action" data-target="apartments" id="apartments" style="mix-blend-mode:hard-light">
        <path d="M972 382L913 373V363L929.5 354.5L930 180H937.5V166H960.5V155H988L990.5 154V138L1077 137L1106.5 140V167H1115V179.5H1121.5V207L1341 213L1347 223.5L1345.5 509.5L1033.5 458.5V424.5L991 417.5V400.5V398H989.5V400L972 397.5V382Z" fill="#99B3D2" fill-opacity="0.8"/>
        </g>
        <g class="floor action" data-target="lofts" id="lofts" style="mix-blend-mode:hard-light">
        <path d="M972 382L913 373V366L899.5 364.5L896.5 366V371L838.5 400.5L731.5 385.5V372L709.5 369.5V344L661 338L658.5 339V345.5L470.5 399V407L431.5 418V431L262.5 484L229.5 475.5L148.5 499.5V550.5L250 588.5L196 610.5L195.5 686L341.5 756.5L477 675L480 676L552 629.5V561L468.5 537L519 512.5L914 614.5L1033.5 484V424.5L991 417.5V400.5V398H989.5V400L972 397.5V382Z" fill="#99B3D2" fill-opacity="0.8"/>
        </g>
    </svg>

    <aside class="sidebar">
        <?php include(resource_path('images/selector-arrow-right.svg')) ?>
        <ul class="menu">
            <li>
                <a class="action" href="#" data-target="lofts">@lang('See lofts')</a>
            </li>
            <li>
                <a class="action" href="#" data-target="apartments">@lang('See flats')</a>
            </li>
        </ul>
    </aside>
</div>


<div class="slide apartments">
	
	<?php
		$appartment_title = '';		
		if ($lang == 'lv'){
		    $appartment_title="Moderna dzīvokļa interjers Jūras Skati kompleksā";		       
		}if ($lang == 'en'){
		    $appartment_title="Modern apartment interior in Jūras Skati complex";
		}
	?>
                
    <img class="js-floors-realbackground" src="/images/apartments-floors.jpg" alt="{{ $appartment_title }}">
    <img class="js-floors-background" src="/images/apartments-floors.jpg" alt="{{ $appartment_title }}">

    <svg class="js-floors-overlay" viewBox="0 0 1440 790" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g class="floor action" data-target="afloors-a1" id="floor-1" style="mix-blend-mode:hard-light">
        <path d="M1142.5 659L1162.5 602.5V644L1142.5 736.5L587 657V604L1142.5 659Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a2" id="floor-2" style="mix-blend-mode:hard-light">
        <path d="M1142.5 581.5L1162.5 546.5V602.5L1142.5 659L587 604V551L1142.5 581.5Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a3" id="floor-3" style="mix-blend-mode:hard-light">
        <path d="M1142.5 504.5L1162.5 495.5V546.5L1142.5 581.5L587 551V495.5L1142.5 504.5Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a4" id="floor-4" style="mix-blend-mode:hard-light">
        <path d="M1142.5 428L1162.5 442V495.5L1142.5 504.5L587 495.5V442.5L1142.5 428Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a5" id="floor-5" style="mix-blend-mode:hard-light">
        <path d="M1142.5 344.5L1162.5 391.812V442L1142.5 428L587 442.5V388L1142.5 344.5Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a6" id="floor-6" style="mix-blend-mode:hard-light">
        <path d="M1144 265.5L1162.5 343.5V391.805L1142.5 344.5L587 388V333L1144 265.5Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a7" id="floor-7" style="mix-blend-mode:hard-light">
        <path d="M1144 183L1162.5 293V343.5L1144 265.5L587 333V277.5L1144 183Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a8" id="floor-8" style="mix-blend-mode:hard-light">
        <path d="M1144 111L1162.5 241.5V292.922L1144 183L587 277.5V227.5L1144 111Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a9" id="floor-9" style="mix-blend-mode:hard-light">
        <path d="M655 213.281L587 227.5V170.5L656 153L695.5 177L655 187V213.281Z" fill="#99B3D2"/>
        </g>
        <g class="floor action" data-target="afloors-a10" id="floor-10" style="mix-blend-mode:hard-light">
        <path d="M656 153L587 170.5V88L612 80H673.844L775 158.5L695.5 177L656 153Z" fill="#99B3D2"/>
        </g>
    </svg>

    <aside class="sidebar">
        <?php include(resource_path('images/selector-arrow-left.svg')) ?>
        <ul class="menu">
            <li>
                <a class="action" href="#" data-target="buildings">@lang('Select building')</a>
            </li>
            <?php for ($i = 10; $i >= 1; $i--): ?>
            <li class="">
                @if ($lang == 'lv')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>"><?= $i; ?>. @lang('floor')</a>
                @endif
                @if ($lang == 'en')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>">@lang('floor') <?= $i; ?></a>
                @endif
                @if ($lang == 'ru')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>"><?= $i; ?> @lang('floor')</a>
                @endif
            </li>
            <?php endfor; ?>
        </ul>
    </aside>
</div>

<div class="slide lofts">

<?php
	$loft_title = '';		
	if ($lang == 'lv'){
	    $loft_title="Jūras Skati lofts ar privātu terasi";		       
	}if ($lang == 'en'){
	    $loft_title="Jūras Skati lofts with private terrace";
	}
?>
    <img class="js-floors-realbackground" src="/images/lofti-floors.jpg" alt="{{ $loft_title}}">
    <img class="js-floors-background" src="/images/lofti-floors.jpg" alt="{{ $loft_title }}">

    <svg class="js-floors-overlay" viewBox="0 0 1440 790" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g class="floor action" data-target="lfloors-l2" id="floor-2" style="mix-blend-mode:hard-light">
        <path d="M1046 335L545.5 308.5V366L1046 419.5V410.5L1330.5 362V313.5L1046 335Z" fill="#99B3D2" fill-opacity="0.8"/>
        </g>
        <g class="floor action" data-target="lfloors-l1" id="floor-1" style="mix-blend-mode:hard-light">
        <path d="M1373.5 389L1440 374.5V449L1393.5 470.5V482.5L1344.5 507L1323.5 501.5L1198 544V504L1163 498.5L1121 512.5V547.5L1101.5 555L586 445L511.5 453L496 450.5V534.5L0 633.5V480L496 425.5L367.5 396.5L601.5 372L1046 419.5V413.5L1200 426.5L1326 401V409L1384 413.5L1431 401V393.5L1373.5 389Z" fill="#99B3D2" fill-opacity="0.7"/>
        </g>
    </svg>

    <aside class="sidebar">
        <?php include(resource_path('images/selector-arrow-left.svg')) ?>
        <ul class="menu">
            <li>
                <a class="action" href="#" data-target="buildings">@lang('Select building')</a>
            </li>
            <li class="">
                <a class="action" href="#" data-target="lfloors-l2">@lang('Loft floor 2')</a>
            </li>
            <li class="">
                <a class="action" href="#" data-target="lfloors-l1">@lang('Loft floor 1')</a>
            </li>
        </ul>
    </aside>
</div>

<div class="slide afloors">
    <img class="background" src="/images/floorplans-bg.jpg" alt="">

    <div class="content">
        <img class="logo" src="/images/floorplans/logo.svg" alt="">
        <img class="compass" src="/images/floorplans/compass-af.svg" alt="">
        <div class="legend">
            <span class="available">@lang('legend:available')</span>
            <span class="on-request">@lang('legend:On request')</span>
            <span class="sold">@lang('legend:sold')</span>
        </div>
        <img class="floorplan a1" src="/images/floorplans/a1.svg" loading="lazy">
        <img class="floorplan a2" src="/images/floorplans/a2.svg" loading="lazy">
        <img class="floorplan a3" src="/images/floorplans/a3.svg" loading="lazy">
        <img class="floorplan a4" src="/images/floorplans/a4.svg" loading="lazy">
        <img class="floorplan a5" src="/images/floorplans/a5.svg" loading="lazy">
        <img class="floorplan a6" src="/images/floorplans/a6.svg" loading="lazy">
        <img class="floorplan a7" src="/images/floorplans/a7.svg" loading="lazy">
        <img class="floorplan a8" src="/images/floorplans/a8.svg" loading="lazy">
        <img class="floorplan a9" src="/images/floorplans/a9.svg" loading="lazy">
        <img class="floorplan a10" src="/images/floorplans/a10.svg" loading="lazy">
    </div>

    <aside class="sidebar">
        <span class="d-none d-md-inline">
            <?php include(resource_path('images/selector-arrow-left.svg')) ?>
        </span>
        <ul class="menu">
            <li>
                <a class="action" href="#" data-target="apartments">@lang('Close floor plans')</a>
            </li>
            <?php for ($i = 10; $i >= 1; $i--): ?>
            <li class="d-none d-md-block">
                @if ($lang == 'lv')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>"><?= $i; ?>. @lang('floor')</a>
                @endif
                @if ($lang == 'en')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>">@lang('floor') <?= $i; ?></a>
                @endif
                @if ($lang == 'ru')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>"><?= $i; ?> @lang('floor')</a>
                @endif
            </li>
            <?php endfor; ?>
        </ul>
    </aside>
</div>

<div class="slide lfloors">
    <img class="background" src="/images/floorplans-bg.jpg" alt="">

    <div class="content">
        <img class="logo" src="/images/floorplans/logo.svg" alt="">
        <img class="compass" src="/images/floorplans/compass-lf.svg" alt="">
        <div class="legend">
            <span class="available">@lang('legend:available')</span>
            <span class="on-request">@lang('legend:On request')</span>
            <span class="sold">@lang('legend:sold')</span>
        </div>
        <img class="floorplan l1" src="/images/floorplans/l1.svg" loading="lazy">
        <img class="floorplan l2" src="/images/floorplans/l2.svg" loading="lazy">
    </div>

    <aside class="sidebar">
        <span class="d-none d-md-inline">
            <?php include(resource_path('images/selector-arrow-left.svg')) ?>
        </span>
        <ul class="menu">
            <li>
                <a class="action" href="#" data-target="lofts">@lang('Close floor plans')</a>
            </li>
            <li class="d-none d-md-block">
                <a class="action" href="#" data-target="lfloors-l2">@lang('Loft floor 2')</a>
            </li>
            <li class="d-none d-md-block">
                <a class="action" href="#" data-target="lfloors-l1">@lang('Loft floor 1')</a>
            </li>
        </ul>
    </aside>
</div>

<div class="slide apt">
    <img class="background" src="/images/floorplans-bg.jpg" alt="">

    <div class="content">
        <img class="logo" src="/images/floorplans/logo.svg" alt="">
        {{-- TODO apt images --}}
        @foreach (Flats::all() as $flat)
        	
            @if ($flat->type == 'apartment')         
		
                <div class="aptplan {{ $flat->getLocationClasses() }}@if ($flat->has_second_floor) has-second-floor @endif">
                    <img class="compass" src="/images/floorplans/compass-lf.svg" alt="">
                    @if ($flat->has_second_floor)                    	
                        <picture class="plan" data-label="@lang('Apartment level 1')">
                            <img src="{{ asset('storage/'.$flat->image->path) }}" alt="" style="" data-floor="1" loading="lazy">
                        </picture>
                        <picture class="plan" data-label="@lang('Apartment level 2')">
                            <img src="{{ asset('storage/'.$flat->second_image->path) }}" alt="" style="" data-floor="2" loading="lazy">
                        </picture>
                    @else
                        <picture class="plan">
                            <img src="{{ asset('storage/'.$flat->image->path) }}" alt="" style="" data-floor="1" loading="lazy">                                    
                        </picture>
                    @endif
                    <div class="aptinfo">
                        {{--
                        @if ($flat->has_second_floor)
                            <table>
                                <tr>
                                    <th>
                                        @lang('Select apartment level'):
                                    </th>
                                    <td>
                                        <ul class="floor-selector">
                                            <li><a href="#" data-floor="1" class="active">1</a></li>
                                            <li><a href="#" data-floor="2">2</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        --}}
                        @php
                        	$flatPrice = $flat->getFormattedPrice();
                        	$numericFlatPrice = (int) str_replace(' ', '', $flatPrice);
				$apr = 3.74;              // GPL
				$years = 30;
				$downPct = 15;

				// loan
				if(is_numeric($numericFlatPrice)){
					$down = $numericFlatPrice * ($downPct/100);
					$pv = $numericFlatPrice - $down;
					$r = ($apr/100)/12;
					$n = $years * 12;
					$pmt = ($pv * $r) / (1 - pow(1+$r, -$n));  // 804.81

					// incomes (choose bedrooms)
					if($flat->room_count <= 2)
					{
						$rent = 650;
						$airbnb  = 75 * 30 * 0.6 * 0.8;
					}
					
					if($flat->room_count > 2)
					{
						$rent = 950;
						$airbnb  = 120 * 30 * 0.6 * 0.8;
					}
					$rent_1_2 = 650;
					$rent_3_4 = 950;
				}

				$airbnb_1_2 = 75 * 30 * 0.6 * 0.8;  // 1080
				$airbnb_3_4 = 120 * 30 * 0.6 * 0.8; // 1728
                        
                        @endphp
                        <table>
                            <tr>
                                <th>Nr.</th>
                                <td class="number">{{ $flat->number }}</td>
                            </tr>
                            <tr>
                                <th>@lang('floor')</th>
                                <td class="floor">{{ $flat->floor }}</td>
                            </tr>
                            <tr>
                                <th>@lang('room count')</th>
                                <td class="rooms">{{ $flat->room_count }}</td>
                            </tr>
                            <tr>
                                <th>@lang('living area')</th>
                                <td><span class="livingarea">{{ $flat->getLivingArea() }}</span> {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
                            </tr>
                            <tr>
                                <th>@lang('total area')</th>
                                <td><span class="totalarea">{{ $flat->total_area }}</span> {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
                            </tr>
                            @if($flat->isOnRequest() == false)
                            <tr>
                                <th>@lang('price')</th>
                                <td><span class="price">{{ $flat->getFormattedPrice() }} €</span></td>
                            </tr>                           
			    
                            @endif
                        </table>
                        
                        @if(is_numeric($numericFlatPrice) && $numericFlatPrice > 0)
                        <div style="overflow-x: auto;" class="income-block">
			    <table class="table table-bordered" style="font-size: small; margin-top: 20px;">
			    <tr>
			    </tr>
			    <tr>
			    </tr>
			    <tr>
				<td colspan="2" class="text-center fw-bold">
				    <strong>
				        @if ($lang == 'en')
					    POTENTIAL PASSIVE INCOME PER MONTH
					@endif
					@if ($lang == 'lv')
					    POTENCIĀLIE PASĪVIE IENĀKUMI MĒNESĪ
					@endif
					@if ($lang == 'ru')
					    ВОЗМОЖНЫЙ ПАССИВНЫЙ ДОХОД В МЕСЯЦ
					@endif
				    </strong>
				</th>
			    </tr>
			    <tr>
				 <td>
				 	@if ($lang == 'en')
					    Potential rental apartment income
					@endif
					@if ($lang == 'lv')
					    Potenciālie ienākumi no īres dzīvokļa
					@endif
					@if ($lang == 'ru')
					    Потенциальный доход от сдачи квартиры в аренд:
					@endif
				 </td>
				 <td class="text-end"><strong>{{ $rent }} €</strong></td>
			    </tr>

			    <tr>
				  <td>@if ($lang == 'en')
					    Potential AirBnB apartment income*
					@endif
					@if ($lang == 'lv')
					    Potenciālie ienākumi no AirBnB dzīvokļa*
					@endif
					@if ($lang == 'ru')					    
					    Потенциальный доход от аренды квартиры через AirBnB*
					@endif
				   </td>
				   <td class="text-end"><strong>{{ $airbnb }} €</strong></td>
			     </tr>

			     <tr>
				    <td><strong>
				    	@if ($lang == 'en')
					    Loan payment**
					@endif
					@if ($lang == 'lv')
					    Aizdevuma maksājums**
					@endif
					@if ($lang == 'ru')
					    Выплата по кредиту**
					@endif
				    </strong></td>
				    <td class="text-end"><strong>{{ round($pmt) }} €</strong></td>
			      </tr>
				
			    </table>
			    
			    <div style="font-size: small; margin-top: 20px;">
			    	@if ($lang == 'en')
				<p>* Calculation based on 60% occupancy, minus 20% service fee</p>
				<p>**15% down payment, 30 years, APR 3.74%</p>
				@elseif ($lang == 'lv')
				<p>* Aprēķinā 60% noslogojums, mīnus 20% pakalpojumu maksa</p>
				<p>**15% pirmā iemaksa, 30 gadi, GPL 3.74%</p>
				@elseif ($lang == 'ru')
				<p>* Расчет произведен с учетом 60% заполняемости, минус 20% комиссионная плата</p>
				<p>**Первоначальный взнос 15%, рассрочка на 30 лет, годовая процентная ставка 3.74%</p>
				@endif
			</div>
			</div>
			@endif                    
                        
			


                        <div class="download">
                            <a href="{{ route($lang.'::download-flat', ['id' => $flat->id]) }}" target="_blank">
                                @lang('Download description')<br>
                                <svg width="24" height="33" viewBox="0 0 24 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.89497 17.2484H3.69708C4.45404 17.2484 5.26913 17.6211 5.23541 18.5577C5.20585 19.3994 4.69692 19.9062 3.69708 19.9062H1.89497V17.2484ZM0 15.6812V24.7328H1.89497V21.4467H3.99523C5.69872 21.4467 6.8981 20.2419 6.8981 18.6109C6.8981 16.9078 5.60841 15.6814 3.99523 15.6814L0 15.6812Z" fill="currentColor"/>
                                <path d="M10.1274 17.2485H11.5289C13.366 17.2485 14.0481 18.4425 14.0539 20.1109C14.0558 21.8115 13.2963 23.1924 11.6949 23.1924H10.1273L10.1274 17.2485ZM8.28516 15.6812V24.7329H12.0758C14.6721 24.7329 16.0289 22.4491 15.9884 20.1112C15.9434 17.5649 14.1972 15.6809 11.7908 15.6809L8.28516 15.6812Z" fill="currentColor"/>
                                <path d="M17.5508 15.6816V24.7333H19.4464V20.917H23.4263V19.3202H19.4464V17.2623H23.9994V15.6819L17.5508 15.6816Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.09126 0.000246616L0.00390625 8.16171V14.3617H1.74145V9.35854H9.6259V3.52649H7.88482V7.61812H2.77821L7.88482 1.74042H22.2523V14.3618H23.9928V0L7.09126 0.000246616Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00390625 26.0634V32.4124L23.9931 32.4359V22.9927H22.2527V30.6937L1.74104 30.6748V26.0636L0.00390625 26.0634Z" fill="currentColor"/>
                                </svg>
                            </a>
                           
                        </div>
                        
                    </div>
                    @if ($flat->isAvailable())
                        <div class="flat-reserve">
	   			<input type="button" class="reserve-button" data-id="{{$flat->number}}" data-url="{{ url('/'.$lang) }}/@lang('Reserve')" value="@lang('Reserve') | €1500">
	            	</div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    <aside class="sidebar">
        <span class="d-none d-md-inline">
            <?php include(resource_path('images/selector-arrow-left.svg')) ?>
        </span>
        <ul class="menu">
            <li>
                <a class="action close" href="#" data-target="afloors-a1">@lang('Close apartment')</a>
            </li>
            <?php for ($i = 10; $i >= 1; $i--): ?>
            <li class="d-none d-md-block">
                @if ($lang == 'lv')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>"><?= $i; ?>. @lang('floor')</a>
                @endif
                @if ($lang == 'en')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>">@lang('floor') <?= $i; ?></a>
                @endif
                @if ($lang == 'ru')
                    <a class="action" href="#" data-target="afloors-a<?= $i ?>"><?= $i; ?> @lang('floor')</a>
                @endif
            </li>
            <?php endfor; ?>
        </ul>
    </aside>
</div>

<div class="slide loft">
    <img class="background" src="/images/floorplans-bg.jpg" alt="">

    <div class="content">
        <img class="logo" src="/images/floorplans/logo.svg" alt="">
        
        @foreach (Flats::all() as $flat)
        	
            @if ($flat->type == 'loft')         
		
                <div class="aptplan {{ $flat->getLocationClasses() }}@if ($flat->has_second_floor) has-second-floor @endif">
                    <img class="compass" src="/images/floorplans/compass-lf.svg" alt="">
                    @if ($flat->has_second_floor)                    	
                        <picture class="plan" data-label="@lang('Apartment level 1')">
                            <img src="{{ asset('storage/'.$flat->image->path) }}" alt="" style="" data-floor="1" loading="lazy">
                        </picture>
                        <picture class="plan" data-label="@lang('Apartment level 2')">
                            <img src="{{ asset('storage/'.$flat->second_image->path) }}" alt="" style="" data-floor="2" loading="lazy">
                        </picture>
                    @else
                        <picture class="plan">
                            <img src="{{ asset('storage/'.$flat->image->path) }}" alt="" style="" data-floor="1" loading="lazy">                                    
                        </picture>
                    @endif
                    <div class="aptinfo">
                        {{--
                        @if ($flat->has_second_floor)
                            <table>
                                <tr>
                                    <th>
                                        @lang('Select apartment level'):
                                    </th>
                                    <td>
                                        <ul class="floor-selector">
                                            <li><a href="#" data-floor="1" class="active">1</a></li>
                                            <li><a href="#" data-floor="2">2</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        --}}
                        <table>
                            <tr>
                                <th>Nr.</th>
                                <td class="number">{{ $flat->number }}</td>
                            </tr>
                            <tr>
                                <th>@lang('floor')</th>
                                <td class="floor">{{ $flat->floor }}</td>
                            </tr>
                            <tr>
                                <th>@lang('room count')</th>
                                <td class="rooms">{{ $flat->room_count }}</td>
                            </tr>
                            <tr>
                                <th>@lang('living area')</th>
                                <td><span class="livingarea">{{ $flat->getLivingArea() }}</span> {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
                            </tr>
                            <tr>
                                <th>@lang('total area')</th>
                                <td><span class="totalarea">{{ $flat->total_area }}</span> {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
                            </tr>
                            @if($flat->isOnRequest() == false)
                            <tr>
                                <th>@lang('price')</th>
                                <td><span class="price">{{ $flat->getFormattedPrice() }} €</span></td>
                            </tr>
                            @endif
                        </table>
                        <div class="download">
                            <a href="{{ route($lang.'::download-flat', ['id' => $flat->id]) }}" target="_blank">
                                @lang('Download description')<br>
                                <svg width="24" height="33" viewBox="0 0 24 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.89497 17.2484H3.69708C4.45404 17.2484 5.26913 17.6211 5.23541 18.5577C5.20585 19.3994 4.69692 19.9062 3.69708 19.9062H1.89497V17.2484ZM0 15.6812V24.7328H1.89497V21.4467H3.99523C5.69872 21.4467 6.8981 20.2419 6.8981 18.6109C6.8981 16.9078 5.60841 15.6814 3.99523 15.6814L0 15.6812Z" fill="currentColor"/>
                                <path d="M10.1274 17.2485H11.5289C13.366 17.2485 14.0481 18.4425 14.0539 20.1109C14.0558 21.8115 13.2963 23.1924 11.6949 23.1924H10.1273L10.1274 17.2485ZM8.28516 15.6812V24.7329H12.0758C14.6721 24.7329 16.0289 22.4491 15.9884 20.1112C15.9434 17.5649 14.1972 15.6809 11.7908 15.6809L8.28516 15.6812Z" fill="currentColor"/>
                                <path d="M17.5508 15.6816V24.7333H19.4464V20.917H23.4263V19.3202H19.4464V17.2623H23.9994V15.6819L17.5508 15.6816Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.09126 0.000246616L0.00390625 8.16171V14.3617H1.74145V9.35854H9.6259V3.52649H7.88482V7.61812H2.77821L7.88482 1.74042H22.2523V14.3618H23.9928V0L7.09126 0.000246616Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00390625 26.0634V32.4124L23.9931 32.4359V22.9927H22.2527V30.6937L1.74104 30.6748V26.0636L0.00390625 26.0634Z" fill="currentColor"/>
                                </svg>
                            </a>
                           
                        </div>
                        
                    </div>
                    @if ($flat->isAvailable())
                        <div class="flat-reserve">
	   			<input type="button" class="reserve-button" data-id="{{$flat->number}}" data-url="{{ url('/'.$lang) }}/@lang('Reserve')" value="@lang('Reserve') | €1500">
	            	</div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    <aside class="sidebar">
        <span class="d-none d-md-inline">
            <?php include(resource_path('images/selector-arrow-left.svg')) ?>
        </span>
        <ul class="menu">
            <li>
                <a class="action close" href="#" data-target="lfloors-l1">@lang('Close loft')</a>
            </li>
            <li class="d-none d-md-block">
                <a class="action" href="#" data-target="lfloors-l2">@lang('Loft floor 2')</a>
            </li>
            <li class="d-none d-md-block">
                <a class="action" href="#" data-target="lfloors-l1">@lang('Loft floor 1')</a>
            </li>
        </ul>
    </aside>
</div>
