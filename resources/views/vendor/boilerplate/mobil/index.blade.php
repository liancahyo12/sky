@extends('boilerplate::layout.index', [
    'title' => __('Mobil'),
    'subtitle' => 'Daftar Mobil',
    'breadcrumb' => ['Daftar Mobil']]
)

@section('content')
    <x-boilerplate::card title="Daftar Mobil">
        <x-slot name="tools">
            <a href="/buat-mobil"><button class="btn btn-primary">Tambah</button></a>
        </x-slot>
        <x-boilerplate::datatable name="mobil" />
    </x-boilerplate::card>
@endsection