@extends('layouts.dashboard')

@section('title')
Review
@stop

@section('content')

<div class="container mt-4">

    <h2 class="mb-4 text-center">Review</h2>

    {{-- رسالة نجاح --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card p-4">

        <form action="{{ route('review.store') }}" method="POST">
            @csrf

            {{-- النجوم --}}
            <label class="form-label">Your Rate</label>

            <div class="mb-3">


                <p class="mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= ($Review ? $Review->rating : 0) ? 'gold' : 'gray' }}; font-size:25px;">★</span>
                        @endfor
                        {{ $Review ? $Review->rating : 0 }} / 5
                </p>

                <input type="hidden" name="rating" id="rating">
            </div>


            <div class="mb-3">
                <label class="form-label">Your Review</label>

                <textarea name="review"
                    class="form-control"
                    rows="4"
                    placeholder="Write your review"
                    required></textarea>
            </div>

            <button class="btn btn-primary w-100">
                Send your review
            </button>

        </form>

    </div>

</div>



@endsection