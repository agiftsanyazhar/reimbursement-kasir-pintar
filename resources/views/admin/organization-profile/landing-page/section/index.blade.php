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
                            {!! $edit ? '<a href="' . route('admin.organization-profile.landing-page.section.index') . '">' . $title . '</a>' : $title !!}
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

    <section class="section">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <small class="fw-bold">
                    <ul>
                        <li class="text-danger">Hanya ID 1 ({{ $section[0]['name'] }}) yang dapat mengupload featured image</li>
                        <li class="text-danger">Hanya ID 1-4 ({{ $section[0]['name'] }}, {{ $section[1]['name'] }}, {{ $section[2]['name'] }}, {{ $section[3]['name'] }}) yang memiliki detil</li>
                        <li class="text-danger">Hanya ID 1, 2, 4 ({{ $section[0]['name'] }}, {{ $section[1]['name'] }}, {{ $section[3]['name'] }}) yang memiliki deskripsi</li>
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
                                <th>Nama Section</th>
                                <th>Headline</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($section as $item)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td class="text-center">
                                        {!! $item->featured_image ? '<a href="'.url('storage/' . $item->featured_image).'" target="_blank" rel="noopener noreferrer"><img class="rounded shadow" src="'.asset('storage/' . $item->featured_image).'" alt="'.$item->name.'" style="width:100%; height:100px; object-fit:contain;"></a>' : '-' !!}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ Str::limit($item->headline, 100) }}</td>
                                    <td>{{ Str::limit($item->description, 150) ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if ($item->landingPageSectionFeature->isNotEmpty())
                                                <a class="btn btn-primary" href="{{ route('admin.organization-profile.landing-page.section.detail.index', $item->id) }}"><i class="bi bi-eye-fill"></i></a>
                                            @endif
                                            <a class="btn btn-warning text-white" href="{{ route('admin.organization-profile.landing-page.section.edit', $item->id) }}"><i class="bi bi-pencil-fill"></i></a>
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