@extends('layouts.dashboard')

@section('title')
FAQs Management
@stop

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">FAQs Management</h2>

    {{-- رسالة نجاح --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    {{-- إضافة FAQ --}}
    <div class="card mb-4">

        <div class="card-header">
            Add New FAQ
        </div>

        <div class="card-body">

            <form action="{{ route('faqs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Question</label>

                    <input type="text"
                        name="question"
                        class="form-control"
                        placeholder="Enter question"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Answer</label>

                    <textarea name="answer"
                        class="form-control"
                        rows="3"
                        placeholder="Enter answer"
                        required></textarea>
                </div>

                <button class="btn btn-primary">
                    Add FAQ
                </button>

            </form>

        </div>

    </div>
    @endsection