@extends('boilerplate::layout.index', [
    'title' => __('Driver'),
    'subtitle' => __('Detail Driver'),
    'breadcrumb' => [
        __('Detail Driver') 
    ]
])

@section('content')
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
        <x-boilerplate::input name="nama" label="Nama*" value="{{ $driver->nama }}" disabled/>
        <x-boilerplate::select2 name="jenis_identitas" label="Pilih Jenis Identitas*" disabled>
            @foreach ($jenisidentitas as $position)
                <option value="{{ $position->id }}" @if ( $driver->jenis_identitas==$position->id)
                    selected
                @endif>{{ $position->jenis_identitas }}</option>
            @endforeach
        </x-boilerplate::select2>
        <x-boilerplate::input name="no_identitas" label="No Identitas*" value="{{ $driver->no_identitas }}" disabled/>
        <x-boilerplate::input name="alamat" label="alamat*" value="{{ $driver->alamat }}" disabled/>
    </x-boilerplate::card>
@endsection