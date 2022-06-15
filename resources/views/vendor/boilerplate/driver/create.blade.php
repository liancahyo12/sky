@extends('boilerplate::layout.index', [
    'title' => __('Driver'),
    'subtitle' => __('Tambah Diver'),
    'breadcrumb' => [
        __('Tambah Driver') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.store-driver']" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="nama" label="Nama*" required/>
            <x-boilerplate::select2 name="jenis_identitas" label="Pilih Jenis Identitas*" required>
                @foreach ($jenisidentitas as $position)
                    <option value="{{ $position->id }}">{{ $position->jenis_identitas }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="no_identitas" label="Nomor Identitas*" required/>
            <x-boilerplate::input name="alamat" label="Alamat*" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection