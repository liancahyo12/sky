@extends('boilerplate::layout.index', [
    'title' => __('Booking'),
    'subtitle' => 'Jadwal Booking',
    'breadcrumb' => ['Jadwal Booking']]
)

@section('content')
    <x-boilerplate::card title="Jadwal Booking">
        <x-slot name="tools">
            Keterangan : 
            <span class="badge badge-pill badge-info">Book</span>
            <span class="badge badge-pill badge-secondary">Sedang berjalan</span>
            <span class="badge badge-pill badge-success">Selesai</span>
        </x-slot>
        
        <x-boilerplate::select2 name="mobil" id="mobil" label="Cari Berdasarakan Mobil" required>
                @foreach ($mobil as $position)
                    <option value="{{ $position->id }}">{{ $position->mobil }}</option>
                @endforeach
        </x-boilerplate::select2>
        @include('boilerplate::load.fullcalendar')
        @push('js')
        @component('boilerplate::minify')
            <script>
                var calendar;
                $(document).ready(function () {
                    // new way to init full calendar in v5
                    var calendarEl = document.getElementById('calendar');
                    // store calendar reference in global variable like below so you can use it later.
                    calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        },
                        buttonIcons: false,
                        navLinks: true,
                        dayMaxEvents: true,
                        locale: 'id',
                        eventSources: [
                            {
                                url: "{{ route('boilerplate.get-jadwal-mobil') }}?mobil_id=" + $('#mobil').val(),
                                failure: function() {
                                    alert('there was an error while fetching events!');
                                },
                            }
                        ]
                        
                    });
                    calendar.render();

                    
                    $('#mobil').on( "change", function() {
                        calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        },
                        buttonIcons: false,
                        navLinks: true,
                        dayMaxEvents: true,
                        locale: 'id',
                        eventSources: [
                            {
                                url: "{{ route('boilerplate.get-jadwal-mobil') }}?mobil_id=" + $('#mobil').val(),
                                failure: function() {
                                    alert('there was an error while fetching events!');
                                },
                            }
                        ]
                        
                    });
                    calendar.render();
                    });
                });

                
            </script>
        @endcomponent
        @endpush
        <div id='calendar'></div>
    </x-boilerplate::card>
@endsection