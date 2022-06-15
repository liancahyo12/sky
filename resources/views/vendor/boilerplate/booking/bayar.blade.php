@extends('boilerplate::layout.index', [
    'title' => __('Bayar'),
    'subtitle' => __('Bayar Tagihan'),
    'breadcrumb' => [
        __('Bayar Tagihan') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.store-bayar-booking', $tagihan->id]" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="noinvoice" label="Nomor Tagihan" value="{{ $tagihan->noinvoice }}" readonly/>
            <x-boilerplate::input name="sisa_tagihan" type="number" label="Sisa Tagihan" value="{{ $tagihan->sisa_tagihan }}" readonly/>
            <x-boilerplate::input name="pembayaran" type="number" label="Jumlah Pembayaran*" required/>
            <x-boilerplate::datetimepicker name="waktu_bayar" label="Waktu Pembayaran*" format="DD/MM/YYYY HH:mm" required/>
            <x-boilerplate::input name="bukti_bayar" type="file" label="Bukti Bayar (JPG Maks 500KB)*" required/>
            <x-boilerplate::input name="keterangan" label="Keterangan" required/>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection