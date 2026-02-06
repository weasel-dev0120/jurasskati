<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        body {
            background-color: #F5F5F5;
        }
        .logo {
            position: fixed;
            left: 0mm;
            top: 0mm;
            z-index: 1;
        }
        .compass {
            position: fixed;
            right: 0mm;
            top: 0mm;
            z-index: 1;
        }
        .plan {
            position: fixed;
            top: 0mm
            left: 0mm;
            bottom: 0mm;
            right: 0mm;
        }
        .plan img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .info {
            z-index: 1;
            position: fixed;
            left: 0mm;
            bottom: 0mm;
            width: 70mm;
            border-top: 2px solid #A8692C;
            border-bottom: 2px solid #A8692C;
            padding-top: 2em;
            padding-bottom: 2em;
            font-size: 10pt;
        }
        .table {
            width: 70mm;
        }
        .number {
            color: #A8692C;
            font-size: 2em;
            padding-bottom: 0.5em;
        }
        .level-row td {
            padding-bottom: 1em;
        }
        .level {
            color: #A8692C;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ resource_path('/images/floorplans/logo.svg') }}" alt="">
    </div>
    {{--
    <div class="compass">
        <img src="{{ resource_path('/images/floorplans/compass.svg') }}" alt="">
    </div>
    
    <div class="plan">
        <img src="{{ asset('storage/'.$model->image->path) }}" alt="">
    </div>
    --}}
    <div class="plan">
        <img src="{{ asset('storage/'.$image) }}" alt="">
    </div>
    <div class="info">
        <table class="table">
            <tr>
                <td>Nr.</td>
                <td align="right" class="number">{{ $model->number }}</td>
            </tr>
            @if ($model->has_second_floor)
            <tr class="level-row">
                <td>@lang('level')</td>
                <td align="right" class="level">{{ $level }} @lang('of 2')</td>
            </tr>
            @endif
            <tr>
                <td>@lang('floor')</td>
                <td align="right">{{ $model->floor }}</td>
            </tr>
            <tr>
                <td>@lang('room count')</td>
                <td align="right">{{ $model->room_count }}</td>
            </tr>
            <tr>
                <td>@lang('living area')</td>
                <td align="right"><span class="livingarea">{{ $model->getLivingArea() }}</span> {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
            </tr>
            <tr>
                <td>@lang('total area')</td>
                <td align="right"><span class="totalarea">{{ $model->total_area }}</span> {{ $lang == 'ru' ? 'м' : 'm' }}<sup>2</sup></td>
            </tr>
            @if($model->isOnRequest() == false)
	    <tr>
	        <td>@lang('price')</td>
	        <td align="right"><span class="price">{{ $model->getFormattedPrice() }} €</span></td>
	    </tr>
            @endif
        </table>
    </div>
</body>
</html>
