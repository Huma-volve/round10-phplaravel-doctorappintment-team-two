@extends('layouts.dashboard')

@section('title')
Policy Management
@stop

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Policy Management</h2>

    {{-- رسالة نجاح --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- إضافة Policy --}}
    <div class="card mb-4">

        <div class="card-header">
            Add New Policy
        </div>

        <div class="card-body">

            <form action="{{ route('policies.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>

                    <input type="text"
                        name="title"
                        class="form-control"
                        placeholder="Enter policy title"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>

                    <textarea name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Enter policy description"
                        required></textarea>
                </div>

                <button class="btn btn-primary">
                    Add Policy
                </button>

            </form>

        </div>

    </div>

</div>

@endsection