<!-- resources/views/admin/vr/index.blade.php -->
@extends('layouts.admin')

@section('title', 'VR Контентын жагсаалт')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">VR Контентууд</h1>
        <a href="{{ route('vr.create') }}" class="btn btn-success"> <!-- 'admin.vr.create' биш -->
    <i class="fas fa-plus"></i> Шинэ контент
</a>

    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Бүртгэгдсэн VR контентууд
        </div>
        <div class="card-body">
            <table id="vr-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Гарчиг</th>
                        <th>Ангилал</th>
                        <th>Төлөв</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vrContents as $content)
                    <tr>
                        <td>{{ $content->id }}</td>
                        <td>{{ $content->title }}</td>
                        <td>{{ $content->category->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $content->status === 'published' ? 'success' : 'secondary' }}">
                                {{ $content->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                            <a href="{{ route('vr.show', $content->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> харуулах</a>

                            <a href="{{ route('vr.edit', $content->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Засах</a>
    <!-- Устгах код -->

                                <form action="{{ route('vr.destroy', $content->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Устгахдаа итгэлтэй байна уу?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Мэдээлэл олдсонгүй</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                {{ $vrContents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
      $('#vr-table').DataTable({
        // optional: pageLength, ordering, language, etc.
      });
    });
    </script>
@endpush





