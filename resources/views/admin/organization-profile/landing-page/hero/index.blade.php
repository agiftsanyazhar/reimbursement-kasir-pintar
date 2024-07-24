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
                        <li class="breadcrumb-item">Profil Organisasi</li>
                        <li class="breadcrumb-item">Landing Page</li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
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
                <h5 class="card-title">
                    {{ $title }}
                    <span>
                        <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#modal-form"
                            onclick="openFormDialog('modal-form', 'add')"><i class="bi bi-plus-lg"></i></button>
                    </span> 
                </h5>
            </div>
            <div class="card-body">
                <small class="fw-bold">
                    <ul>
                        <li>Klik gambar untuk memperbesar</li>
                    </ul>
                </small>
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-25">Gambar</th>
                                <th>Headline</th>
                                <th>Deskripsi</th>
                                <th>Link</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($hero as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td class="text-center"><a href="{{ url('storage/' . $item->image) }}" target="_blank" rel="noopener noreferrer"><img class="rounded shadow" src="{{ asset('storage/' . $item->image) }}" style="width:100%; height:100px; object-fit:contain;"></a></td>
                                    <td>{{ Str::limit($item->headline, 100) }}</td>
                                    <td>{{ Str::limit($item->description, 150) }}</td>
                                    <td>
                                        {!! $item->link ? '<a href="' . $item->link . '" target="_blank" rel="noopener noreferrer">' . $item->link . '</a>' : '-' !!}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal-form"
                                                onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->image }}', '{{ $item->headline }}', '{{ $item->description }}', '{{ $item->link }}')">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteDialog('{{ route('admin.organization-profile.landing-page.hero.destroy', $item->id) }}')">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade text-left" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="form-modal" action="{{ route('admin.organization-profile.landing-page.hero.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <div class="form-group">
                                    <label>Headline</label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <textarea class="form-control" rows="3" placeholder="Ketik headline" name="headline"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="text" class="form-control" name="link" placeholder="Dengan https:// atau http://">
                                </div>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" rows="6" placeholder="Ketik deskripsi" name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" class="form-control mb-2" name="image" required>
                                    <small class="text-danger fw-bold">
                                        <ul>
                                            <li>Maks. 1 MB</li>
                                            <li>Aspect ratio: 16:9</li>
                                            <li>Jenis file: jpeg, jpg, png</li>
                                        </ul>
                                    </small>
                                </div>
                            </div>
                            <span class="text-danger fw-bold">* Wajib diisi</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1" onclick="saveForm()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        //  Validasi
        function saveForm() {
            const requiredInputs = [
            ];

            let hasErrors = false;

            requiredInputs.forEach(input => {
                const inputField = document.querySelector(``);
                if (inputField.value.trim() === '') {
                    alertDialog(input.name, input.label);
                    hasErrors = true;
                }
            });

            if (!hasErrors) {
                document.getElementById('form-modal').submit();
            }
        }

        function confirmDelete(deleteUrl) {
            const confirmed = window.confirm("Apakah Anda yakin ingin menghapus ini?");
            
            if (confirmed) {
                window.location.href = deleteUrl;
            }
        }
    </script>
    
    <script>
        function openFormDialog(target, type, id, image, headline, description, link) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('admin.organization-profile.landing-page.hero.store') }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' textarea[name="headline"]');
                $('#' + target + ' textarea[name="description"]');
                $('#' + target + ' input[name="link"]');
                $('#' + target + ' input[name="image"]').attr('required', 'required');
            } else if (type === 'edit') {
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', '{{ route('admin.organization-profile.landing-page.hero.update') }}');
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' textarea[name="headline"]').val(headline);
                $('#' + target + ' textarea[name="description"]').val(description);
                $('#' + target + ' input[name="link"]').val(link);
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection