@extends('boilerplate::layout.index', [
    'title' => __('Selamat Datang'),
    'subtitle' => '',
    'breadcrumb' => ['Dashboard']]
)

@section('content')
    <x-boilerplate::card title="Jadwal Hari Ini">
        <x-slot name="tools">
            <a href="/jadwal"><button class="btn btn-primary">Lihat Jadwal</button></a>
        </x-slot>
        <x-boilerplate::datatable name="jadwal-hari-ini" />
    </x-boilerplate::card>
    <x-boilerplate::card title="Mobil Tersedia Hari Ini">
        <x-boilerplate::datatable name="mobil-hari-ini" />
    </x-boilerplate::card>
    <x-boilerplate::card title="Driver Tersedia Hari Ini">
        <x-boilerplate::datatable name="driver-hari-ini" />
    </x-boilerplate::card>
    <x-boilerplate::card title="Pendapatan Bulan Ini">
        <x-slot name="tools">
            <a href="/transaksi"><button class="btn btn-primary">Lihat Rekapitulasi</button></a>
        </x-slot>
        <x-boilerplate::datatable name="pendapatan-bulan-ini" />
    </x-boilerplate::card>
@endsection