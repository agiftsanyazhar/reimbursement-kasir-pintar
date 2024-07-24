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
                        <li class="breadcrumb-item {{ $edit ? '' : 'active' }}">
                            {!! $edit ? '<a href="' . route('admin.organization-profile.landing-page.vision-mission.index') . '">' . $title . '</a>' : $title !!}
                        </li>
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

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ $edit ? 'Edit' : $title }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="form-modal" action="{{ route('admin.organization-profile.landing-page.vision-mission.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <label>Visi<span class="text-danger fw-bold">*</span></label>
                                            <textarea class="form-control" name="vision" rows="5" required>{{ $data->vision }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Misi<span class="text-danger fw-bold">*</span></label>
                                            <input type="hidden" name="mission">
                                            <div class="editor">{!! $data->mission !!}</div>
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
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const quillContainers = document.querySelectorAll('.editor');
            let quillInstance;

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

            const missionField = document.querySelector('input[name="mission"]');

            if ('{!! $data->mission !!}' !== '') {
                missionField.value = '{!! $data->mission !!}';
            }

            // Update the value of the hidden input field when the Quill content changes
            quillInstance.on('text-change', function() {
                const quillContent = quillInstance.root.innerHTML;
                missionField.value = quillContent;
            });
        });
    </script>

    <script>
        //  Validasi
        function saveForm() {
            const requiredInputs = [
                { name: 'vision', label: 'Visi' },
            ];

            let hasErrors = false;

            requiredInputs.forEach(input => {
                const inputField = document.querySelector(`textarea[name="${input.name}"]`);
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