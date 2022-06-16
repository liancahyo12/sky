@extends('boilerplate::layout.index', [
    'title' => __('Pelanggan'),
    'subtitle' => 'Daftar Pelanggan',
    'breadcrumb' => ['Daftar Pelanggan']]
)

@section('content')
    <x-boilerplate::card title="Daftar Pelanggan">
        {{-- <x-slot name="tools">
            <a href="/buat-pelanggan"><button class="btn btn-primary">Tambah</button></a>
        </x-slot> --}}
        <x-boilerplate::datatable name="pelanggan" />
    </x-boilerplate::card>
@endsection