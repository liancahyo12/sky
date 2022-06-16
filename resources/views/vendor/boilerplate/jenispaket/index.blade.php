@extends('boilerplate::layout.index', [
    'title' => __('Jenis Paket'),
    'subtitle' => 'Daftar Jenis Paket',
    'breadcrumb' => ['Daftar Jenis Paket']]
)

@section('content')
<x-boilerplate::card title="Daftar Jenis Paket">
    <x-slot name="tools">
        <a href="/buat-jenispaket"><button class="btn btn-primary">Tambah</button></a>
    </x-slot>
            <x-boilerplate::datatable name="jenispaket" />
    </x-boilerplate::card>
@endsection