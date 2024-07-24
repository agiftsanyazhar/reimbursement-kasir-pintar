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
                            <div class="row">
                                @foreach ($visionMission as $item)
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <label>Visi{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <textarea class="form-control" name="vision" rows="5" {{ $edit ? '' : 'disabled' }} required>{{ $item->vision }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Misi{!! !$edit ? '' : '<span class="text-danger fw-bold">*</span>' !!}</label>
                                            <div>{!! $item->mission !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex">
                                        <a class="btn btn-warning text-white me-1 mb-1" href="{{ route('admin.organization-profile.landing-page.vision-mission.edit', $item->id) }}"><i class="bi bi-pencil-fill"></i></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection