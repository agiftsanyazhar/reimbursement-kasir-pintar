@extends('layouts.dashboard.app')

@section('container')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $title }} <a href="javascript:window.location.reload()" class="btn btn-primary ms-1" type="button"><i class="bi bi-arrow-repeat me-1"></i> Refresh</a></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.organization-profile.bio.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">Data</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.data.message.index') }}">Pesan</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title">
                    {{ $parentMessage->name }}

                    <div class="fs-6 mt-3 fw-normal"><span class="fw-bold">Subjek: </span>{{ $parentMessage->subject }}</div>
                    <div class="fs-6 fw-normal"><span class="fw-bold">Email: </span><a href="mailto:{{ $parentMessage->email }}" target="_blank" rel="noopener noreferrer">{{ $parentMessage->email }}</a></div>
                    <div class="fs-6 fw-normal"><span class="fw-bold">WhatsApp: </span><a href="https://wa.me/{{ $parentMessage->whatsapp }}" target="_blank" rel="noopener noreferrer">{{ $parentMessage->whatsapp }}</a></div>
                </h5>
            </div>
            <div class="card-body">
                <form class="form" id="form-modal" action="{{ route('admin.data.message.reply.store', ['parent_message_id' => $parentMessage->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="chat-content">
                                @foreach($messages as $item)
                                    <div class="chat {{ $item->user_id ? '' : 'chat-left' }}">
                                        <div class="chat-body">
                                            <div class="chat-message">
                                                {!! $item->message !!}
                                                
                                                <div class="mt-2 text-end">
                                                    {{ $item->user_id ? $item->user->name : $item->name }}<br>
                                                    {{ date('d M Y H.i', strtotime($item->created_at)) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
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
                        </div>

                        <div class="col-md-11 col-9 mb-5">
                            <input class="form-control clear-after" type="hidden" name="parent_message_id" value="{{ $parentMessage->id }}">
                            <input class="form-control clear-after" type="hidden" name="name" value="{{ $parentMessage->name }}">
                            <input class="form-control clear-after" type="hidden" name="email" value="{{ $parentMessage->email }}">
                            <input class="form-control clear-after" type="hidden" name="subject" value="{{ $parentMessage->subject }}">
                            <input class="form-control clear-after" type="hidden" name="message_code" value="{{ $parentMessage->message_code }}">
                            <input type="hidden" name="message">
                            <div class="editor"></div>
                        </div>
                        <div class="col-md-1 col-3 text-center">
                            <div class="btn-group" role="group">
                                <button type="submit" class="btn btn-primary ps-2 pe-3 pt-2 pb-0">
                                    <i class="material-icons">send</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        window.scrollTo(0, document.body.scrollHeight);
    </script>

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
                ["link", "formula"],
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

            const messageField = document.querySelector('input[name="message"]');

            // Update the value of the hidden input field when the Quill content changes
            quillInstance.on('text-change', function() {
                const quillContent = quillInstance.root.innerHTML;
                messageField.value = quillContent;
            });
        });
    </script>

@endsection