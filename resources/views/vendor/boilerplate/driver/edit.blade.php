@extends('boilerplate::layout.index', [
    'title' => __('Driver'),
    'subtitle' => __('Edit Driver'),
    'breadcrumb' => [
        __('Edit Driver') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.update-driver', $driver->id]" method="put" files>
        @csrf
        <x-boilerplate::card title="Driver">
            <x-slot name="tools">
                @if ($driver->sedia_status==1)
                    <span class="badge badge-pill badge-success">tersedia</span>
                @endif
                @if ($driver->sedia_status==2)
                    <span class="badge badge-pill badge-info">sedang digunakan</span>
                @endif
                @if ($driver->sedia_status==3)
                    <span class="badge badge-pill badge-secondary">booked</span>
                @endif
                @if ($driver->sedia_status==4)
                    <span class="badge badge-pill badge-danger">tidak aktif</span>
                @endif
                
            </x-slot>
            <x-boilerplate::input name="nama" label="Nama*" value="{{ $driver->nama }}" required/>
            <x-boilerplate::select2 name="jenis_identitas" label="Pilih Jenis Identitas*" required>
                @foreach ($jenisidentitas as $position)
                    <option value="{{ $position->id }}" @if ( $driver->jenis_identitas==$position->id)
                        selected
                    @endif>{{ $position->jenis_identitas }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="no_identitas" label="Tipe Mobil*" value="{{ $driver->no_identitas }}" required/>
            <x-boilerplate::input name="alamat" label="Alamat*" value="{{ $driver->alamat }}" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection