@extends('layouts.dashboard')

@section('title', 'Chat')

@section('content')

<!-- display success message -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom py-3" style="border-radius: 12px 12px 0 0;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="card-title mb-0 fw-bold text-dark">Users</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Phone Code</th>
                                    <th>Birthdate</th>
                                    <th>Role</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile_number }}</td>
                                        <td>{{ $user->phone_code }}</td>
                                        <td>{{ $user->birthdate }}</td>
                                        <!-- role patient with color and admin and doctor -->
                                        <td>
                                            @if($user->role == 'patient')
                                                <span class="badge bg-primary">{{ $user->role }}</span>
                                            @elseif($user->role == 'admin')
                                                <span class="badge bg-danger">{{ $user->role }}</span>
                                            @elseif($user->role == 'doctor')
                                                <span class="badge bg-info">{{ $user->role }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->latitude }}</td>
                                        <td>{{ $user->longitude }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this user?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
