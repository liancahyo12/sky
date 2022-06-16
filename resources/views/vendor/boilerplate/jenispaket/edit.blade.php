@extends('boilerplate::layout.index', [
    'title' => __('Jenis Paket'),
    'subtitle' => __('Edit Jenis Paket'),
    'breadcrumb' => [
        __('Edit Jenis Paket') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.update-jenispaket', $jenis_paket->id]" method="put" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="jenis_paket" label="Jenis Paket*" value="{{ $jenis_paket->jenis_paket }}" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection