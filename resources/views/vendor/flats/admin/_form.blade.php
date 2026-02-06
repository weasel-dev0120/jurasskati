@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
    <script>
        (function(){
            function toggleVisibility(checkboxId, locationSelector, imageSelector) {
                let checkbox = document.querySelector(checkboxId);
                if (!checkbox) return;
                let locationInput = document.querySelector(locationSelector)?.parentElement;
                let imageInput = document.querySelector(imageSelector)?.parentElement;
                function update() {
                    let show = checkbox.checked;
                    if (locationInput) {
                        locationInput.style.opacity = show ? 1 : 0;
                        locationInput.style.pointerEvents = show ? 'all' : 'none';
                    }
                    if (imageInput) {
                        imageInput.style.opacity = show ? 1 : 0;
                        imageInput.style.pointerEvents = show ? 'all' : 'none';
                    }
                }
                update();
                checkbox.addEventListener('click', update);
            }
            window.addEventListener('DOMContentLoaded', (ev) => {
                toggleVisibility('#has_second_floor', '#second_floor_location', '#second_image_id');
                toggleVisibility('#has_third_floor', '#third_floor_location', '#third_image_id');
            });
        }).call();
    </script>
@endpush

<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Flats')])
    @empty ($model->id)
    <h1 class="header-title">
        {{ $default ?? __('New') }}
    </h1>
    @else
    <h1 class="header-title @if (!$model->present()->title)text-muted @endif">
        {{ $model->present()->number ?: __('Untitled') }}
    </h1>
    @endempty
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">

    @include('core::admin._form-errors')

    {!! BootForm::hidden('id') !!}

    <div class="row gx-3">
        <div class="col-md-6">
            {!! BootForm::text(__('Number'), 'number') !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::select(__('Type'), 'type')->options(['apartment' => __('Apartment'), 'loft' => __('Loft')]) !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::select(__('Floor'), 'floor')->options(array_combine($r = range(1,10), $r)) !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::select(__('Floor location'), 'floor_location')->options(array_combine($r = range(1,50), $r)) !!}
        </div>
    </div>

    <div class="row gx-3">
        <div class="col-md-6">
            {!! BootForm::text(__('Total area'), 'total_area') !!}
        </div>
        {{--
        <div class="col-md-6">
            {!! BootForm::text(__('Living area'), 'living_area') !!}
        </div>
        --}}
        <div class="col-md-6">
            {!! BootForm::text(__('Outdoor area'), 'outdoor_area') !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::text(__('Room count'), 'room_count') !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::text(__('Price'), 'price') !!}
        </div>
    </div>
    <div class="row gx-3">
        <div class="col-md-6">
            {!! BootForm::select(__('Availability'), 'availability')->options(TypiCMS\Modules\Flats\Models\Flat::STATUS_OPTIONS) !!}
        </div>
    </div>

    <br>

    <div class="row gx-3 align-items-center">
        <div class="col-md-6">
            {!! BootForm::checkbox(__('Has second floor'), 'has_second_floor') !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::select(__('Second floor location'), 'second_floor_location')->options(array_combine($r = range(1,50), $r)) !!}
        </div>
    </div>
    <div class="row gx-3 align-items-center">
        <div class="col-md-6">
            {!! BootForm::checkbox(__('Has third floor'), 'has_third_floor') !!}
        </div>
        <div class="col-md-6">
            {!! BootForm::select(__('Third floor location'), 'third_floor_location')->options(array_combine($r = range(1,50), $r)) !!}
        </div>
    </div>

    <br>

    <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
    <div class="row gx-3">
        <div class="col-md-6">
            <file-field type="image" field="image_id" label="@lang('Plan')" :init-file="{{ $model->image ?? 'null' }}"></file-field>
        </div>
        <div class="col-md-6">
            <file-field type="image" field="second_image_id" label="@lang('Second floor plan')" :init-file="{{ $model->second_image ?? 'null' }}"></file-field>
        </div>
        <div class="col-md-6">
            <file-field type="image" field="third_image_id" label="@lang('Third floor plan')" :init-file="{{ $model->third_image ?? 'null' }}"></file-field>
        </div>
    </div>
    {{--<files-field :init-files="{{ $model->files }}"></files-field>--}}

    {{--@include('core::form._title-and-slug')--}}

    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(1) !!}
        {{--!! TranslatableBootForm::checkbox(__('Published'), 'status') !!--}}
    </div>
    {{--!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!--}}
    {{--!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!--}}

    

</div>
