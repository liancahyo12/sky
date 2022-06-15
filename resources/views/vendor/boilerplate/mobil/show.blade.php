@extends('boilerplate::layout.index', [
    'title' => __('Mobil'),
    'subtitle' => __('Detail Mobil'),
    'breadcrumb' => [
        __('Detail Mobil') 
    ]
])

@section('content')
    <x-boilerplate::card title="Mobil">
        <x-slot name="tools">
            @if ($mobil->sedia_status==1)
                <span class="badge badge-pill badge-success">tersedia</span>
            @endif
            @if ($mobil->sedia_status==2)
                <span class="badge badge-pill badge-info">sedang digunakan</span>
            @endif
            @if ($mobil->sedia_status==3)
                <span class="badge badge-pill badge-secondary">booked</span>
            @endif
            @if ($mobil->sedia_status==4)
                <span class="badge badge-pill badge-danger">tidak aktif</span>
            @endif
            
        </x-slot>
        <x-boilerplate::select2 name="pemilik" label="Pilih Pemilik*" disabled>
            @foreach ($pemilik as $position)
                <option value="{{ $position->id }}" @if ( $mobil->user_id==$position->id)
                    selected
                @endif>{{ $position->nama }}</option>
            @endforeach
        </x-boilerplate::select2>
        <x-boilerplate::input name="merek" label="Merek Mobil*" value="{{ $mobil->merek }}" disabled/>
        <x-boilerplate::input name="tipe" label="Tipe Mobil*" value="{{ $mobil->tipe }}" disabled/>
        <x-boilerplate::input name="plat" label="Plat Nomor*" value="{{ $mobil->plat }}" disabled/>
    </x-boilerplate::card>
    <x-boilerplate::card title="Biaya Mobil ">
        <table class="table" id="dynamic">
            @foreach ($biaya_mobil as $biaya_mobila)
                <tr id="row">
                    <td>
                        <label for="investor">Jenis Paket*</label> <br>
                        <select name="jenis_paket[]" id="jenis_paket" disabled  >
                            @foreach ($jenis_paket as $position)
                                <option value="{{ $position->id }}" @if ( $biaya_mobila->jenis_paket_id==$position->id)
                                    selected
                                @endif>{{ $position->jenis_paket }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="investor">Investor (Rupiah)*</label>
                        <input class="form-control" type="number" name="investor[]" id="investor" value="{{ $biaya_mobila->biaya_investor }}"disabled>
                    </td>
                    <td>
                        <label for="danlap">Danlap (Rupiah)*</label>
                        <input class="form-control angka" type="number" name="danlap[]" id="danlap" value="{{ $biaya_mobila->biaya_danlap }}" disabled>
                    </td>
                    <td>
                        <label for="driver">Driver (Rupiah)*</label>
                        <input class="form-control angka" type="number" name="driver[]" id="driver" value="{{ $biaya_mobila->biaya_danlap }}" disabled>
                    </td>
                </tr>
            @endforeach
        </table>
    </x-boilerplate::card>
@endsection