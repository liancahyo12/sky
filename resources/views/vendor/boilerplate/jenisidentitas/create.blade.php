@extends('boilerplate::layout.index', [
    'title' => __('Jenis Identitas'),
    'subtitle' => __('Tambah Jenis Identitas'),
    'breadcrumb' => [
        __('Tambah Jenis Identitas') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.store-jenisidentitas']" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="jenis_identitas" label="Jenis Identitas*" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection