{{-- resources/views/admin/professionals/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Эмч Бүртгэлийн Хүсэлтүүд</h2>
        </div>

        <div class="card mb-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Эмч Бүртгэлийн Хүсэлтүүд
            </div>
            <div class="card-body">
                <table id="professionalsTable" class="table table-striped table-bordered" >
                    <thead >
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Нэр</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">И-мэйл</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Мэргэжил</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Зэрэг</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($professionals as $professional)
                        <tr>
                            <td >{{ $professional->user->name }}</td>
                            <td >{{ $professional->user->email }}</td>
                            <td >{{ $professional->specialization }}</td>
                            <td >{{ $professional->qualification }}</td>
                            <td >
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $professional->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $professional->is_verified ? 'Баталгаажсан' : 'Хүлээгдэж буй' }}
                                </span>
                            </td>
                            <td >
                                <a href="{{ route('admin.professionals.show', $professional->id) }}"
                                   class="text-blue-600 hover:text-blue-900">Дэлгэрэнгүй</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>


<script>
$(document).ready(function() {
    $('#professionalsTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'csv'
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/mn.json'
        },
        columnDefs: [
            { orderable: false, targets: [5] },
            { searchable: false, targets: [5] }
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endsection
