@extends('layouts.dashboard.app')

@section('container')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ Str::limit($article->title, 15) }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.organization-profile.bio.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Konten</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.content.article.index') }}">Artikel</a></li>
                        <li class="breadcrumb-item">{{ Str::limit($article->title, 15) }}</li>
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
                            onclick="openFormDialog('modal-form', 'add', '{{ $article->id }}')"><i class="bi bi-plus-lg"></i></button>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($articleImage as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td class="text-center">{!! $item->image ? '<a href="'. url('storage/' . $item->image) .'" target="_blank" rel="noopener noreferrer"><img class="rounded shadow" src="'. asset('storage/' . $item->image) .'" alt="'. $item->title .'" style="width:100%; height:100px; object-fit:contain;"></a>' : '-' !!}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal-form"
                                                onclick="openFormDialog('modal-form', 'edit', '{{ $item->id }}', '{{ $item->image }}', '{{ $item->article_id }}')">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteDialog('{{ route('admin.content.article.detail.destroy', ['article_id' => $item->article_id, 'id' => $item->id]) }}')">
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
                    <form class="form" id="form-modal" action="{{ route('admin.content.article.detail.store', ['article_id' => 'article_id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>Gambar<span class="text-danger fw-bold">*</span></label>
                                    <input class="form-control clear-after" type="hidden" name="id">
                                    <input class="form-control clear-after" type="hidden" name="article_id">
                                    <input type="file" class="form-control mb-2" name="image" required>
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
                { name: 'image', label: 'Gambar' },
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
        function openFormDialog(target, type, id, image, article_id) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('admin.content.article.detail.store', ['article_id' => 'article_id']) }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="image"]').attr('required', 'required');
                $('#' + target + ' input[name="article_id"]').val(id);
            } else if (type === 'edit') {
                const editUrl = '{{ url('admin/konten/artikel/detil') }}' + '/' + article_id + '/update';
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', editUrl);
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="article_id"]').val(article_id);
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection