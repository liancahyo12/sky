@extends('boilerplate::layout.index', [
    'title' => __('Booking'),
    'subtitle' => 'Daftar Booking',
    'breadcrumb' => ['Daftar Booking']]
)

@section('content')
    <x-boilerplate::card title="Daftar Booking">
        <x-slot name="tools">
            @permission('buat_booking')
            <a href="/buat-booking"><button class="btn btn-primary">Tambah</button></a>
            @endpermission
        </x-slot>
        <x-boilerplate::datatable name="booking" />
    </x-boilerplate::card>
@endsection