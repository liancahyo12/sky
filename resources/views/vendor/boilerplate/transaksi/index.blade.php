@extends('boilerplate::layout.index', [
    'title' => __('Rekapitulasi'),
    'subtitle' => 'Daftar Transaksi',
    'breadcrumb' => ['Daftar Transaksi']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Rekapitulasi Bulanan (Tagihan Lunas)
        </x-slot>
            <x-boilerplate::datatable name="rekapitulasi" />
    </x-boilerplate::card>

    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Transaksi
        </x-slot>
            <x-boilerplate::datatable name="transaksi" />
    </x-boilerplate::card>
@endsection