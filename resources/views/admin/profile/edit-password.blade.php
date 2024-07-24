@extends('layouts.dashboard.app')

@section('container')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $title }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.organization-profile.bio.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Profil</li>
                        <li class="breadcrumb-item active">Edit</li>
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
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="{{ asset('storage/uploads/no-profile.jpg') }}" alt="{{ Auth::user()->name }}">
                            </div>
                            <h3 class="mt-3 text-center">{{ Auth::user()->name }}</h3>
                            <p class="text-small">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form class="form" id="form-modal" action="{{ route('admin.profile.edit-password.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Password Lama<span class="text-danger fw-bold">*</span></label>
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                        <input type="password" class="form-control" name="old_password" minlength="8" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Password Baru<span class="text-danger fw-bold">*</span></label>
                                        <input type="password" class="form-control" name="new_password" minlength="8" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Konfirmasi Password Baru<span class="text-danger fw-bold">*</span></label>
                                        <input type="password" class="form-control" name="renew_password" minlength="8" required>
                                    </div>
                                </div>
                                <span class="text-danger fw-bold mb-3">* Wajib diisi</span>
                                <div class="col-12 d-flex">
                                    <button type="submit" class="btn btn-primary me-1 mb-1" onclick="saveForm()"><i class="bi bi-floppy-fill"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        //  Validasi
        function saveForm() {
            const requiredInputs = [
                { name: 'old_password', label: 'Password Lama' },
                { name: 'new_password', label: 'Password Baru' },
                { name: 'renew_password', label: 'Konfirmasi Password Baru' },
            ];

            let hasErrors = false;

            requiredInputs.forEach(input => {
                const inputField = document.querySelector(`input[name="${input.name}"]`);
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