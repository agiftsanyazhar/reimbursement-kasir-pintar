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
                <h5 class="card-title">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($message as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>
                                        {{ $item->name }}<br>
                                        <small><a href="{{ url('mailto:' . $item->email) }}" target="_blank" rel="noopener noreferrer">{{ $item->email }}</a></small><br>
                                        <small><a href="{{ url('https://wa.me/' . $item->whatsapp) }}" target="_blank" rel="noopener noreferrer">{{ $item->whatsapp }}</a></small>
                                    </td>
                                    <td>
                                        <small>{{ date('d M Y H.i', strtotime($item->created_at)) }} {!! $item->is_answered == 0 ? '<span class="badge ms-1 bg-light-danger">Unanswered</span>' : '<span class="badge ms-1 bg-light-success">Answered</span>' !!}</small><br>
                                        <small class="fw-bold">Subjek: {{ $item->subject }}</small><br>
                                        {!! Str::limit($item->message, 150) !!}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary" href="{{ route('admin.data.message.reply.index', $item->id) }}"><i class="bi bi-eye-fill"></i></a>
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

@endsection