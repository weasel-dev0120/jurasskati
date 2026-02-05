@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Galleries')])
    @include('core::admin._title', ['default' => __('New gallery')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">

    @include('core::admin._form-errors')

    {!! BootForm::hidden('id') !!}

    <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
    {{-- <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field> --}}
    <files-field :init-files="{{ $model->files }}"></files-field>

    <div class="row gx-3">
        <div class="col-md-6">
            {!! TranslatableBootForm::text(__('Title'), 'title') !!}
            {!! TranslatableBootForm::hidden('slug') !!}
        </div>
    </div>
    {{-- @include('core::form._title-and-slug') --}}
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
    </div>
    {{-- {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!} --}}
    {{-- {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!} --}}

</div>
