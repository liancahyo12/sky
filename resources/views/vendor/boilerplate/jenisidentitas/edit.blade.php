@extends('boilerplate::layout.index', [
    'title' => __('Jenis Identitas'),
    'subtitle' => __('Edit Jenis Identitas'),
    'breadcrumb' => [
        __('Edit Jenis Identitas') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.update-jenisidentitas', $jenis_identitas->id]" method="put" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="jenis_identitas" label="Jenis Identitas*" value="{{ $jenis_identitas->jenis_identitas }}" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection