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
                        <li class="breadcrumb-item {{ $edit ? '' : 'active' }}">
                            {!! $edit ? '<a href="' . route('admin.organization-profile.bio.index') . '">' . $title . '</a>' : $title !!}
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
                            @if ($edit)
                                <form class="form" id="form-modal" action="{{ route('admin.organization-profile.bio.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                            @endif
                            <div class="row">
                                @foreach ($aboutMe as $item)
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <label>Ketua{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <input type="text" class="form-control" name="leader_name" value="{{ $item->leader_name }}" {{ $edit ? '' : 'disabled' }} required>
                                        </div>
                                        <div class="form-group">
                                            <label>Sambutan Ketua{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <textarea class="form-control" name="leader_description" rows="8" {{ $edit ? '' : 'disabled' }} required>{{ $item->leader_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Foto Ketua</label>
                                            @if ($edit)
                                                <input type="file" class="form-control mb-2" name="leader_image">
                                                <small class="text-danger fw-bold">
                                                    <ul>
                                                        <li>Maks. 1 MB</li>
                                                        <li>Jenis file: jpeg, jpg, png</li>
                                                    </ul>
                                                </small>
                                            @endif
                                            <div class="text-center">
                                                <a href="{{ url('storage/' . $item->leader_image) }}" target="_blank" rel="noopener noreferrer">
                                                    <img class="rounded shadow" src="{{ asset('storage/' . $item->leader_image) }}" alt="{{ $item->leader_name }}" style="width:100%; height:250px; object-fit:contain;">
                                                </a>
                                            </div>
                                            <p class="text-center mt-3 fw-bold">Klik gambar untuk memperbesar</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Nama Organisasi{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <textarea class="form-control" name="name" rows="3" {{ $edit ? '' : 'disabled' }} required>{{ $item->name }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Deskripsi Footer{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <textarea class="form-control" name="footer_description" rows="7" {{ $edit ? '' : 'disabled' }} required>{{ $item->footer_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label>Tentang Kami{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            @if ($edit)
                                                <input type="hidden" name="long_description">
                                                <div class="editor">{!! $item->long_description !!}</div>
                                            @else
                                                <div>{!! $item->long_description !!}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Alamat{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <input type="text" class="form-control" name="address" value="{{ $item->address }}" {{ $edit ? '' : 'disabled' }} required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kota{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <input type="text" class="form-control" name="city" value="{{ $item->city }}" {{ $edit ? '' : 'disabled' }} required>
                                        </div>
                                        @if ($edit)
                                            <div class="form-group">
                                                <label>Pinned Location{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                                <input type="text" class="form-control" name="pinned_location" value="{{ $item->pinned_location }}" {{ $edit ? '' : 'disabled' }} required>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label>Lokasi{!! !$edit ? '<a class="ms-2" href="' . $item->pinned_location . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            @if ($edit)
                                                <textarea class="form-control" name="iframe_map" rows="7" placeholder="Tempel lokasi Anda dengan menyalin Sematkan Peta (Embed a Map) di Google Maps" {{ $edit ? '' : 'disabled' }} required>{{ $item->iframe_map }}</textarea>
                                                <a href="https://maps.google.com/" target="_blank"><small class="text-secondary">Buka Google Maps <i class="bi bi-box-arrow-up-right"></i></small></a>
                                            @endif
                                            <div class="preview-map mt-2 text-center"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Email{!! !$edit ? '<a class="ms-2" href="mailto:' . $item->email . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            @if ($edit)
                                                <input type="email" class="form-control" name="email" value="{{ $item->email }}">
                                            @else
                                                <div class="input-group mb-3">
                                                    <input type="email" class="form-control" value="{{ strtok($item->email, '@') }}" placeholder="Username saja" {{ $edit ? '' : 'disabled' }} required>
                                                    <span class="input-group-text">{{ strstr($item->email, '@') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Facebook{!! !$edit ? '<a class="ms-2" href="https://www.facebook.com/' . $item->facebook . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">@</span>
                                                <input type="text" class="form-control" name="facebook" value="{{ $item->facebook }}" placeholder="Username saja" {{ $edit ? '' : 'disabled' }} required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Instagram{!! !$edit ? '<a class="ms-2" href="https://www.instagram.com/' . $item->instagram . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">@</span>
                                                <input type="text" class="form-control" name="instagram" value="{{ $item->instagram }}" placeholder="Username saja" {{ $edit ? '' : 'disabled' }} required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>LinkedIn{!! !$edit ? '<a class="ms-2" href="https://www.linkedin.com/company/' . $item->linkedin . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">@</span>
                                                <input type="text" class="form-control" name="linkedin" value="{{ $item->linkedin }}" placeholder="Username saja" {{ $edit ? '' : 'disabled' }} required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Twitter{!! !$edit ? '<a class="ms-2" href="https://www.twitter.com/' . $item->twitter . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '' !!}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">@</span>
                                                <input type="text" class="form-control" name="twitter" value="{{ $item->twitter }}" placeholder="Username saja" {{ $edit ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>WhatsApp{!! !$edit ? '<a class="ms-2" href="https://wa.me/' . $item->whatsapp . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">+62</span>
                                                <input type="number" class="form-control" name="whatsapp" value="{{ substr($item->whatsapp, 3) }}" placeholder='Tanpa "+62" atau "0"' {{ $edit ? '' : 'disabled' }} required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>YouTube{!! !$edit ? '<a class="ms-2" href="https://www.youtube.com/@' . $item->youtube . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '' !!}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">@</span>
                                                <input type="text" class="form-control" name="youtube" value="{{ $item->youtube }}" placeholder="Username saja" {{ $edit ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Link Lainnya{!! !$edit ? '<a class="ms-2" href="' . $item->additional_link . '" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right"></i></a>' : '' !!}</label>
                                            <input type="text" class="form-control" name="additional_link" value="{{ $item->additional_link }}" placeholder="Dengan https:// atau http://" {{ $edit ? '' : 'disabled' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Favicon</label>
                                            @if ($edit)
                                                <input type="file" class="form-control mb-2" name="favicon">
                                                <small class="text-danger fw-bold">
                                                    <ul>
                                                        <li>Maks. 1 MB</li>
                                                        <li>Jenis file: jpeg, jpg, png</li>
                                                    </ul>
                                                </small>
                                            @endif
                                            <div class="text-center">
                                                <a href="{{ url('storage/' . $item->favicon) }}" target="_blank" rel="noopener noreferrer">
                                                    <img class="rounded shadow" src="{{ asset('storage/' . $item->favicon) }}" alt="Favicon" style="width:100%; height:250px; object-fit:contain;">
                                                </a>
                                            </div>
                                            <p class="text-center mt-3 fw-bold">Klik gambar untuk memperbesar</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label>Logo</label>
                                            @if ($edit)
                                                <input type="file" class="form-control mb-2" name="logo">
                                                <small class="text-danger fw-bold">
                                                    <ul>
                                                        <li>Maks. 1 MB</li>
                                                        <li>Jenis file: jpeg, jpg, png</li>
                                                    </ul>
                                                </small>
                                            @endif
                                            <div class="text-center">
                                                <a href="{{ url('storage/' . $item->logo) }}" target="_blank" rel="noopener noreferrer">
                                                    <img class="rounded shadow" src="{{ asset('storage/' . $item->logo) }}" alt="Logo" style="width:100%; height:250px; object-fit:contain;">
                                                </a>
                                            </div>
                                            <p class="text-center mt-3 fw-bold">Klik gambar untuk memperbesar</p>
                                        </div>
                                    </div>
                                    @if ($edit)
                                        <span class="text-danger fw-bold mb-3">* Wajib diisi</span>
                                        <div class="col-12 d-flex">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" onclick="saveForm()"><i class="bi bi-floppy-fill"></i></button>
                                        </div>
                                    @else
                                        <div class="col-12 d-flex">
                                            <a class="btn btn-warning text-white me-1 mb-1" href="{{ route('admin.organization-profile.bio.edit', $item->id) }}"><i class="bi bi-pencil-fill"></i></a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if ($edit)
                                </form>
                            @endif
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

            const longDescriptionField = document.querySelector('input[name="long_description"]');

            if ('{!! $item->long_description !!}' !== '') {
                longDescriptionField.value = '{!! $item->long_description !!}';
            }

            // Update the value of the hidden input field when the Quill content changes
            quillInstance.on('text-change', function() {
                const quillContent = quillInstance.root.innerHTML;
                longDescriptionField.value = quillContent;
            });
        });
    </script>

    <script>
        // Google Maps Preview 
        const iframeMapField = document.querySelector('textarea[name="iframe_map"]');
        const mapPreview = document.querySelector('.preview-map');

        if ('{!! $item->iframe_map !!}' !== '') {
            mapPreview.innerHTML = '{!! $item->iframe_map !!}';
        }

        iframeMapField.addEventListener('input', function() {
            const mapValue = this.value;

            if (mapValue !== '') {
                const iframeCode = mapValue;
                mapPreview.innerHTML = iframeCode;
            } else {
                mapPreview.innerHTML = '{!! $item->iframe_map !!}';
            }
        });
    </script>

    <script>
        //  Validasi
        function saveForm() {
            const requiredInputs = [
                { name: 'leader_name', label: 'Ketua' },
                { name: 'leader_description', label: 'Sambutan Ketua' },
                { name: 'name', label: 'Nama Organisasi' },
                { name: 'footer_description', label: 'Deskripsi Footer' },
                { name: 'address', label: 'Alamat' },
                { name: 'city', label: 'Kota' },
                { name: 'pinned_location', label: 'Pinned Location' },
                { name: 'iframe_map', label: 'Lokasi' },
                { name: 'email', label: 'Email' },
                { name: 'facebook', label: 'Facebook' },
                { name: 'instagram', label: 'Instagram' },
                { name: 'linkedin', label: 'LinkedIn' },
                { name: 'whatsapp', label: 'WhatsApp' },
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