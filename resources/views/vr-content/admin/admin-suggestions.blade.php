@extends('layouts.admin')
@section('title', 'Санал болгосон 3D загварууд')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Хэрэглэгчдийн санал болгосон 3D загварууд</h1>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-cubes me-1"></i>
                Санал болгосон загварууд
            </div>
            <div class="d-flex">
                <div class="dropdown me-2">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter"></i> Төлөв шүүх
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="{{ route('vr.admin.suggestions') }}">Бүгд</a></li>
                        <li><a class="dropdown-item" href="{{ route('vr.admin.suggestions', ['status' => 'pending']) }}">Хүлээгдэж буй</a></li>
                        <li><a class="dropdown-item" href="{{ route('vr.admin.suggestions', ['status' => 'approved']) }}">Зөвшөөрсөн</a></li>
                        <li><a class="dropdown-item" href="{{ route('vr.admin.suggestions', ['status' => 'rejected']) }}">Цуцалсан</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($suggestions->count() > 0)
                <form id="bulk-action-form" action="{{ route('vr.admin.suggestions.bulk') }}" method="POST" class="d-inline">
                    @csrf
                    <div class="mb-3 d-flex">
                        <select name="action" class="form-select me-2" style="width: auto;">
                            <option value="">-- Сонгосон бичлэгүүдэд үйлдэл хийх --</option>
                            <option value="approve">Зөвшөөрөх</option>
                            <option value="reject">Цуцлах</option>
                            <option value="delete">Устгах</option>
                        </select>
                        <button type="submit" class="btn btn-primary" id="bulk-action-btn" disabled>
                            Гүйцэтгэх
                        </button>
                        <div class="ms-3">
                            <input type="text" class="form-control" name="admin_notes" placeholder="Админы тэмдэглэл">
                        </div>
                    </div>

                    <table id="suggestions-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Гарчиг</th>
                                <th>Ангилал</th>
                                <th>Хэрэглэгч</th>
                                <th>Огноо</th>
                                <th>Төлөв</th>
                                <th>Үйлдэл</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suggestions as $suggestion)
                            <tr>
                                <td>
                                    <input type="checkbox" name="suggestion_ids[]" value="{{ $suggestion->id }}" class="suggestion-checkbox">
                                </td>
                                <td>{{ $suggestion->title }}</td>
                                <td>{{ $suggestion->category->name }}</td>
                                <td>{{ $suggestion->user->name }}</td>
                                <td>{{ $suggestion->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($suggestion->status == 'pending')
                                        <span class="badge bg-warning text-dark">Хүлээгдэж буй</span>
                                    @elseif($suggestion->status == 'approved')
                                        <span class="badge bg-success">Зөвшөөрсөн</span>
                                    @else
                                        <span class="badge bg-danger">Цуцалсан</span>
                                    @endif
                                </td>
                            </form>

                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('vr.admin.reviewSuggestion', $suggestion->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('vr.admin.suggestions.edit', $suggestion->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $suggestion->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Status quick change buttons -->
                                    <div class="mt-1">
                                        @if($suggestion->status != 'approved')
                                            <form action="{{ route('vr.admin.suggestions.status', $suggestion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-outline-success">approved
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($suggestion->status != 'rejected')
                                            <form action="{{ route('vr.admin.suggestions.status', $suggestion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">rejected
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($suggestion->status != 'pending')
                                            <form action="{{ route('vr.admin.suggestions.status', $suggestion->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="btn btn-sm btn-outline-warning">pending
                                                    <i class="fas fa-clock"> </i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $suggestion->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $suggestion->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $suggestion->id }}">Санал устгах</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Та "<strong>{{ $suggestion->title }}</strong>" саналыг устгахдаа итгэлтэй байна уу?</p>
                                                    @if($suggestion->status == 'approved')
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle"></i> Анхааруулга: Энэ саналыг устгаснаар холбогдох VR контент мөн устгагдах болно.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Цуцлах</button>
                                                    <form action="{{ route('vr.admin.suggestions.destroy', $suggestion->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Устгах</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                <div class="mt-3">
                    {{ $suggestions->links() }}
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle"></i> Санал болгосон загвар байхгүй байна.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables & Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize DataTable
        const table = $('#suggestions-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/mn.json'
            },
            pageLength: 10,
            order: [[4, 'desc']],
            columnDefs: [
                { orderable: false, targets: [0, 6] }
            ]
        });

        // Handle select all checkbox
        $('#select-all').change(function() {
            $('.suggestion-checkbox').prop('checked', $(this).prop('checked'));
            updateBulkActionButton();
        });

        // Handle individual checkboxes
        $('.suggestion-checkbox').change(function() {
            updateBulkActionButton();

            // If any checkbox is unchecked, uncheck the "select all" checkbox
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            }

            // If all checkboxes are checked, check the "select all" checkbox
            else if ($('.suggestion-checkbox:checked').length === $('.suggestion-checkbox').length) {
                $('#select-all').prop('checked', true);
            }
        });

        // Update bulk action button state
        function updateBulkActionButton() {
            $('#bulk-action-btn').prop('disabled', $('.suggestion-checkbox:checked').length === 0);
        }

        // Confirm bulk actions
        $('#bulk-action-form').submit(function(e) {
            $('#bulk-action-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        const action = $('select[name="action"]').val();
        if (!action) {
            alert('Үйлдэл сонгоно уу!');
            return false;
        }

        // Collect all checked IDs
        const selectedIds = $('.suggestion-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Дор хаяж нэг бичлэг сонгоно уу.');
            return false;
        }

        const adminNotes = $('input[name="admin_notes"]').val();

        // Get CSRF token
        const token = $('input[name="_token"]').val();


        // Submit via AJAX
        $.ajax({
            url: "{{ route('vr.admin.suggestions.bulk') }}",
            type: "POST",
            data: {
                _token: token,
                action: action,
                suggestion_ids: selectedIds,
                admin_notes: adminNotes
            },
            success: function(response) {
                // Reload page on success
                window.location.reload();
            },
            error: function(xhr) {
                console.error("Error:", xhr);
                alert("Алдаа гарлаа. Дахин оролдоно уу.");
            }
        });
    });
    $('#suggestions-table').on('click', 'form.d-inline button[type="submit"]', function(e) {
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(this).closest('form').submit();
});
    });
});
</script>
@endpush
