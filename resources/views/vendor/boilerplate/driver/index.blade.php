@extends('boilerplate::layout.index', [
    'title' => __('Driver'),
    'subtitle' => 'Daftar Driver',
    'breadcrumb' => ['Daftar Driver']]
)

@section('content')
    <x-boilerplate::card title="Daftar Driver">
        <x-slot name="tools">
            <a href="/buat-driver"><button class="btn btn-primary">Tambah</button></a>
        </x-slot>
        <x-boilerplate::datatable name="driver" />
    </x-boilerplate::card>
@endsection