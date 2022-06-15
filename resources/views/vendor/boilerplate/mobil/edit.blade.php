@extends('boilerplate::layout.index', [
    'title' => __('Mobil'),
    'subtitle' => __('Edit Mobil'),
    'breadcrumb' => [
        __('Edit Mobil') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.update-mobil', $mobil->id]" method="put" files>
        @csrf
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
            <x-boilerplate::select2 name="pemilik" label="Pilih Pemilik*" required>
                @foreach ($pemilik as $position)
                    <option value="{{ $position->id }}" @if ( $mobil->user_id==$position->id)
                        selected
                    @endif>{{ $position->nama }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="merek" label="Merek Mobil*" value="{{ $mobil->merek }}" required/>
            <x-boilerplate::input name="tipe" label="Tipe Mobil*" value="{{ $mobil->tipe }}" required/>
            <x-boilerplate::input name="plat" label="Plat Nomor*" value="{{ $mobil->plat }}" required/>
        </x-boilerplate::card>
        <x-boilerplate::card title="Biaya Mobil ">
        <table class="table" id="dynamic">
            @foreach ($biaya_mobil as $biaya_mobila)
                <tr id="ro{{ $position->id }}">
                    <td>
                        @if ($loop->first) <label for="investor">Jenis Paket*</label> <br>@endif
                        <select name="jenis_paket[]" id="jenis_paket" required>
                            @foreach ($jenis_paket as $position)
                                <option value="{{ $position->id }}" @if ( $biaya_mobila->jenis_paket_id==$position->id)
                                    selected
                                @endif>{{ $position->jenis_paket }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        @if ($loop->first) <label for="investor">Investor (Rupiah)*</label> @endif
                        <input class="form-control" type="number" name="investor[]" id="investor" value="{{ $biaya_mobila->biaya_investor }}"required>
                    </td>
                    <td>
                        @if ($loop->first) <label for="danlap">Danlap (Rupiah)*</label> @endif
                        <input class="form-control angka" type="number" name="danlap[]" id="danlap" value="{{ $biaya_mobila->biaya_danlap }}" required>
                    </td>
                    <td>
                        @if ($loop->first) <label for="driver">Driver (Rupiah)*</label> @endif
                        <input class="form-control angka" type="number" name="driver[]" id="driver" value="{{ $biaya_mobila->biaya_driver }}" required>
                    </td>
                    @if ($loop->first) 
                    <td>
                        <br><button type='button' id='tambah' class='btn btn-success tambah1'>Tambah</button>
                    </td>@else 
                    <td>
                        <button type='button' id='tambah' class='btn btn-success tambah1'>+</button>
                        <button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>x</button>
                    </td>@endif
                </tr>
            @endforeach
        </table>
    </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
    <script>
        $(document).ready(function(){
            var no ="{{ count($biaya_mobil) }}";
            var count_paket= "{{ count($jenis_paket) }}";
            $(document).on('click', '.tambah1', function(){
                if (no == count_paket) {
                    alert("Jenis Paket sudah maksimal, jika ingin menambah jenis paket lain silahkan tambah jenis paket terlebih dahulu di Pengaturan");
                }else{
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><select name='jenis_paket[]' id='jenis_paket"+no+"' required>@foreach ($jenis_paket as $position)<option value='{{ $position->id }}'>{{ $position->jenis_paket }}</option>@endforeach</select></td><td><input class='form-control' type='number' name='investor[]' id='investor"+no+"' required></td><td><input class='form-control angka' type='number' name='danlap[]' id='danlap"+no+"' required></td><td><input class='form-control angka' type='number' name='driver[]' id='driver"+no+"' required></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah1'>+</button> <button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                }
            });

            $(document).on('click', '.btn_remove', function(){
                no = no-1;
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
            $(document).on('click', '.btn_removea', function(){
                no = no-1;
                var button_id = $(this).attr("id"); 
                $('#'+button_id+'').remove();
            });
        });
    </script>
@endsection