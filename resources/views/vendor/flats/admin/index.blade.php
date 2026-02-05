@extends('core::admin.master')

@section('title', __('Flats'))

@section('content')

<item-list
    url-base="/api/flats"
    fields="id,image_id,number,total_area,price,availability"
    table="flats"
    title="flats"
    include="image"
    :exportable="false"
    :searchable="['number','availability']"
    :sorting="['number','availability']">

    <template slot="add-button" v-if="$can('create flats')">
        @include('core::admin._button-create', ['module' => 'flats'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="edit" v-if="$can('update flats')"></item-list-column-header>
        <item-list-column-header name="number" sortable :sort-array="sortArray" label="Number"></item-list-column-header>
        <item-list-column-header name="total_area" label="Area"></item-list-column-header>
        <item-list-column-header name="price" label="Price"></item-list-column-header>
        <item-list-column-header name="availability" sortable :sort-array="sortArray" label="Availability"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td v-if="$can('update flats')">
            <item-list-edit-button :url="'/admin/flats/'+model.id+'/edit'"></item-list-edit-button>
        </td>
        <td v-html="model.number"></td>
        <td v-html="model.total_area"></td>
        <td v-html="model.price"></td>
        <td>
            <span class="badge"
                  :class="{
                    'bg-success': Number(model.availability) === 0,
                    'bg-warning': Number(model.availability) === 1,
                    'bg-danger' : Number(model.availability) === 2,
                    'bg-info'   : Number(model.availability) === 3,
                    'bg-secondary': model.availability === null || model.availability === undefined
                  }">
                @{{ ({0:'Available',1:'Reserved',2:'Sold',3:'On request'})[Number(model.availability)] || '' }}
            </span>
        </td>
    </template>

</item-list>

@endsection