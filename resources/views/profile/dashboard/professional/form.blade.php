@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3">Мэргэжлийн Баталгаажуулалт</h1>
            <p class="text-muted">Эрүүл мэндийн мэргэжилтнээр баталгаажихын тулд мэргэжлийн баримт бичгээ илгээнэ үү</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($professional && $professional->is_approved)
                <div class="alert alert-success mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="alert-heading">Баталгаажсан Мэргэжилтэн</h4>
                            <p class="mb-0">Таны мэргэжлийн статуст баталгаажуулалт амжилттай хийгдсэн. Одооноос та бүх мэргэжлийн боломжуудыг ашиглах боломжтой.</p>
                        </div>
                    </div>
                </div>
            @elseif($professional && $professional->is_rejected)
                <div class="alert alert-danger mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="alert-heading">Баталгаажуулалт Сурав</h4>
                            <p class="mb-0">
                                Өргөдөл тань баталгаажуулалтанд тэнцсэнгүй.
                                Мэдээллээ засч дахин илгээнэ үү.
                                @if($professional->rejection_reason)
                                    <br>
                                    <strong>Шалтгаан:</strong> {{ $professional->rejection_reason }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($professional && !$professional->is_approved && !$professional->is_rejected)
                <div class="alert alert-info mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-hourglass-half fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="alert-heading">Баталгаажуулалт Хүлээгдэж Байна</h4>
                            <p class="mb-0">Таны өргөдөл одоогоор хянагдаж байна. Хянаж дуусмагц бид танд мэдэгдэнэ.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('dashboard.professional.save') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="specialization" class="form-label">Мэргэшил <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                                   id="specialization" name="specialization"
                                   value="{{ old('specialization', $professional->specialization ?? '') }}"
                                   placeholder="Жишээ: Зүрх судасны мэс засалч, Физиотерапевт, Хоол тэжээлийн мэргэжилтэн" required>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Эрүүл мэндийн мэргэжлээ оруулна уу</div>
                        </div>

                        <div class="mb-3">
                            <label for="qualification" class="form-label">Боловсрол, Өргөдөл <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('qualification') is-invalid @enderror"
                                   id="qualification" name="qualification"
                                   value="{{ old('qualification', $professional->qualification ?? '') }}"
                                   placeholder="Жишээ: АУ-ны их эмч, Хоол тэжээлийн PhD, Лицензтэй физиотерапевт" required>
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Өндөр боловсрол эсвэл лицензийн мэдээллээ оруулна уу</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="certification" class="form-label">
                                Баталгаажуулах баримт бичиг
                                @if(!$professional || !$professional->certification)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            <input type="file" class="form-control @error('certification') is-invalid @enderror"
                                   id="certification" name="certification"
                                   {{ (!$professional || !$professional->certification) ? 'required' : '' }}>
                            @error('certification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Лиценз, диплом эсвэл бусад баталгаажуулах баримт бичгийг (PDF, JPG, PNG, дээд тал нь 5MB) оруулна уу</div>

                            @if($professional && $professional->certification)
                                <div class="mt-2">
                                    <span class="badge bg-success"><i class="fas fa-file-alt"></i> Баримт бичиг байршуулсан</span>
                                    <small class="text-muted ms-2">Шинэ файл оруулаад орлуулна уу</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="bio" class="form-label">Мэргэжлийн Танилцуулга</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio"
                              rows="5" placeholder="Мэргэжлийн туршлага, мэргэшсэн салбарынхаа талаар бичнэ үү">{{ old('bio', $professional->bio ?? '') }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Туршлага, мэргэшсэн чиглэлээ хуваалцна уу (сонголттой)</div>
                </div>

                <div class="alert alert-warning">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <p class="mb-0">Энэ маягт илгээхэд та доорх зүйлийг баталгаажуулж байна:</p>
                            <ul class="mb-0 mt-2">
                                <li>Бүх мэдээлэл үнэн, найдвартай байна</li>
                                <li>Та хууль ёсны эрүүл мэндийн зөвлөгөө өгөх эрхтэй</li>
                                <li>Таны баримт бичгийг манай баг хянаж баталгаажуулна</li>
                                <li>Платформ дээрх мэргэжлийн ёс зүйн дүрмийг дагана</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    @if($professional && $professional->is_approved)
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Мэдээлэл Шинэчлэх
                        </button>
                    @else
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> {{ $professional ? 'Дахин Илгээх' : 'Илгээх' }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($professional && $professional->is_approved)
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Мэргэжлийн Танигдахын Баталгаажсан Шошго</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="badge-preview p-3 border rounded me-3">
                        <span class="badge bg-primary p-2">
                            <i class="fas fa-user-md"></i> Баталгаажсан {{ $professional->specialization }}
                        </span>
                    </div>
                    <div>
                        <p class="mb-0">Энэ шошго таны нэрний хажууд платформ даяар харагдах болно.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$professional || (!$professional->is_approved && !$professional->is_rejected))
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Баталгаажуулалтын Үйл Явц</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="text-center p-3">
                            <div class="mb-3">
                                <i class="fas fa-file-upload fa-2x text-primary"></i>
                            </div>
                            <h5>1. Илгээх</h5>
                            <p class="text-muted small">Мэргэжлийн дэлгэрэнгүй мэдээлэл, баримт бичгээ оруулна</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="text-center p-3">
                            <div class="mb-3">
                                <i class="fas fa-tasks fa-2x text-primary"></i>
                            </div>
                            <h5>2. Хянах</h5>
                            <p class="text-muted small">Манай баг таны баримт бичгийг 2–3 ажлын хоногт хянадаг</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-2x text-primary"></i>
                            </div>
                            <h5>3. Баталгаажсан</h5>
                            <p class="text-muted small">Баталгаажуулалт амжилттай болсны дараа та мэргэжлийн шошго, давуу талуудыг авна</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
