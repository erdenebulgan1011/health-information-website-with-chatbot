<!-- resources/views/events/admin/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Үйл явдлын дэлгэрэнгүй')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Үйл явдлын дэлгэрэнгүй</h1>
        <div>
            <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Буцах
            </a>
            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Засах
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            {{ $event->title }}
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">ID:</div>
                <div class="col-md-9">{{ $event->id }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Гарчиг:</div>
                <div class="col-md-9">{{ $event->title }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Тайлбар:</div>
                <div class="col-md-9">{{ $event->description ?? 'Тайлбар байхгүй' }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Эхлэх хугацаа:</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d H:i') }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Дуусах хугацаа:</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($event->end_time)->format('Y-m-d H:i') }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Байршил:</div>
                <div class="col-md-9">{{ $event->location ?? 'Байршил тодорхойгүй' }}</div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">URL:</div>
                <div class="col-md-9">
                    @if($event->url)
                        <a href="{{ $event->url }}" target="_blank">{{ $event->url }}</a>
                    @else
                        URL байхгүй
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Устгахдаа итгэлтэй байна уу?')">
                    <i class="fas fa-trash"></i> Устгах
                </button>
            </form>
        </div>
    </div>
</div>
@endsection