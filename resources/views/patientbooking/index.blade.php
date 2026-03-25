
@extends('layouts.dashboard')




@section('content')
<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Appointment Time</th>
            <th>Payment Method</th>
            <th>Appointment Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>

                <td>
                    {{-- {{$appointment->patient->user->name?? '-' }} --}}
                    <span class="">
                        {{ $appointment->patient->user->role == 'patient' ? $appointment->patient->user->name : '-' }}
                    </span>
                </td>

                <td>
                    {{ $appointment->appointment_time }}
                </td>

                <td>
                    {{ $appointment->payment->payment_method ??'stripe'}}
                </td>

              <td>
                @if($appointment->Status == 'confirmed')
                    <span class="badge bg-success">Confirmed</span>
                @elseif($appointment->Status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($appointment->Status == 'cancelled')
                    <span class="badge bg-danger">Cancelled</span>
                @elseif($appointment->Status == 'completed')
                    <span class="badge bg-danger">completed</span>
                @elseif($appointment->Status == 'resceduled')
                    <span class="badge bg-danger">resceduled</span>
                @else
                    <span class="badge bg-secondary">{{ $appointment->status }}</span>
                @endif
            </td>

            </tr>
        @endforeach
    </tbody>
</table>
@endsection
