<!-- resources/views/admin/categories/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Эрүүл Мэндийн Ангиллууд')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Эрүүл Мэндийн Ангиллууд</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Шинэ Ангилал Нэмэх
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger mb-4" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Бүртгэгдсэн   Ангиллууд
        </div>
        <div class="card-body">
            <table id="category_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Нэр</th>
                        <th>Slug</th>
                        <th>Тайлбар</th>
                        <th>VR Контент</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td><a href="{{ route('categories.showItems', $category->slug) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> {{ $category->vr_contents_count }}</a></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Засах
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Энэ ангилалыг устгахдаа итгэлтэй байна уу?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Ангилал олдсонгүй</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-end">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
  $('#category_table').DataTable({
    pagingType: 'simple',        // keeps only “Previous / Next”
    info: true,                  // shows the info line
    language: {
      paginate: {
        previous: 'Өмнөх',      // “« Өмнөх”
        next: 'Дараах'           // “Дараах »”
      },
      info: 'Нийт _TOTAL_ бичлэгээс _START_-с _END_ харуулж байна',
      zeroRecords: 'Мэдээлэл олдсонгүй',
      search: 'Хайх:',
      lengthMenu: 'Нэг хуудас бүрт _MENU_ бичлэг'
    }
  });
});
</script>
    </script>
@endpush
