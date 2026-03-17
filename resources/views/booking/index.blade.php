
@extends('layouts.dashboard')




@section('content')
    <!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
</head>
<body>

<h1>Appointments List</h1>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Doctor_name</th>
        <th>Patient_name</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    @foreach($appointments as $appointment)
        <tr>
            <td>{{ $appointment->id }}</td>
            <td>{{ $appointment->doctor->user->name }}</td>
            <td>{{ $appointment->patient->user->name }}</td>
            <td>{{ $appointment->Status }}</td>
            <td>{{ $appointment->appointment_time }}</td>
        </tr>
    @endforeach

</table>

</body>
</html>
@endsection
