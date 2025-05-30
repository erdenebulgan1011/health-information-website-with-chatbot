<!-- resources/views/events/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Үйл явдлын жагсаалт')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Үйл явдлууд</h1>
        <a href="{{ route('events.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Шинэ Үйл явдал нэмэх
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Бүртгэгдсэн Үйл явдлууд
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="events-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Гарчиг</th>
                        <th>Тайлбар</th>
                        <th>Эхлэх хугацаа</th>
                        <th>Дуусах хугацаа</th>
                        <th>Байршил</th>
                        <th>URL</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this section -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@push('scripts')
<script>
$(document).ready(function() {
    const eventsTable = $('#events-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('events.index') }}",
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'start_time', name: 'start_time' },
            { data: 'end_time', name: 'end_time' },
            { data: 'location', name: 'location' },
            {
                data: 'url',
                name: 'url',
                render: function(data) {
                    return data ? `<a href="${data}" target="_blank">Линк</a>` : '';
                }
            },
            {
                data: 'id',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                    <div class="d-flex gap-2">
                        <a href="${row.show_url}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="${row.edit_url}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="${row.delete_url}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Устгахдаа итгэлтэй байна уу?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>`;
                }
            }
        ]
    });
});
</script>
@endpush
