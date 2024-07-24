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
                        <li class="breadcrumb-item">Konten</li>
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
                        <li class="text-danger">1 ID (layanan) hanya dapat membuat 1 artikel</li>
                        <li>Klik gambar untuk memperbesar</li>
                    </ul>
                </small>
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th class="w-25">Featured Image</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($article as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ $item->service_id }}</td>
                                    <td class="text-center">{!! $item->featured_image ? '<a href="'. url('storage/' . $item->featured_image) .'" target="_blank" rel="noopener noreferrer"><img class="rounded shadow" src="'. asset('storage/' . $item->featured_image) .'" alt="'. $item->title .'" style="width:100%; height:100px; object-fit:contain;"></a>' : '-' !!}</td>
                                    <td>
                                        <small>
                                            <i class="bi bi-calendar-date-fill text-primary me-2"></i>{{ date('d M Y', strtotime($item->created_at)) }} {!! $item->is_active == 1 ? '<span class="badge ms-1 bg-light-success">Published</span>' : '<span class="badge ms-1 bg-light-danger">Unpublished</span>' !!} 
                                            <a href="{{ route('admin.content.service.update.status', $item->id) }}"><span class="{{ $item->is_active == 1 ? 'badge ms-1 bg-light-success' : 'badge ms-1 bg-light-danger' }}"><i class="bi {{ $item->is_active == 1 ? 'bi-check-lg' : 'bi-x-lg' }}"></i></span></a>
                                        </small><br>
                                        @if ($item->started_at && $item->ended_at)
                                            <small><i class="bi bi-clock-fill text-primary me-2"></i>{{ date('d M Y', strtotime($item->started_at)) }} - {{ date('d M Y', strtotime($item->ended_at)) }}</small><br>
                                        @endif
                                        {{ Str::limit($item->title, 75) }}<br>
                                        <small>Layanan: {{ $item->service->name }}</small>
                                    </td>
                                    <td>
                                        <small>Dibuat: {{ date('d M Y', strtotime($item->created_at)) }}</small><br>
                                        <small>Diedit: {{ date('d M Y', strtotime($item->updated_at)) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary" href="{{ route('admin.content.service.detail.index', $item->id) }}"><i class="bi bi-eye-fill"></i></a>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal-form"
                                                onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->title }}', '{{ $item->description }}', '{{ $item->is_active }}', '{{ $item->featured_image }}', '{{ $item->service_id }}', '{{ $item->started_at }}', '{{ $item->ended_at }}', '{{ $item->batch }}', '{{ $item->price }}')">
                                                <i class="bi bi-pencil-fill"></i>
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
                    <form class="form" id="form-modal" action="{{ route('admin.content.service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Judul<span class="text-danger fw-bold">*</span></label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Harga<span class="text-danger fw-bold">*</span></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="0" class="form-control" placeholder="Ketik angka saja" name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Batch<span class="text-danger fw-bold">*</span></label>
                                    <input type="number" min="0" class="form-control" placeholder='Ketik "0" jika kosong' name="batch" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Status<span class="text-danger fw-bold">*</span></label>
                                    <select class="form-select" name="is_active" required>
                                        <option value="" disabled selected hidden>Pilih Status</option>
                                        <option value="1">Publish</option>
                                        <option value="0">Unpublish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Layanan<span class="text-danger fw-bold">*</span></label>
                                    <select class="form-select" name="service_id" required>
                                        <option value="" disabled selected hidden>Pilih Layanan</option>
                                        @foreach ($listService as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="started_at">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="ended_at">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Deskripsi<span class="text-danger fw-bold">*</span></label>
                                    <input type="hidden" name="description">
                                    <div class="editor"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" class="form-control mb-2" name="featured_image">
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
                { name: 'title', label: 'Judul' },
                { name: 'is_active', label: 'Status' },
                { name: 'service_id', label: 'Layanan' },
                { name: 'batch', label: 'Batch' },
                { name: 'price', label: 'Harga' },
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
    
        function openFormDialog(target, type, id, title, description, is_active, featured_image, service_id, started_at, ended_at, batch, price) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('admin.content.service.store') }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="title"]').attr('required', 'required');
                $('#' + target + ' select[name="is_active"]').attr('required', 'required');
                $('#' + target + ' input[name="featured_image"]');
                $('#' + target + ' select[name="service_id"]').attr('required', 'required');
                $('#' + target + ' input[name="started_at"]');
                $('#' + target + ' input[name="ended_at"]');
                $('#' + target + ' input[name="batch"]');
                $('#' + target + ' input[name="price"]');
            } else if (type === 'edit') {
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', '{{ route('admin.content.service.update') }}');
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="title"]').val(title);
                $('#' + target + ' select[name="is_active"]').val(is_active);
                $('#' + target + ' select[name="service_id"]').val(service_id);
                $('#' + target + ' input[name="started_at"]').val(started_at);
                $('#' + target + ' input[name="ended_at"]').val(ended_at);
                $('#' + target + ' input[name="batch"]').val(batch);
                $('#' + target + ' input[name="price"]').val(price);
                quillInstance.setContents(quillInstance.clipboard.convert(description));
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection