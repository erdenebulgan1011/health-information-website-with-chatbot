<!-- resources/views/diseases/admin/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Manage Diseases')

@section('content')
<div class="container">
    <h2 class="mb-4">Manage Diseases</h2>

    <a href="{{ route('admin.diseases.create') }}" class="btn btn-primary mb-3">Add New Disease</a>

    <table id="diseases-table" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Disease Name</th>
                <th>Common Symptom</th>
                <th>Treatment</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts') <!-- This ensures your page-specific scripts are loaded in the correct order -->
<script>
    $(document).ready(function() {
        $('#diseases-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.diseases.data') }}",  // Ensure this route is correctly defined in routes/web.php
            columns: [
                { data: 'id', name: 'id' },
                { data: 'disease_name', name: 'disease_name' },
                { data: 'common_symptom', name: 'common_symptom' },
                { data: 'treatment', name: 'treatment' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pageLength: 20, // Show 20 entries per page
        });
    });
</script>
@endpush
