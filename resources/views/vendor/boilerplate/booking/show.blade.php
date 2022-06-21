@extends('boilerplate::layout.index', [
    'title' => __('Booking'),
    'subtitle' => __('Detail Booking'),
    'breadcrumb' => [
        __('Detail Booking') 
    ]
])

@section('content')
    <x-boilerplate::card>
        <table width="100%">
            <tr>
                <td width="90%">
                    <h5>Booking</h5>
                </td>   
                <td>
                    <table>
                        <tr>
                            <td>
                                <div id="status_tagihan">
                                    @if ($booking->status_tagihan == 1)
                                        <span class="badge badge-pill badge-info float-right">Tagihan: belum dibayar</span>
                                    @elseif($booking->status_tagihan == 2)
                                        <span class="badge badge-pill badge-success float-right">Tagihan: lunas</span>
                                    @elseif($booking->status_tagihan == 3)
                                        <span class="badge badge-pill badge-warning float-right">Tagihan: dibayar sebagian</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if ($booking->booking_status == 1)
                                    <span class="badge badge-pill badge-info float-right">Booking: book</span>
                                @elseif($booking->booking_status == 2)
                                    <span class="badge badge-pill badge-secondary float-right">Booking: sedang berjalan</span>
                                @elseif($booking->booking_status == 3)
                                    <span class="badge badge-pill badge-success float-right">Booking: selesai</span>
                                @elseif($booking->booking_status == 4)
                                    <span class="badge badge-pill badge-danger float-right">Booking: batal</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <x-boilerplate::input name="noinvoice" id="noinvoice" label="Nomor Tagihan" value="{{ $booking->noinvoice    }}" disabled/>
        <x-boilerplate::input name="tagihan" id="tagihan" label="Sisa Tagihan" value="{{ $booking->sisa_tagihan }}" disabled/>
        @if( $booking->booking_status==1 )
            @permission('proses_booking')
            <a href="/proses-booking/{{ $booking->id }}"><button data-action="book" class="btn btn-warning">Proses</button></a>
            @endpermission
        @elseif( $booking->booking_status==2 )
            @permission('selesai_booking')
            <a href="/selesai-booking/{{ $booking->id }}"><button data-action="book" class="btn btn-success">Selesaikan</button></a>
            @endpermission
        @endif
        @permission('cetak_tagihan')
        <a href="/cetak-tagihan/{{ $booking->id }}.pdf" target="_blank"><button class="btn btn-info">Cetak Tagihan</button></a>
        @endpermission
        <div><br></div>
        <div>
            <x-boilerplate::card>
                <table width="100%">
                    <tr>
                        <td width="100%">
                            <h5>Pembayaran</h5>
                        </td>
                        <td>
                            @if ($booking->status_tagihan==1 || $booking->status_tagihan==3)
                            @permission('bayar_booking')
                            <a href="/bayar-booking/{{ $booking->id }}"><button class="btn btn-primary">Bayar</button></a>
                            @endpermission
                            @endif
                        </td>
                    </tr>
                </table>
                <x-boilerplate::datatable name="pembayaran" :ajax="['id' => $booking->id]"/>
            </x-boilerplate::card>
        </div>
    </x-boilerplate::card>
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
        <x-boilerplate::daterangepicker name="tgl_sewa" id="tgl_sewa" label="Tanggal Sewa" start="{{ $booking->awal_sewa }}" end="{{ $booking->akhir_sewa }}" timePicker="true" disabled/>
        <x-boilerplate::select2 name="wilayah" id="wilayah" label="Pilih Wilayah*" disabled>
            @foreach ($wilayah as $position)
                <option value="{{ $position->kode }}" @if ($position->kode==$booking->wilayah_id)
                    selected
                    @endif>{{ $position->nama }}</option>
            @endforeach
        </x-boilerplate::select2>
        <x-boilerplate::select2 name="driver" id="driver" label="Pilih Driver*" disabled>
            <option value="xx"> --- Tanpa Driver ---</option>
            @foreach ($driver as $position)
                <option value="{{ $position->id }}" @if ($position->id==$booking->driver_id)
                    selected
                    @endif>{{ $position->nama }}</option>
            @endforeach
        </x-boilerplate::select2>
        <x-boilerplate::select2 name="mobil" id="mobil" label="Pilih Mobil*" disabled>
            <option value="{{ $booking->mobil_id }}" selected>{{ $booking->mobil }}</option>
        </x-boilerplate::select2>
        <div id="pilih_jenis">
            <x-boilerplate::select2 name="jenis_paket" id="jenis_paket" label="Pilih Paket*" disabled>
                <option value="{{ $booking->jenis_paket_id }}" selected>{{ $booking->jenis_paket }}</option>
            </x-boilerplate::select2>
        </div>
        <div id="detail_paket">
            <table class="table">
                <tr><td><b>Biaya Paket Per Hari</b></td></tr>
            </table>
            <x-boilerplate::input type="number" name="biaya_investor" id="biaya_investor" label="Investor*" class="angka" value="{{ $booking->biaya_investor }}" disabled/>
            <x-boilerplate::input type="number" name="biaya_danlap" id="biaya_danlap" label="Danlap*" class="angka" value="{{ $booking->biaya_danlap }}" disabled/>
            <x-boilerplate::input type="number" name="biaya_driver" id="biaya_driver" label="Driver*" class="angka" value="{{ $booking->biaya_driver }}" disabled/>
            <x-boilerplate::input type="number" name="biaya_bbmtol" id="biaya_bbmtol" label="BBM & Tol" class="angka" value="{{ $booking->biaya_bbmtol }}" disabled/>
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

            hitungTotal();
        });

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

        $(document).on('hidden.bs.modal', function(event) {
            $.ajax({
                url: "{{ route('boilerplate.get-tagihan') }}?id={{ $booking->id }}",
                method: 'GET',
                success: function(data) {
                    $('#tagihan').val(data.id);
                    if (data.status_tagihan==1) {
                        $('#status_tagihan').html('<span class="badge badge-pill badge-info float-right">Tagihan: belum dibayar</span>');
                    }
                    else if (data.status_tagihan==2) {
                        $('#status_tagihan').html('<span class="badge badge-pill badge-success float-right">Tagihan: lunas</span>');
                    }else{
                        $('#status_tagihan').html('<span class="badge badge-pill badge-warning float-right">Tagihan: dibayar sebagian</span>');
                    }
                }
            });
        });
    </script>
    <script src="{{ mix('/ekko-lightbox.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script>
        $(function () {
          $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
              alwaysShowClose: true
            });
          });
        })
    </script>
@endsection