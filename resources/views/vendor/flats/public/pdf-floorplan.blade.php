<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        body {
            background-color: #F0F0F0;
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
            top: 0mm;
            left: 0mm;
            bottom: 0mm;
            right: 0mm;
        }
        .plan img,
        .plan svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .floor-label {
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
        .floor-number {
            color: #A8692C;
            font-size: 2em;
            padding-bottom: 0.5em;
        }
        /* Ensure SVG preserves all colors and renders properly */
        .plan svg {
            color-rendering: optimizeQuality;
            shape-rendering: geometricPrecision;
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        /* Style SVG floor plan elements - ensure .bg elements are colored */
        .plan svg .bg {
            fill: #E8E8E8 !important;
        }
        .plan svg .apt.unavailable .bg,
        .plan svg .apt.sold .bg {
            fill: #979797 !important;
        }
        /* Preserve all original colors - don't override stroke and fill unless needed */
        .plan svg path[stroke],
        .plan svg line[stroke],
        .plan svg rect[stroke],
        .plan svg circle[stroke],
        .plan svg polygon[stroke] {
            /* Preserve original stroke colors */
        }
        .plan svg path[fill],
        .plan svg rect[fill],
        .plan svg circle[fill],
        .plan svg polygon[fill] {
            /* Preserve original fill colors */
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ resource_path('/images/floorplans/logo.svg') }}" alt="">
    </div>
    @if ($type == 'apartment')
    <div class="compass">
        <img src="{{ resource_path('/images/floorplans/compass-af.svg') }}" alt="">
    </div>
    @else
    <div class="compass">
        <img src="{{ resource_path('/images/floorplans/compass-lf.svg') }}" alt="">
    </div>
    @endif
    <div class="plan">
        @if (!empty($svgContent) && strlen(trim($svgContent)) > 100)
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                {!! $svgContent !!}
            </div>
        @else
            @php
                $fallbackPath = public_path('images/floorplans/'.$floorplan);
            @endphp
            @if (file_exists($fallbackPath))
                <img src="{{ $fallbackPath }}" alt="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            @endif
        @endif
    </div>
    <div class="floor-label">
        <div class="floor-number">
            @if ($lang == 'lv')
                {{ $floorNumber }}. @lang('floor')
            @elseif ($lang == 'en')
                @lang('floor') {{ $floorNumber }}
            @elseif ($lang == 'ru')
                {{ $floorNumber }} @lang('floor')
            @endif
        </div>
    </div>
</body>
</html>
