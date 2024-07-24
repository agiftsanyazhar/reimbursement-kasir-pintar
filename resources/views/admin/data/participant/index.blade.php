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
                                <th class="w-25">Nama</th>
                                <th class="w-25">Biodata</th>
                                <th class="w-50">Program</th>
                                <th class="w-25">Berkas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($participant as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>
                                        {{ $item->name }} <span class="badge ms-1 bg-light-success">{{ $item->register_code }}</span><br>
                                        <small><a href="{{ url('mailto:' . $item->email) }}" target="_blank" rel="noopener noreferrer">{{ $item->email }}</a></small><br>
                                        <small><a href="{{ url('https://wa.me/' . $item->whatsapp) }}" target="_blank" rel="noopener noreferrer">{{ $item->whatsapp }}</a></small>
                                    </td>
                                    <td>
                                        <small class="fw-bold">Tempat, Tanggal Lahir: </small>{{ $item->place_of_birth }}, {{ date('d M Y', strtotime($item->date_of_birth)) }}<br>
                                        <small class="fw-bold">Golongan: </small>{{ $item->group == 0 ? 'Umum/Non-Anggota' : 'Anggota/Mahasiswa/Alumni' }}<br>
                                        <small class="fw-bold">Alamat: </small>{{ $item->address }}<br>
                                        <small class="fw-bold">Nama Institusi/Perusahaan: </small>{{ $item->name_of_institution_company }}<br>
                                        <small class="fw-bold">Alamat Institusi/Perusahaan: </small>{{ $item->address_of_institution_company }}
                                    </td>
                                    <td>
                                        <small>
                                            {{ date('d M Y H.i', strtotime($item->created_at)) }} {!! $item->status == 0 ? '<span class="badge ms-1 bg-light-danger">Rejected</span>' : ($item->status == 1 ? '<span class="badge ms-1 bg-light-success">Approved</span>' : '<span class="badge ms-1 bg-light-warning">Waiting</span>') !!}
                                            <a href="{{ route('admin.data.participant.update.status', ['status' => 0, 'id' => $item->id]) }}"><span class="badge ms-1 bg-light-danger"><i class="bi bi-x-lg"></i></span></a>
                                            <a href="{{ route('admin.data.participant.update.status', ['status' => 2, 'id' => $item->id]) }}"><span class="badge ms-1 bg-light-warning"><i class="bi bi-clock-fill"></i></span></a>
                                            <a href="{{ route('admin.data.participant.update.status', ['status' => 1, 'id' => $item->id]) }}"><span class="badge ms-1 bg-light-success"><i class="bi bi-check-lg"></i></span></a>
                                        </small><br>
                                        <small class="fw-bold">Nama Program: </small>{{ $item->service_article_id ? $item->serviceArticle->title : ($item->program_article_id ? $item->programArticle->title : $item->careerArticle->title) }}<br>
                                        <small class="fw-bold">Harga: </small>Rp{{ $item->service_article_id ? number_format($item->serviceArticle->price, 2, ',', '.') : ($item->program_article_id ? number_format($item->programArticle->price, 2, ',', '.') : number_format(0, 2, ',', '.')) }}<br>
                                        <small class="fw-bold">Catatan: </small>{!! $item->notes !!}
                                    </td>
                                    <td>
                                        <ul>
                                            <li><a href="{{ url('storage/' . $item->id_card) }}" target="_blank" rel="noopener noreferrer">ID Card</a></li>
                                            @if ($item->proof_of_payment)
                                                <li><a href="{{ url('storage/' . $item->proof_of_payment) }}" target="_blank" rel="noopener noreferrer">Bukti Pembayaran</a></li>
                                            @endif
                                        </ul>
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