@extends('layouts.dashboard.app')

@section('container')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $data->name }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.organization-profile.bio.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Profil Organisasi</li>
                        <li class="breadcrumb-item">Landing Page</li>
                        <li class="breadcrumb-item {{ $edit ? '' : 'active' }}">
                            {!! $edit ? '<a href="' . route('admin.organization-profile.landing-page.section.index') . '">' . $title . '</a>' : $title !!}
                        </li>
                        <li class="breadcrumb-item">{{ $data->name }}</li>
                        @if ($edit)
                            <li class="breadcrumb-item active">Edit</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('danger'))
        <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="card-title">{{ $edit ? 'Edit' : $data->name }}</h4>
            </div>
            <div class="card-body">
                <form class="form" id="form-modal" action="{{ route('admin.organization-profile.landing-page.section.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label>Nama Section<span class="text-danger fw-bold">*</span></label>
                                <input class="form-control clear-after" type="hidden" name="id" value="{{ $data->id }}">
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="form-group">
                                <label>Headline<span class="text-danger fw-bold">*</span></label>
                                <textarea class="form-control" rows="3" placeholder="Ketik headline" name="headline" required>{{ $data->headline }}</textarea>
                            </div>
                        </div>
                        @if ($data->description)
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Deskripsi<span class="text-danger fw-bold">*</span></label>
                                    <textarea class="form-control" rows="5" placeholder="Ketik deskripsi" name="description" required>{{ $data->description }}</textarea>
                                </div>
                            </div>
                        @endif
                        @if ($data->featured_image)
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Featured Image<span class="text-danger fw-bold">*</span></label>
                                    <input type="file" class="form-control mb-2" name="featured_image" required>
                                    <small class="text-danger fw-bold">
                                        <ul>
                                            <li>Maks. 1 MB</li>
                                            <li>Jenis file: jpeg, jpg, png</li>
                                        </ul>
                                    </small>
                                    <div class="text-center">
                                        <a href="{{ url('storage/' . $data->featured_image) }}" target="_blank" rel="noopener noreferrer">
                                            <img class="rounded shadow" src="{{ asset('storage/' . $data->featured_image) }}" alt="{{ $data->name }}" style="width:50%; height:350px; object-fit:contain;">
                                        </a>
                                    </div>
                                    <p class="text-center mt-3 fw-bold">Klik gambar untuk memperbesar</p>
                                </div>
                            </div>
                        @endif
                        <span class="text-danger fw-bold mb-3">* Wajib diisi</span>
                        <div class="col-12 d-flex">
                            <button type="submit" class="btn btn-primary me-1 mb-1" onclick="saveForm()"><i class="bi bi-floppy-fill"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        //  Validasi
        function saveForm() {
            const requiredInputs = [
                { name: 'name', label: 'Nama Section' },
                { name: 'headline', label: 'Headline' },
                { name: 'description', label: 'Deskripsi' },
                { name: 'featured_image', label: 'Featured Image' },
            ];

            let hasErrors = false;

            requiredInputs.forEach(input => {
                const inputField = document.querySelector(`input[name="${input.name}"], textarea[name="${input.name}"]`);
                if (inputField.value.trim() === '') {
                    alertDialog(input.name, input.label);
                    hasErrors = true;
                }
            });

            if (!hasErrors) {
                document.getElementById('form-modal').submit();
            }
        }
    </script>

@endsection