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
                        <li class="breadcrumb-item">Data</li>
                        <li class="breadcrumb-item">Data Master</li>
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
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Deskrispi</th>
                                <th>Icon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($service as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <small>Deskripsi Singkat</small><br>
                                        {{ Str::limit($item->short_description, 150) }}<br><br>
                                        <small>Deskripsi</small><br>
                                        {!! Str::limit($item->long_description, 150) !!}
                                    </td>
                                    <td class="text-center"><i class="{{ $item->icon }} text-primary {{ $item->icon == 'fab fa-whatsapp' ? 'fs-5 fw-bold' : '' }}"></i></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary" href="{{ route('admin.data.master-data.service.detail.index', $item->id) }}"><i class="bi bi-eye-fill"></i></a>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal-form"
                                                onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->name }}', '{{ $item->short_description }}', '{{ $item->long_description }}', '{{ $item->icon }}')">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteDialog('{{ route('admin.data.master-data.service.destroy', $item->id) }}')">
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
                    <form class="form" id="form-modal" action="{{ route('admin.data.master-data.service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nama<span class="text-danger fw-bold">*</span></label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Icon<span class="text-danger fw-bold">*</span></label>
                                    <input type="text" class="form-control" name="icon" required>
                                    <small class="fw-bold">
                                        Cara penggunaan:
                                        <ol>
                                            <li>Buka: <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">Icon<i class="ms-2 bi bi-box-arrow-up-right"></i></a></li>
                                            <li>
                                                Salin dan tempel class dari icon yang dipilih <em><u>tanpa single quote ('') atau double quote ("")</u></em><br>
                                                Contoh: <code>bi bi-airplane-fill</code>
                                            </li>
                                        </ol>
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Deskripsi Singkat<span class="text-danger fw-bold">*</span></label>
                                    <textarea class="form-control" rows="5" placeholder="Ketik deskripsi singkat" name="short_description" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Deskripsi<span class="text-danger fw-bold">*</span></label>
                                    <input type="hidden" name="long_description">
                                    <div class="editor"></div>
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
        let quillInstance;
        
        document.addEventListener("DOMContentLoaded", function () {
            const quillContainers = document.querySelectorAll('.editor');

            // Define the toolbar options
            var toolbarOptions = [
                [{ font: [] }, { header: [1, 2, 3, 4, 5, 6, false] }],
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ color: [] }, { background: [] }],
                [{ script: "super" }, { script: "sub" }],
                [
                    { list: "ordered" },
                    { list: "bullet" },
                    { indent: "-1" },
                    { indent: "+1" },
                ],
                ["link", "image", "video", "formula"],
                ["clean"],
            ];

            quillContainers.forEach(container => {
                const quill = new Quill(container, {
                    theme: 'snow',
                    modules: {
                        toolbar: toolbarOptions
                    }
                });

                quillInstance = quill;
            });

            const longDescriptionField = document.querySelector('input[name="long_description"]');

            // Update the value of the hidden input field when the Quill content changes
            quillInstance.on('text-change', function() {
                const quillContent = quillInstance.root.innerHTML;
                longDescriptionField.value = quillContent;
            });
        });
    
        //  Validasi
        function saveForm() {
            const requiredInputs = [
                { name: 'name', label: 'Nama' },
                { name: 'icon', label: 'Icon' },
                { name: 'short_description', label: 'Deskripsi Singkat' },
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
    
        function openFormDialog(target, type, id, name, short_description, long_description, icon) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('admin.data.master-data.service.store') }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="name"]').attr('required', 'required');
                $('#' + target + ' input[name="icon"]').attr('required', 'required');
                $('#' + target + ' textarea[name="short_description"]').attr('required', 'required');
            } else if (type === 'edit') {
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', '{{ route('admin.data.master-data.service.update') }}');
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="name"]').val(name);
                $('#' + target + ' input[name="icon"]').val(icon);
                $('#' + target + ' textarea[name="short_description"]').val(short_description);
                quillInstance.setContents(quillInstance.clipboard.convert(long_description));
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection