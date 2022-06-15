@extends('boilerplate::layout.index', [
    'title' => __('Mobil'),
    'subtitle' => __('Tambah Mobil'),
    'breadcrumb' => [
        __('Tambah Mobil') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.store-mobil']" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::select2 name="pemilik" label="Pilih Pemilik*" required>
                @foreach ($pemilik as $position)
                    <option value="{{ $position->id }}">{{ $position->nama }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="merek" label="Merek Mobil*" required/>
            <x-boilerplate::input name="tipe" label="Tipe Mobil*" required/>
            <x-boilerplate::input name="plat" label="Plat Nomor*" required/>
        </x-boilerplate::card>
        <x-boilerplate::card title="Biaya Mobil ">
            <table class="table" id="dynamic">
                <tr id="row">
                    <td>
                        <label for="investor">Jenis Paket*</label> <br>
                        <select name="jenis_paket[]" id="jenis_paket" required>
                            @foreach ($jenis_paket as $position)
                                <option value="{{ $position->id }}">{{ $position->jenis_paket }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="investor">Investor (Rupiah)*</label>
                        <input class="form-control" type="number" name="investor[]" id="investor" required>
                    </td>
                    <td>
                        <label for="danlap">Danlap (Rupiah)*</label>
                        <input class="form-control angka" type="number" name="danlap[]" id="danlap" required>
                    </td>
                    <td>
                        <label for="danlap">Driver (Rupiah)*</label>
                        <input class="form-control angka" type="number" name="driver[]" id="driver" required>
                    </td>
                    <td>
                        <br><button type="button" id="tambah" class="btn btn-success tambah1">Tambah</button>
                    </td>
                </tr>
            </table>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
    <script>
        $(document).ready(function(){
            var count_paket= "{{ count($jenis_paket) }}";
            var no =1;
            $(document).on('click', '.tambah1', function(){
                if (no == count_paket) {
                    alert("Jenis Paket sudah maksimal, jika ingin menambah jenis paket lain silahkan tambah jenis paket terlebih dahulu di Pengaturan");
                }else{
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><select name='jenis_paket[]' id='jenis_paket"+no+"' required>@foreach ($jenis_paket as $position)<option value='{{ $position->id }}'>{{ $position->jenis_paket }}</option>@endforeach</select></td><td><input class='form-control' type='number' name='investor[]' id='investor"+no+"' required></td><td><input class='form-control angka' type='number' name='danlap[]' id='danlap"+no+"' required></td><td><input class='form-control angka' type='number' name='driver[]' id='driver"+no+"' required></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah1'>+</button> <button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                }
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        });
    </script>
@endsection