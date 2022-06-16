@extends('boilerplate::layout.index', [
    'title' => __('Jenis Paket'),
    'subtitle' => __('Tambah Jenis Paket'),
    'breadcrumb' => [
        __('Tambah Jenis Paket') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.store-jenispaket']" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="jenis_paket" label="Jenis Paket*" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection