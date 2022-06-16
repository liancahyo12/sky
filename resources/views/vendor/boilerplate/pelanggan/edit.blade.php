@extends('boilerplate::layout.index', [
    'title' => __('Pelanggan'),
    'subtitle' => __('Edit Pelanggan'),
    'breadcrumb' => [
        __('Edit Pelanggan') 
    ]
])

@section('content')
<x-boilerplate::form :route="['boilerplate.update-pelanggan', $pelanggan->id]" method="put">
    @csrf
    <x-boilerplate::card title="Pelanggan">
        <x-boilerplate::input name="nama" id="nama" label="Nama*" value="{{ $pelanggan->nama }}" required/>
            <div id="jenis_identitasa">
                <x-boilerplate::select2 name="jenis_identitas" id="jenis_identitas" label="Pilih Jenis Identitas*" required>
                    @foreach ($jenis_identitas as $position)
                        <option value="{{ $position->id }}" @if ($position->id==$pelanggan->jenis_identitas_id)
                            selected
                            @endif>{{ $position->jenis_identitas }}</option>
                    @endforeach
                </x-boilerplate::select2>
            </div>
            <x-boilerplate::input name="no_identitas" id="no_identitas" label="No Identitas*" value="{{ $pelanggan->no_identitas }}" required/>
            <x-boilerplate::input name="alamat" id="alamat" label="Alamat*" value="{{ $pelanggan->alamat }}" required/>
            <x-boilerplate::input name="alias" id="alias" label="Alias" value={{ $pelanggan->alias }} />
            <x-boilerplate::input name="group" id="group" label="Group" value="{{ $pelanggan->group }}" />
            <x-boilerplate::input name="kenalan" id="kenalan" label="Kenalan" value="{{ $pelanggan->kenalan }}" />
    </x-boilerplate::card>
    <div class="row">
        &nbsp; &nbsp;
        {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
    </div>
</x-boilerplate::form>
@endsection