@extends('layouts.app')

@section('page_title', 'Appointments')

@section('content')
@include('layouts.sidebar')

<table id="appointmentsTable" class="table">
    <thead>
        <tr>
            <th>Sr No</th>
            <th>Appointment Set By</th>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $key => $appointment)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                @if ($appointment->user)
                {{ $appointment->user->name }}
                @else
                User Not Found
                @endif
            </td>
            <td>{{ $appointment->event_name }}</td>
            <td>{{ $appointment->description }}</td>
            <td>{{ $appointment->date }}</td>
            <td>{{ $appointment->start_time }}</td>
            <td>{{ $appointment->end_time }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
