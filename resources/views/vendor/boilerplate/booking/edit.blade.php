@extends('boilerplate::layout.index', [
    'title' => __('Booking'),
    'subtitle' => __('Edit Booking'),
    'breadcrumb' => [
        __('Edit Booking') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.edit-booking', $booking->id]" method="put" files>
        @csrf
        <x-boilerplate::card title="Pelanggan">
            <div id="identitas_pelanggan">
                <x-boilerplate::input name="nama" id="nama" label="Nama*" value="{{ $booking->nama }}" disabled/>
                <div id="jenis_identitasa">
                    <x-boilerplate::select2 name="jenis_identitas" id="jenis_identitas" label="Pilih Jenis Identitas*" disabled>
                        @foreach ($jenis_identitas as $position)
                            <option value="{{ $position->id }}" @if ($position->id==$booking->jenis_identitas_id)
                                selected
                                @endif>{{ $position->jenis_identitas }}</option>
                        @endforeach
                    </x-boilerplate::select2>
                </div>
                <x-boilerplate::input name="no_identitas" id="no_identitas" label="No Identitas*" value="{{ $booking->no_identitas }}" disabled/>
                <x-boilerplate::input name="alamat" id="alamat" label="Alamat*" value="{{ $booking->alamat }}" disabled/>
                <x-boilerplate::input name="alias" id="alias" label="Alias" value={{ $booking->alias }} disabled/>
                <x-boilerplate::input name="group" id="group" label="Group" value="{{ $booking->group }}" disabled/>
                <x-boilerplate::input name="kenalan" id="kenalan" label="Kenalan" value="{{ $booking->kenalan }}" disabled/>
            </div>
        </x-boilerplate::card>
        <x-boilerplate::card title="Sewa">
            <x-boilerplate::daterangepicker name="tgl_sewa" id="tgl_sewa" label="Tanggal Sewa" timePicker="true" start="{{ $booking->awal_sewa }}" end="{{ $booking->akhir_sewa }}" required/>
            <x-boilerplate::select2 name="wilayah" id="wilayah" label="Pilih Wilayah*" required>
                @foreach ($wilayah as $position)
                    <option value="{{ $position->kode }}" @if ($position->kode==$booking->wilayah_id)
                        selected
                        @endif>{{ $position->nama }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="driver" id="driver" label="Pilih Driver*" required>
                <option value="xx" @if ($booking->driver_id==null)
                    selected
                    @endif> --- Tanpa Driver ---</option>
                @foreach ($driver as $position)
                    <option value="{{ $position->id }}" @if ($position->id==$booking->driver_id)
                        selected
                        @endif>{{ $position->nama }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="mobil" id="mobil" label="Pilih Mobil*" required>
            </x-boilerplate::select2>
            <div id="pilih_jenis">
                <x-boilerplate::select2 name="jenis_paket" id="jenis_paket" label="Pilih Paket*" required>
                </x-boilerplate::select2>
            </div>
            <div id="detail_paket">
                <table class="table">
                    <tr><td><b>Biaya Paket Per Hari</b></td></tr>
                </table>
                <x-boilerplate::input type="number" name="biaya_investor" id="biaya_investor" label="Investor*" class="angka" value="{{ $booking->biaya_investor }}" required/>
                <x-boilerplate::input type="number" name="biaya_danlap" id="biaya_danlap" label="Danlap*" class="angka" value="{{ $booking->biaya_danlap }}" required/>
                <x-boilerplate::input type="number" name="biaya_driver" id="biaya_driver" label="Driver*" class="angka" value="{{ $booking->biaya_driver }}" required/>
                <x-boilerplate::input type="number" name="biaya_bbmtol" id="biaya_bbmtol" label="BBM & Tol" class="angka" value="{{ $booking->biaya_bbmtol }}" />
                <table class="table">
                    <tr>
                        <td width="35%">
                            <x-boilerplate::input type="number" name="total_biayah" id="total_biayah" label="Total Biaya Per Hari" readonly/>
                        </td>
                        <td width="5%">
                            <br>
                            X
                        </td>
                        <td width="20%">
                            <x-boilerplate::input type="number" name="hari" id="hari" label="Hari" readonly/>
                        </td>
                        <td width="40%">
                            <x-boilerplate::input type="number" name="total_biaya" id="total_biaya" label="Total Biaya" readonly/>
                        </td>
                    </tr>
                    <tr>
                        <td width="35%">
                            <x-boilerplate::input type="number" name="biaya_admh" id="biaya_admh" label="Admin Per Hari (10% dari Biaya Investor)" readonly/>
                        </td>
                        <td width="5%">
                            <br>
                            X
                        </td>
                        <td width="20%">
                            <x-boilerplate::input type="number" name="hari2" id="hari2" label="Hari" readonly/>
                        </td>
                        <td width="40   %">
                            <x-boilerplate::input type="number" name="biaya_adm" id="biaya_adm" label="Total Admin" readonly/>
                        </td>
                    </tr>
                </table>
            </div>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
    <script>

        $(document).ready(function () {
            var tgl_sewas = '';
            var tgl_sewae = '';
            var tgl_sewas1 = '';
            var tgl_sewae1 = '';
            $('input[name^="tgl_sewa[start]"]').each(function() {
                tgl_sewas = new Date($(this).val().substring(0, 10));
                tgl_sewas1 = $(this).val();
                
            });
            $('input[name^="tgl_sewa[end]"]').each(function() {
                tgl_sewae = new Date($(this).val().substring(0, 10));
                tgl_sewae1 = $(this).val();
            });
            var hari = ((tgl_sewae-tgl_sewas)/ (1000 * 3600 * 24))+1;
            $('#hari').val(hari);
            $('#hari2').val(hari);
    
            $.ajax({
                url: "{{ route('boilerplate.gete-mobils') }}?booking_id={{ $booking->id }}"+"&start=" + tgl_sewas1 + "&end=" + tgl_sewae1,
                method: 'GET',
                success: function(data) {
                    $('#mobil').html(data.html);
                    $('#mobil').val('{{ $booking->mobil_id }}');
                }
            });

            $.ajax({
                url: "{{ route('boilerplate.get-paket') }}?mobil_id={{ $booking->mobil_id }}&wilayah={{ $booking->wilayah_id }}",
                method: 'GET',
                success: function(data) {
                    $('#jenis_paket').html(data.html);
                    $('#jenis_paket').val('{{ $booking->biaya_mobil_id }}');
                }
            });

            if ('{{ $booking->driver_id }}'>0) {
                
            }else{
                $('#biaya_driver').val('');
                $('#biaya_driver').prop('required',false);
                $('#biaya_driver').prop( "disabled", true );
            }
            hitungTotal();
        });

        $(document).on('click', '.daterangepicker-input', function(){
            $('#tgl_sewa').on('change', function(){
                var tgl_sewas = '';
                var tgl_sewae = '';
                var tgl_sewas1 = '';
                var tgl_sewae1 = '';
                $('input[name^="tgl_sewa[start]"]').each(function() {
                    tgl_sewas = new Date($(this).val().substring(0, 10));
                    tgl_sewas1 = $(this).val();
                    
                });
                $('input[name^="tgl_sewa[end]"]').each(function() {
                    tgl_sewae = new Date($(this).val().substring(0, 10));
                    tgl_sewae1 = $(this).val();
                });
                var hari = ((tgl_sewae-tgl_sewas)/ (1000 * 3600 * 24))+1;
                $('#hari').val(hari);
                $('#hari2').val(hari);
                if ($('#jenis_paket').val() > 0) {
                    hitungTotal();
                }
        
                $.ajax({
                    url: "{{ route('boilerplate.gete-mobils') }}?booking_id={{ $booking->id }}"+"&start=" + tgl_sewas1 + "&end=" + tgl_sewae1,
                    method: 'GET',
                    success: function(data) {
                        $('#mobil').html(data.html);
                    }
                });
            });
        });


        $('#mobil').on('change', function(){
            $("#pilih_jenis").show();
            $.ajax({
                url: "{{ route('boilerplate.get-paket') }}?mobil_id=" + $(this).val() + "&wilayah=" + $('#wilayah').val(),
                method: 'GET',
                success: function(data) {
                    $('#jenis_paket').html(data.html);
                    $("#detail_paket").hide();
                    $('#biaya_investor').val('');
                    $('#biaya_danlap').val('');
                    $('#biaya_driver').val('');
                    $('#biaya_bbmtol').val('');
                }
            });
        });

        $('#driver').on('change', function(){
            if ($("#driver").val()=="xx") {
                $('#biaya_driver').val('');
                $('#biaya_driver').prop('required',false);
                $('#biaya_driver').prop( "disabled", true );
                hitungTotal();
            }else{
                $('#biaya_driver').prop( "disabled", false );
                $('#biaya_driver').prop('required',true);
                if ($('#jenis_paket').val() > 0) {
                    $.ajax({
                        url: "{{ route('boilerplate.get-detail-paket') }}?jenis_paket_id=" + $('#jenis_paket').val(),
                        method: 'GET',
                        success: function(data) {
                            $('#biaya_driver').val(data.biaya_driver);
                            if ($('#jenis_paket').val() > 0) {
                                hitungTotal();
                            }
                        }
                    });
                }
            }
            
        });

        $('#wilayah').on('change', function(){
            if ($('#mobil').val() > 0) {
                $.ajax({
                    url: "{{ route('boilerplate.get-paket') }}?mobil_id=" + $('#mobil').val() + "&wilayah=" + $(this).val(),
                    method: 'GET',
                    success: function(data) {
                        $('#jenis_paket').html(data.html);
                    }
                });
            }
        });

        $('#jenis_paket').on('change', function(){
            $("#detail_paket").show();
            $.ajax({
                url: "{{ route('boilerplate.get-detail-paket') }}?jenis_paket_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#biaya_investor').val(data.biaya_investor);
                    $('#biaya_danlap').val(data.biaya_danlap);
                    $('#biaya_driver').val(data.biaya_driver);
                    $('#biaya_bbmtol').val(data.biaya_bbmtol);
                    $('#total_biayah').val(data.total_biaya);
                    $('#biaya_admh').val(data.total_biaya*10/100);
                    hitungTotal();
                    if ($("#driver").val()=="xx") {
                        $('#biaya_driver').val('');
                        $('#biaya_driver').prop( "disabled", true );
                        $('#biaya_driver').prop('required', false);
                    }
                }
            });
            
        });

        $('#status_pelanggan').on('change', function(){
            var radios = document.getElementsByName('pelanggan_radio');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    // do whatever you want with the checked radio
                    if (radios[i].value == 1) {
                        $("#pilih_pelanggan").hide();
                        $("#pelanggan").prop('required', false);
                        $("#identitas_pelanggan").show();
                        $("#foto").show();
                        $("#foto_identitas").prop('required', true);
                        $('#jenis_identitas').attr('readonly', false);
                        $('#nama').attr('readonly', false);
                        $('#no_identitas').attr('readonly', false);
                        $('#alias').attr('readonly', false);
                        $('#group').attr('readonly', false);
                        $('#alamat').attr('readonly', false);
                        $('#kenalan').attr('readonly', false);
                        $('#nama').val('');
                        $('#no_identitas').val('');
                        $('#alias').val('');
                        $('#group').val('');
                        $('#alamat').val('');
                        $('#kenalan').val('');
                        $('#jenis_identitas').val('');
                        $('#jenis_identitas').html('<option disabled selected value></option>@foreach ($jenis_identitas as $position)<option value="{{ $position->id }}">{{ $position->jenis_identitas }}</option> @endforeach');
                    }else{
                        $("#pilih_pelanggan").show();
                        $("#pelanggan").prop('required', true);
                        $("#identitas_pelanggan").hide();
                        $.ajax({
                            url: "{{ route('boilerplate.get-pelanggans') }}?pelanggan_radio=" + radios[i].value,
                            method: 'GET',
                            success: function(data) {
                                $('#pelanggan').html(data.html);
                            }
                        });
                    }
                    // only one radio can be logically checked, don't check the rest
                    break;
                }
            }
        });
        $('#pelanggan').on('change', function(){
            $("#identitas_pelanggan").show();
            $("#foto").hide();
            $("#foto_identitas").prop('required', false);
            $('#nama').attr('readonly', true);
            $('#jenis_identitas').attr('readonly', true);
            $('#no_identitas').attr('readonly', true);
            $('#alias').attr('readonly', true);
            $('#group').attr('readonly', true);
            $('#alamat').attr('readonly', true);
            $('#kenalan').attr('readonly', true);
            $.ajax({
                url: "{{ route('boilerplate.get-pelanggan') }}?pelanggan_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#nama').val(data.nama);
                    $('#jenis_identitas').html(data.jenis_identitas);
                    $('#no_identitas').val(data.no_identitas);
                    $('#alias').val(data.alias);
                    $('#group').val(data.group);
                    $('#alamat').val(data.alamat);
                    $('#kenalan').val(data.kenalan);
                }
            });
        });

        $(document).on('input', '.angka', hitungTotal);

        function hitungTotal() {
            var total = 0;
            var hari = 0;
            $(".angka").each(function () {
                var angka = $(this).val();
                var angka2 = $('#hari').val();
                var angka3 = $('#biaya_investor').val();
                if ($.isNumeric(angka)) {
                    total += parseFloat(angka);
                    byinvestor = parseFloat(angka3);
                }                  
                if ($.isNumeric(angka2)) {
                    hari = parseFloat(angka2);
                }                  
            });
            document.getElementById("total_biayah").value = total;
            document.getElementById("biaya_admh").value = byinvestor*10/100;
            document.getElementById("total_biaya").value = total*hari;
            document.getElementById("biaya_adm").value = byinvestor*10/100*hari;
        }
    </script>
@endsection