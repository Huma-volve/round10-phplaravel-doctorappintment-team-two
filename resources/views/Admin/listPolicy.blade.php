@extends('layouts.dashboard')

@section('title')
Policies Management
@stop

@section('content')

<div class="container mt-4">

    {{-- رسالة نجاح --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <h5 class="text-center mb-4" style="font-size:30px; font-family: 'Poppins', sans-serif;">
        <i class="fa fa-question-circle"></i> privacy policy
    </h5>

    @forelse($policies as $policy)

    <div class="mb-4 text-left">

        <h5 style="font-weight:600; font-size:18px; margin-bottom:5px;">
            {{ $policy->title }}
        </h5>

        <p class="text-muted" style="line-height:1.6; margin-bottom:10px;">
            {{ $policy->description }}
        </p>



        <hr>

    </div>

    @empty
    <div class="text-left text-muted p-4">
        No Policies Found
    </div>
    @endforelse

</div>

@endsection