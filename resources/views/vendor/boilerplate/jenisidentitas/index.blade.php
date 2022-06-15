@extends('boilerplate::layout.index', [
    'title' => __('Jenis Identitas'),
    'subtitle' => 'Daftar Jenis Identitas',
    'breadcrumb' => ['Daftar Jenis Identitas']]
)

@section('content')
<x-boilerplate::card title="Daftar Jenis Identitas">
    <x-slot name="tools">
        <a href="/buat-jenisidentitas"><button class="btn btn-primary">Tambah</button></a>
    </x-slot>
            <x-boilerplate::datatable name="jenisidentitas" />
    </x-boilerplate::card>
@endsection