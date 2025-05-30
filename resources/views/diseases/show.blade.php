@extends('layouts.app')

@section('title', $disease->disease_name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Back button and title section -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('diseases.index') }}" class="btn btn-outline-primary me-3">
                    <i class="fas fa-arrow-left"></i> Back to list
                </a>
                <h1 class="page-title mb-0 flex-grow-1">{{ $disease->disease_name }}</h1>
                <div class="translation-toggle ms-2">
                    <button id="toggleTranslation" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-language"></i> <span id="currentLang">EN</span>
                    </button>
                </div>
            </div>

            <!-- Disease info overview card -->
            <div class="card mb-4 shadow-sm border-0 disease-overview">
                <div class="card-body p-4">
                    <div class="disease-header d-flex align-items-center mb-3">
                        <div class="disease-icon me-3">
                            <i class="fas fa-virus text-primary"></i>
                        </div>
                        <div>
                            <h2 class="mb-1">{{ $disease->disease_name }}</h2>
                            @if(isset($disease->category))
                                <span class="badge bg-info rounded-pill">{{ $disease->category }}</span>
                            @endif
                            @if(isset($disease->severity))
                                <span class="badge bg-{{ $disease->severity == 'High' ? 'danger' : ($disease->severity == 'Medium' ? 'warning' : 'success') }} rounded-pill ms-1">{{ $disease->severity }} Severity</span>
                            @endif
                        </div>
                    </div>

                    @if(isset($disease->short_description))
                        <div class="disease-summary">
                            <p class="lead">{{ $disease->short_description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main information cards -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-stethoscope text-primary me-2"></i>
                                Symptoms
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(strpos($disease->common_symptom, ',') !== false)
                                <ul class="symptom-list">
                                    @foreach(explode(',', $disease->common_symptom) as $symptom)
                                        <li>{{ trim($symptom) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-0">{{ $disease->common_symptom }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-pills text-primary me-2"></i>
                                Treatment
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(strpos($disease->treatment, ',') !== false)
                                <ul class="treatment-list">
                                    @foreach(explode(',', $disease->treatment) as $treatment)
                                        <li>{{ trim($treatment) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-0">{{ $disease->treatment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description section -->
            @if(isset($disease->description))
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Description
                    </h5>
                </div>
                <div class="card-body">
                    <div class="description-content">
                        {{ $disease->description }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional information tabs -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light p-0">
                    <ul class="nav nav-tabs card-header-tabs" id="diseaseInfo" role="tablist">
                        @if(isset($disease->causes))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="causes-tab" data-bs-toggle="tab" data-bs-target="#causes" type="button" role="tab" aria-controls="causes" aria-selected="true">
                                <i class="fas fa-search-plus me-1"></i> Causes
                            </button>
                        </li>
                        @endif

                        @if(isset($disease->risk_factors))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !isset($disease->causes) ? 'active' : '' }}" id="risk-tab" data-bs-toggle="tab" data-bs-target="#risk" type="button" role="tab" aria-controls="risk" aria-selected="{{ !isset($disease->causes) ? 'true' : 'false' }}">
                                <i class="fas fa-exclamation-triangle me-1"></i> Risk Factors
                            </button>
                        </li>
                        @endif

                        @if(isset($disease->prevention))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ !isset($disease->causes) && !isset($disease->risk_factors) ? 'active' : '' }}" id="prevention-tab" data-bs-toggle="tab" data-bs-target="#prevention" type="button" role="tab" aria-controls="prevention" aria-selected="{{ !isset($disease->causes) && !isset($disease->risk_factors) ? 'true' : 'false' }}">
                                <i class="fas fa-shield-alt me-1"></i> Prevention
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="diseaseInfoContent">
                        @if(isset($disease->causes))
                        <div class="tab-pane fade show active" id="causes" role="tabpanel" aria-labelledby="causes-tab">
                            <p>{{ $disease->causes }}</p>
                        </div>
                        @endif

                        @if(isset($disease->risk_factors))
                        <div class="tab-pane fade {{ !isset($disease->causes) ? 'show active' : '' }}" id="risk" role="tabpanel" aria-labelledby="risk-tab">
                            <p>{{ $disease->risk_factors }}</p>
                        </div>
                        @endif

                        @if(isset($disease->prevention))
                        <div class="tab-pane fade {{ !isset($disease->causes) && !isset($disease->risk_factors) ? 'show active' : '' }}" id="prevention" role="tabpanel" aria-labelledby="prevention-tab">
                            <p>{{ $disease->prevention }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- References section -->
            @if(isset($disease->references))
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-book-medical text-primary me-2"></i>
                        References
                    </h5>
                </div>
                <div class="card-body">
                    <div class="references-content">
                        @if(strpos($disease->references, '://') !== false)
                            @php
                                $refs = preg_split('/\r\n|\r|\n/', $disease->references);
                            @endphp
                            <ul class="references-list">
                                @foreach($refs as $ref)
                                    <li>
                                        @if(preg_match('/https?:\/\/[^\s]+/', $ref, $matches))
                                            <a href="{{ $matches[0] }}" target="_blank" rel="noopener noreferrer">
                                                {{ str_replace($matches[0], '', $ref) ?: $matches[0] }}
                                            </a>
                                        @else
                                            {{ $ref }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mb-0">{{ $disease->references }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Related diseases section -->
            @if(isset($relatedDiseases) && count($relatedDiseases) > 0)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-link text-primary me-2"></i>
                        Related Diseases
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($relatedDiseases as $related)
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('diseases.show', $related->id) }}" class="text-decoration-none">
                                    <div class="related-disease p-2 rounded">
                                        <i class="fas fa-virus me-2 text-secondary"></i>
                                        {{ $related->disease_name }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Google Translate Element -->
<div id="google_translate_element" style="display: none;"></div>

<style>
    .disease-overview {
        border-left: 4px solid #007bff !important;
    }

    .disease-icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(0, 123, 255, 0.1);
    }

    .symptom-list, .treatment-list, .references-list {
        padding-left: 1.2rem;
    }

    .symptom-list li, .treatment-list li, .references-list li {
        margin-bottom: 0.5rem;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #495057;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        background-color: transparent;
    }

    .related-disease {
        transition: all 0.2s;
        border: 1px solid #dee2e6;
    }

    .related-disease:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }

    .description-content, .references-content {
        line-height: 1.7;
    }

    @media (max-width: 576px) {
        .disease-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .disease-icon {
            margin-bottom: 1rem;
        }

        .nav-tabs .nav-link {
            font-size: 0.9rem;
            padding: 0.5rem;
        }
    }
</style>

<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        {pageLanguage: 'en', includedLanguages: 'en,mn', autoDisplay: false},
        'google_translate_element'
    );
}

// Toggle translation function
function toggleTranslation() {
    const translateCombo = document.querySelector('.goog-te-combo');
    const currentLangSpan = document.getElementById('currentLang');

    if (translateCombo) {
        // Check if currently in English
        if (translateCombo.value === '' || translateCombo.value === 'en') {
            // Switch to Mongolian
            translateCombo.value = 'mn';
            currentLangSpan.textContent = 'MN';
        } else {
            // Switch to English
            translateCombo.value = 'en';
            currentLangSpan.textContent = 'EN';
        }
        translateCombo.dispatchEvent(new Event('change'));
    }
}

// Automatically switch to Mongolian on page load
function setLanguageToMongolian() {
    setTimeout(function() {
        const translateCombo = document.querySelector('.goog-te-combo');
        const currentLangSpan = document.getElementById('currentLang');

        if (translateCombo) {
            translateCombo.value = 'mn';
            currentLangSpan.textContent = 'MN';
            translateCombo.dispatchEvent(new Event('change'));
        }
    }, 2000); // Wait 2 seconds for Google Translate to load
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
window.onload = function() {
    setLanguageToMongolian();

    // Add event listener to translation toggle button
    document.getElementById('toggleTranslation').addEventListener('click', toggleTranslation);
};
</script>
@endsection
