{{-- resources/views/admin/professionals/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Эмч нарын дэлгэрэнгүй мэдээлэл</h2>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Хувийн мэдээлэл</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Нэр</dt>
                            <dd class="mt-1 text-gray-900">{{ $professional->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">И-мэйл</dt>
                            <dd class="mt-1 text-gray-900">{{ $professional->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Мэргэжил</dt>
                            <dd class="mt-1 text-gray-900">{{ $professional->specialization }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Зэрэг</dt>
                            <dd class="mt-1 text-gray-900">{{ $professional->qualification }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-2">Нэмэлт мэдээлэл</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Товч танилцуулга</dt>
                            <dd class="mt-1 text-gray-900">{{ $professional->bio ?? 'Мэдээлэл оруулаагүй' }}</dd>
                        </div>
                        {{-- <div>
                            <dt class="text-sm font-medium text-gray-500">Гэрчилгээ</dt>
                            <dd class="mt-1">
                                @if($professional->certification)
                                    <a href="{{ asset('storage/'.$professional->certification) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900">
                                        Файл харах
                                    </a>
                                @else
                                    <span class="text-gray-500">Файл оруулаагүй</span>
                                @endif
                            </dd>
                        </div> --}}
                        <div class="mb-3">
                            <strong>Certification:</strong>
                            @if ($professional->certification)
                                <a href="{{ route('professional.download-certification', $professional->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i> Download Certification
                                </a>
                            @else
                                <p>No certification provided.</p>
                            @endif
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Баталгаажуулалт</dt>
                            <dd class="mt-1">
                                <form action="{{ route('admin.professionals.update', $professional->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="px-4 py-2 rounded-md
                                                   {{ $professional->is_verified ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-600 hover:bg-gray-700' }}
                                                   text-white">
                                        {{ $professional->is_verified ? 'Баталгаажуулалт цуцлах' : 'Баталгаажуулах' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('professionals.destroy', $professional->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this profile?')">
                                        Delete Profile
                                    </button>
                                </form>

                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.professionals.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Буцах
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
