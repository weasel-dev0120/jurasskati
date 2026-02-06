@extends('pages::public.master')

@section('content')

<div class="js-selector-popup">
    <div class="numblock">
        <a href="#" class="number action" data-target="apts-a1_8">39</a>
    </div>
    <div class="floorblock">
        <div class="typetitle">@lang('Apartment')</div>
        @lang('popup floor') <span class="floor">1</span>
        <div class="level-row">
            {{-- @lang('popup level') --}}
            @lang('popup two level')
            <span class="level d-none">—</span>
        </div>
    </div>
    <div class="mainblock">
        <table>
            <tr>
                <th>@lang('popup status')</th>
                <td class="status">@lang('available')</td>
            </tr>
            <tr>
                <th>@lang('popup room count')</th>
                <td class="rooms">3</td>
            </tr>
            <tr>
                <th>@lang('popup total area')</th>
                <td class="area">55.65</td>
            </tr>
            <tr id="price_tr">
                <th>@lang('popup price')</th>
                <td class="pricefmt">180 000</td>
            </tr>
        </table>
    </div>
</div>

<section class="js-home-top">
    <div class="js-floors">
        @include('pages::public._selector')
    </div>
</section>

<section class="js-flats">
    <div class="container">
        <div class="js-flats-type">
            <input id="id_type_apartments" type="checkbox" name="flats_type" value="apartment" checked>
            <input id="id_type_lofts" type="checkbox" name="flats_type" value="loft" checked>
            <label for="id_type_apartments"><span>@lang('Flats')</span></label>
            <label for="id_type_lofts"><span>@lang('Lofts')</span></label>
        </div>

        <div class="js-flats-filter">
            <div class="row">
                <div class="item col-sm-5 col-lg-2">
                    <label>@lang('floor')</label>
                    <div class="js-filter-slider" data-min="1" data-max="10" data-step="1" data-attr="floor"></div>
                    <div class="indicator low">1</div>
                    <div class="indicator high">10</div>
                </div>
                <div class="item col-sm-6 offset-sm-1 offset-lg-0 col-lg-3">
                    <label>@lang('area')</label>
                    <div class="js-filter-slider" data-min="20" data-max="150" data-step="10" data-attr="area"></div>
                    <div class="indicator low">20</div>
                    <div class="indicator high">150</div>
                </div>
                <div class="item col-sm-5 offset-lg-1 col-lg-2">
                    <label>@lang('room count')</label>
                    <div class="js-filter-slider" data-min="1" data-max="5" data-step="1" data-attr="rooms"></div>
                    <div class="indicator low">1</div>
                    <div class="indicator high">5</div>
                </div>
                <div class="item col-sm-6 offset-sm-1 col-lg-3">
                    <label>@lang('price')</label>
                    <div class="js-filter-slider" data-min="50000" data-max="300000" data-step="5000" data-attr="price"></div>
                    <div class="indicator low">50000</div>
                    <div class="indicator high">300000</div>
                </div>
            </div>
        </div>

<?php

// $aptCount = [
//     '1' => range(1, 8),
//     '2' => range(1, 11),
//     '3' => range(1, 11),
//     '4' => range(1, 10),
//     '5' => range(1, 10),
//     '6' => range(1, 10),
//     '7' => range(1, 10),
//     '8' => range(1, 10),
//     '9' => range(1, 5),
//     '10' => range(1, 1),
// ];
//
// $apts = [];
// foreach ($aptCount as $floor => $numbers) {
//     foreach ($numbers as $floorNumber) {
//         $codeNumber = "A{$floor}/{$floorNumber}";
//         $apts[] = [
//             'type' => 'apartment',
//             'floor' => $floor,
//             'area' => 87,
//             'rooms' => ($floorNumber % 5 + 1),
//             'price' => ($floorNumber % 5 + 1) * 100000,
//             'number' => $codeNumber,
//             'id' => "a{$floor}_{$floorNumber}",
//         ];
//     }
// }
//
// foreach (range(1,47) as $floorNumber) {
//     $codeNumber = "L-{$floorNumber}";
//     $apts[] = [
//         'type' => 'loft',
//         'floor' => $floorNumber < 30 ? 1 : 2,
//         'area' => 114,
//         'rooms' => ($floorNumber % 3 + 1),
//         'price' => ($floorNumber % 3 + 1) * 150000,
//         'number' => $codeNumber,
//         'id' => "l{$floorNumber}",
//     ];
// }

?>

        <div class="js-flats-table">

            <table>
                <thead>
                    <tr>
                        <th>@lang('floor')</th>
                        <th>@lang('Apt Nr')</th>
                        <th>@lang('Room cnt')</th>
                        <th>@lang('total area')</th>
                        {{--<th>Примечания</th>--}}
                        <th>@lang('price')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Flats::all() as $flat)
                        <tr data-type="{{ $flat->type }}"
                            data-typetitle="@lang($flat->type)"
                            data-floor="{{ $flat->floor }}"
                            data-area="{{ $flat->total_area }}"
                            data-rooms="{{ $flat->room_count }}"
                            data-pricefmt="{{ $flat->getFormattedPrice() }}"
                            data-price="{{ $flat->price }}"
                            data-id="{{ $flat->getFloorplanId() }}"
                            data-id2="{{ $flat->getSecondFloorplanId() }}"
                            data-id3="{{ $flat->getThirdFloorplanId() }}"
                            data-number="{{ $flat->number }}"
                            data-status="@if($flat->isSold()){{ __('sold') }}@elseif($flat->isReserved()){{ __('reserved') }}@elseif($flat->isOnRequest()){{ __('On request') }}@else{{ __('available') }}@endif"
                            data-locations="{{ $flat->getLocationClasses() }}"
                            data-available="{{ $flat->isAvailable() ? '1' : '0' }}" class="action"
                            data-target="{{ $flat->type == 'apartment' ? 'apt' : 'loft' }}-{{ mb_substr($flat->type, 0, 1) . $flat->floor . '_' . $flat->floor_location }}"
                            @if($flat->isAvailable()) class="unavailable" @endif
                            >
                        <td>{{ $flat->floor }}</td>
                        <td class="number">{{ $flat->number }}</td>
                        <td>{{ $flat->room_count }}</td>
                        <td class="lowercase">{{ $flat->total_area }} {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
                        {{--<td></td>--}}
                        <td>@if ($flat->isSold())
                                @lang('Sold')
                            @elseif ($flat->isReserved())
                                @lang('Reserved')
                            @elseif ($flat->isOnRequest())
                                @lang('On request')
                            @else
                                {{ $flat->getFormattedPrice() }} €
                            @endif
                        </td>
                        <td>
             		 @if ($flat->isAvailable())
                         <input type="button" class="reserve-button" data-id="{{$flat->number}}" data-amount="1500" data-url="{{ url('/'.$lang) }}/@lang('Reserve')" value="@lang('Reserve') | €1500">
                         @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</section>

@endsection
