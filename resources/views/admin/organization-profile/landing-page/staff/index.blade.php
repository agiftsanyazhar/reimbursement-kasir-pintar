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
                                <th class="w-25">Foto</th>
                                <th>Media Sosial</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($staff as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td class="text-center">
                                        {!! $item->image ? '<a href="'.url('storage/' . $item->image).'" target="_blank" rel="noopener noreferrer"><img class="rounded shadow" src="'.asset('storage/' . $item->image).'" alt="'.$item->name.'" style="width:100%; height:100px; object-fit:contain;"></a>' : '-' !!}
                                        <p class="text-center mt-3 mb-0 fw-bold">{{ $item->name ?? '-' }}</p>
                                        <small>{{ $item->role }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group m-1" role="group">
                                            {!! $item->email ? '<a class="btn btn-primary" href="' . url('mailto:' . $item->email) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-envelope-open-fill"></i></a>' : '' !!}
                                            {!! $item->facebook ? '<a class="btn btn-primary" href="' . url('https://www.facebook.com/' . $item->facebook) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>' : '' !!}
                                            {!! $item->instagram ? '<a class="btn btn-primary" href="' . url('https://www.instagram.com/' . $item->instagram) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>' : '' !!}
                                            {!! $item->linkedin ? '<a class="btn btn-primary" href="' . url('https://www.linkedin.com/in/' . $item->linkedin) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>' : '' !!}
                                        </div>
                                        <div class="btn-group m-1" role="group">
                                            {!! $item->twitter ? '<a class="btn btn-primary" href="' . url('https://twitter.com/' . $item->twitter) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter"></i></a>' : '' !!}
                                            {!! $item->youtube ? '<a class="btn btn-primary" href="' . url('https://www.youtube.com/@' . $item->youtube) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-youtube"></i></a>' : '' !!}
                                            {!! $item->additional_link ? '<a class="btn btn-primary" href="' . url($item->additional_link) . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-link-45deg"></i></a>' : '' !!}
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($item->description, 150) ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal-form"
                                                onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->image }}', '{{ $item->name }}', '{{ $item->role }}', '{{ $item->description }}', '{{ $item->email }}', '{{ $item->facebook }}', '{{ $item->instagram }}', '{{ $item->linkedin }}', '{{ $item->twitter }}', '{{ $item->youtube }}', '{{ $item->additional_link }}')">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteDialog('{{ route('admin.organization-profile.landing-page.staff.destroy', $item->id) }}')">
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
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="form-modal" action="{{ route('admin.organization-profile.landing-page.staff.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <div class="form-group">
                                    <label>Nama<span class="text-danger fw-bold">*</span></label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan<span class="text-danger fw-bold">*</span></label>
                                    <input type="text" class="form-control" name="role" required>
                                </div>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" rows="5" placeholder="Ketik deskripsi" name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="facebook" placeholder="Username saja">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>Instagram</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="instagram" placeholder="Username saja">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label>LinkedIn</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="linkedin" placeholder="Username saja">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Twitter</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="twitter" placeholder="Username saja">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>YouTube</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="youtube" placeholder="Username saja">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Link Lainnya</label>
                                    <input type="text" class="form-control" name="additional_link" placeholder="Dengan https:// atau http://">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" class="form-control mb-2" name="image">
                                    <small class="text-danger fw-bold">
                                        <ul>
                                            <li>Maks. 1 MB</li>
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
                { name: 'name', label: 'Nama' },
                { name: 'role', label: 'Jabatan' },
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

        function confirmDelete(deleteUrl) {
            const confirmed = window.confirm("Apakah Anda yakin ingin menghapus ini?");
            
            if (confirmed) {
                window.location.href = deleteUrl;
            }
        }
    </script>
    
    <script>
        function openFormDialog(target, type, id, image, name, role, description, email, facebook, instagram, linkedin, twitter, youtube, additional_link) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('admin.organization-profile.landing-page.staff.store') }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="image"]');
                $('#' + target + ' input[name="name"]').attr('required', 'required');
                $('#' + target + ' input[name="role"]').attr('required', 'required');
                $('#' + target + ' textarea[name="description"]');
                $('#' + target + ' input[name="email"]');
                $('#' + target + ' input[name="facebook"]');
                $('#' + target + ' input[name="instagram"]');
                $('#' + target + ' input[name="linkedin"]');
                $('#' + target + ' input[name="twitter"]');
                $('#' + target + ' input[name="youtube"]');
                $('#' + target + ' input[name="additional_link"]');
            } else if (type === 'edit') {
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', '{{ route('admin.organization-profile.landing-page.staff.update') }}');
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="name"]').val(name);
                $('#' + target + ' input[name="role"]').val(role);
                $('#' + target + ' textarea[name="description"]').val(description);
                $('#' + target + ' input[name="email"]').val(email);
                $('#' + target + ' input[name="facebook"]').val(facebook);
                $('#' + target + ' input[name="instagram"]').val(instagram);
                $('#' + target + ' input[name="linkedin"]').val(linkedin);
                $('#' + target + ' input[name="twitter"]').val(twitter);
                $('#' + target + ' input[name="youtube"]').val(youtube);
                $('#' + target + ' input[name="additional_link"]').val(additional_link);
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection