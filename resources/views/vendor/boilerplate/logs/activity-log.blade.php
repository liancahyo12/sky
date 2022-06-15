@extends('boilerplate::layout.index', [
    'title' => __('Logs'),
    'subtitle' => 'Audit Trail',
    'breadcrumb' => ['Audit Trail']]
)

@section('content')
    <x-boilerplate::card title="Audit Trail">
        <x-boilerplate::datatable name="activity-log" />
    </x-boilerplate::card>
@endsection