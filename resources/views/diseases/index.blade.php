@extends('layouts.header')

@section('title', 'Disease Database')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="page-title mb-4">Disease Database</h1>

            <!-- Search and Filter Container -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <!-- Search Bar -->
                    <form action="{{ route('diseases.search') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search diseases by name or symptoms..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>

                    <!-- Quick Filters -->
                    <div class="d-flex flex-wrap justify-content-between mb-2">
                        <div>
                            <strong>Quick Filters:</strong>
                            <div class="btn-group btn-group-sm ms-2">
                                <a href="{{ route('diseases.index', ['type' => 'common']) }}" class="btn btn-outline-secondary">Common</a>
                                <a href="{{ route('diseases.index', ['type' => 'rare']) }}" class="btn btn-outline-secondary">Rare</a>
                                <a href="{{ route('diseases.index', ['type' => 'chronic']) }}" class="btn btn-outline-secondary">Chronic</a>
                                <a href="{{ route('diseases.index', ['type' => 'infectious']) }}" class="btn btn-outline-secondary">Infectious</a>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('diseases.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-sync-alt"></i> Reset All Filters
                            </a>
                        </div>
                    </div>

                    <!-- Alphabetical Filter -->
                    <div class="alphabet-filter mt-3">
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('diseases.index') }}"
                                class="btn btn-sm {{ !isset($letter) ? 'btn-primary' : 'btn-outline-secondary' }} m-1">
                                All
                            </a>
                            @foreach(range('A', 'Z') as $char)
                                <a href="{{ route('diseases.index', ['letter' => $char]) }}"
                                    class="btn btn-sm {{ isset($letter) && $letter == $char ? 'btn-primary' : 'btn-outline-secondary' }} m-1">
                                    {{ $char }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disease List Card -->
            <div class="card shadow">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if(isset($letter))
                            Diseases Starting with '{{ $letter }}'
                        @elseif(request('search'))
                            Search Results for "{{ request('search') }}"
                        @elseif(request('type'))
                            {{ ucfirst(request('type')) }} Diseases
                        @else
                            All Diseases
                        @endif
                    </h5>
                    <span class="badge bg-primary fs-6">{{ count($diseases) }}</span>
                </div>

                @if(count($diseases) > 100)
                    <div class="card-body bg-light-warning py-2 text-center">
                        <small><i class="fas fa-info-circle"></i> Showing first 100 results. Please use search or filters for more specific results.</small>
                    </div>
                @endif

                <div class="disease-list-container">
                    <ul class="disease-list">
                        @forelse($diseases->take(100) as $disease)
                            <li class="disease-item">
                                <a href="{{ route('diseases.show', $disease->id) }}" class="disease-link">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-medical text-primary me-2"></i>
                                        <div>
                                            <strong>{{ $disease->disease_name }}</strong>
                                            @if(isset($disease->category))
                                                <span class="disease-category">{{ $disease->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </a>
                            </li>
                        @empty
                            <li class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h5>No diseases found</h5>
                                    <p class="text-muted">
                                        @if(isset($letter))
                                            No diseases starting with '{{ $letter }}'.
                                        @elseif(request('search'))
                                            No diseases match your search "{{ request('search') }}".
                                        @else
                                            No diseases available in the database.
                                        @endif
                                    </p>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>

                @if(count($diseases) > 0)
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                @if(count($diseases) > 100)
                                    Showing 100 of {{ count($diseases) }} diseases
                                @else
                                    Showing all {{ count($diseases) }} diseases
                                @endif
                            </small>
                            {{-- <div class="pagination-links">
                                <!-- Add pagination if needed -->
                                {{ $diseases->appends(request()->query())->links() }}
                            </div> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add this CSS to your stylesheet -->
<style>
    .disease-list-container {
        max-height: 70vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #dee2e6 #f8f9fa;
    }

    .disease-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .disease-item {
        border-bottom: 1px solid #f0f0f0;
    }

    .disease-item:last-child {
        border-bottom: none;
    }

    .disease-link {
        padding: 12px 16px;
        color: #333;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.2s ease;
    }

    .disease-link:hover {
        background-color: #f8f9fa;
        text-decoration: none;
    }

    .disease-category {
        font-size: 0.8rem;
        color: #6c757d;
        margin-left: 8px;
        display: inline-block;
    }

    .alphabet-filter .btn {
        min-width: 34px;
    }

    .empty-state {
        padding: 2rem 0;
    }

    /* For mobile responsiveness */
    @media (max-width: 576px) {
        .alphabet-filter .btn {
            min-width: 30px;
            padding: 0.25rem 0.5rem;
            margin: 0.25rem !important;
        }
    }
</style>
@endsection
