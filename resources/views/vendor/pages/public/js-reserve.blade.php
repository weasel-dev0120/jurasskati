@extends('pages::public.master')

@section('content')

<section class="js-home-section js-contacts-text">
	<div class="container">
		<div class="js-reserveform">
		    <form action="{{ route('submit_reserve_form') }}" method="post">
 		        @csrf
			<input type="hidden" name="flat_no" id="flat_no" value="{{ Session::get('flatID') }}">
		        <div class="row">
		            <div class="col-md-6">
		                <div class="element">
		                    <input id="name" 
		                        type="text" 
		                        name="name" 
		                        placeholder="@lang('Name')"
		                        required>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="element">
		                    <input id="last_name" 
		                        type="text" 
		                        name="last_name" 
		                        placeholder="@lang('Last Name')"
		                        required>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="element">
		                    <input id="company_name" 
		                        type="text" 
		                        name="company_name" 
		                        placeholder="@lang('Company name')"
		                     >
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="element">
		                    <input id="code" 
		                        type="text" 
		                        name="code" 
		                        placeholder="@lang('Personal/Registration code')"
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
		            <div class="col-md-6">
		                <div class="element">
		                    <input id="phone" 
		                        type="tel" 
		                        name="phone" 
		                        placeholder="@lang('Phone')"
		                        minlength="8"
  					maxlength="8"		                    
		                        required>
		                </div>
		            </div>            		            
		           		                
		                
		            </div>
		            <div>
		        	<input type="checkbox" id="terms_conditions" name="terms_conditions" value="terms" required>
		        	@if ($lang == 'lv')
                                    Esmu izlasījis un piekrītu vietnes <a target="_" href="{{ url('/'.$lang) }}/@lang('terms-and-conditions')">noteikumiem un nosacījumiem</a> un <a target="_" href="{{ asset('storage/files/d101-contract.pdf') }}">distances līgumam</a>.
                                @endif
                                @if ($lang == 'en')
                                    I have read and agree to website's <a target="_" href="{{ url('/'.$lang) }}/@lang('terms-and-conditions')">terms and conditions</a> and the <a target="_" href="{{ asset('storage/files/d101-contract.pdf') }}">distance contract</a>.
                                @endif
                                @if ($lang == 'ru')
                                    Я прочитал(а) и согласен(сна) с <a target="_" href="{{ url('/'.$lang) }}/@lang('terms-and-conditions')">условиями использования сайта</a> и <a target="_" href="{{ asset('storage/files/d101-contract.pdf') }}">договором дистанционной торговли</a>. 
                                @endif
		        	<br/><br/><input type="checkbox" id="privacy_policy" name="privacy_policy" value="privacy" required>
		        	<label for="privacy_policy"> @lang('Privacy Disclaimer')</label><br>
		            </div>
		            <div class="col-md-12 text-center">
		                <button type="submit">@lang('Reserve') | €1500</button>
		            </div>
		            <div class="col-12">
		                <div class="message success d-none">@lang('Thank you! Your message has been sent.')</div>
		                <div class="message error user d-none">@lang('There was an error with your message! Please, check the values and try again.')</div>
		                <div class="message error server d-none">@lang('There was a server error! Please, try again later.')</div>
		            </div>
		        
		    </form>
		</div>
	</div>

</section>

@endsection
