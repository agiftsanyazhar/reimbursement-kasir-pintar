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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.reimbursment.index') }}">Beranda</a></li>
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
                    @if (Auth::user()->position == 'Staff')
                        <span>
                            <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#modal-form"
                                onclick="openFormDialog('modal-form', 'add')"><i class="bi bi-plus-lg"></i></button>
                        </span>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff</th>
                                <th class="w-25">Nama Reimbursment</th>
                                <th class="w-50">Deskripsi</th>
                                <th>Status</th>
                                <th class="w-25">Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($reimbursment as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        {{ Str::limit($item->name) }} {!! $item->file ? '<a href="'. url('storage/' . $item->file) .'" target="_blank" rel="noopener noreferrer"><i class="ms-1 bi bi-eye-fill"></i></a>' : '-' !!}
                                    </td>
                                    <td>{!! $item->description !!}</td>
                                    <td>
                                        {!! $item->status == 'approved' ? '<span class="badge bg-light-success">Approved</span>' : ($item->status == 'pending' ? '<span class="badge bg-light-warning">Pending</span>' : '<span class="badge bg-light-danger">Rejected</span>') !!} 
                                    </td>
                                    <td>
                                        <small>Dibuat: {{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</small><br>
                                        <small>Diedit: {!! $item->updated_at ? date('d/m/Y H:i:s', strtotime($item->updated_at)) : '-' !!} </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if (Auth::user()->position == 'Direktur' || Auth::user()->position == 'Finance')
                                                <a class="btn btn-success" href="{{ route('dashboard.reimbursment.update-status.approve', $item->id) }}"><i class="bi bi-check-lg"></i></a>
                                                <a class="btn btn-danger" href="{{ route('dashboard.reimbursment.update-status.reject', $item->id) }}"><i class="bi bi-x-lg"></i></a>
                                            @endif
                                            @if (Auth::user()->position == 'Staff')
                                                <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                    data-bs-target="#modal-form"
                                                    onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->name }}', '{{ $item->description }}', '{{ $item->file }}', '{{ $item->status }}')">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                            @endif
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
                    <form class="form" id="form-modal" action="{{ route('dashboard.reimbursment.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Nama Reimbursment<span class="text-danger fw-bold">*</span></label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            @if (Auth::user()->position == 'Direktur' || Auth::user()->position == 'Finance')
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Status<span class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="status" required>
                                            <option value="" disabled selected hidden>Pilih Status</option>
                                            <option value="approved">Approve</option>
                                            <option value="rejected">Reject</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Deskripsi<span class="text-danger fw-bold">*</span></label>
                                    <input type="hidden" name="description">
                                    <div class="editor"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>File</label>
                                    <input type="file" class="form-control mb-2" name="file">
                                    <small class="text-danger fw-bold">
                                        <ul>
                                            <li>Maks. 1 MB</li>
                                            <li>Jenis file: pdf, jpeg, jpg, png</li>
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
                    <button type="submit" class="btn btn-primary" onclick="saveForm()">
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

            const descriptionField = document.querySelector('input[name="description"]');

            // Update the value of the hidden input field when the Quill content changes
            quillInstance.on('text-change', function() {
                const quillContent = quillInstance.root.innerHTML;
                descriptionField.value = quillContent;
            });
        });
    
        //  Validasi
        function saveForm() {
            const requiredInputs = [
                { name: 'name', label: 'Nama Reimbursment' },
                { name: 'description', label: 'Deskripsi' },
                // { name: 'file', label: 'File' },
            ];

            let hasErrors = false;

            requiredInputs.forEach(input => {
                const inputField = document.querySelector(`input[name="${input.name}"], select[name="${input.name}"]`);
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
    
        function openFormDialog(target, type, id, name, description, file, status) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('dashboard.reimbursment.store') }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="name"]').attr('required', 'required');
                $('#' + target + ' input[name="description"]').attr('required', 'required');
                $('#' + target + ' input[name="file"]');
            } else if (type === 'edit') {
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', '{{ route('dashboard.reimbursment.update') }}');
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="name"]').val(name);
                $('#' + target + ' input[name="description"]').val(description);
                quillInstance.setContents(quillInstance.clipboard.convert(description));
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection