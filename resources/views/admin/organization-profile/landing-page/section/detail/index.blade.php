@extends('layouts.dashboard.app')

@section('container')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $section->name }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.organization-profile.bio.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Profil Organisasi</li>
                        <li class="breadcrumb-item">Landing Page</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.organization-profile.landing-page.section.index') }}">Section</a></li>
                        <li class="breadcrumb-item">{{ $section->name }}</li>
                        <li class="breadcrumb-item">{{ $title }}</li>
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
                    @if (!request()->is('admin/profil-organisasi/landing-page/section/detil/3'))
                        <span>
                            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#modal-form"
                                onclick="openFormDialog('modal-form', 'add', '{{ $section->id }}')"><i class="bi bi-plus-lg"></i></button>
                        </span>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if (request()->is('admin/profil-organisasi/landing-page/section/detil/3'))
                    @include('admin.organization-profile.landing-page.section.detail.service')
                @else
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Point</th>
                                    <th>Icon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $number = 1;
                                @endphp
                                @foreach ($sectionFeature as $item)
                                    <tr>
                                        <td>{{ $number++ }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td class="text-center"><i class="{{ $item->icon }} text-primary {{ $item->icon == 'fab fa-whatsapp' ? 'fs-5 fw-bold' : '' }}"></i></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                    data-bs-target="#modal-form"
                                                    onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->title }}', '{{ $item->icon }}', {{ $item->landing_page_section_id }})">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteDialog('{{ route('admin.organization-profile.landing-page.section.detail.destroy', ['landing_page_section_id' => $item->landing_page_section_id, 'id' => $item->id]) }}')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade text-left" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $section->name }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="form-modal" action="{{ route('admin.organization-profile.landing-page.section.detail.store', ['landing_page_section_id' => 'landing_page_section_id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Point<span class="text-danger fw-bold">*</span></label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <input class="form-control clear-after" type="hidden" name="landing_page_section_id">
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Icon<span class="text-danger fw-bold">*</span></label>
                                    <input type="text" class="form-control" name="icon" required>
                                    <small class="fw-bold">
                                        Cara penggunaan:
                                        <ol>
                                            <li>Buka: <a href="https://fontawesome.com/v4/icons/" target="_blank" rel="noopener noreferrer">Icon<i class="ms-2 bi bi-box-arrow-up-right"></i></a></li>
                                            <li>
                                                Salin dan tempel class dari icon yang dipilih <em><u>tanpa single quote ('') atau double quote ("")</u></em><br>
                                                Contoh: <code>fa fa-map-marker</code>
                                            </li>
                                        </ol>
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
                { name: 'title', label: 'Point' },
                { name: 'icon', label: 'Icon' },
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

        function confirmDelete(deleteUrl) {
            const confirmed = window.confirm("Apakah Anda yakin ingin menghapus ini?");
            
            if (confirmed) {
                window.location.href = deleteUrl;
            }
        }
    </script>
    
    <script>
        function openFormDialog(target, type, id, title, icon, landing_page_section_id) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('admin.organization-profile.landing-page.section.detail.store', ['landing_page_section_id' => 'landing_page_section_id']) }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="landing_page_section_id"]').val(id);
                $('#' + target + ' input[name="title"]').attr('required', 'required');
                $('#' + target + ' input[name="icon"]').attr('required', 'required');
            } else if (type === 'edit') {
                const editUrl = '{{ url('admin/profil-organisasi/landing-page/section/detil') }}' + '/' + landing_page_section_id + '/update';
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', editUrl);
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="landing_page_section_id"]').val(landing_page_section_id);
                $('#' + target + ' input[name="title"]').val(title);
                $('#' + target + ' input[name="icon"]').val(icon);
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection