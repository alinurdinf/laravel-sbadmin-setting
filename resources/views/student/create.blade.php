@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('New Student') }}</h1>

<!-- Main Content goes here -->

<div class="card">
    <div class="card-body">
        <form action="{{ route('student.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="nim">Nim</label>
                <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" id="nim" placeholder="Nim" autocomplete="off" value="{{ old('nim') }}">
                @error('nim')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="First name" autocomplete="off" value="{{ old('name') }}">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email address" autocomplete="off" value="{{ old('email') }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Address">{{ old('address') }}</textarea>
                @error('address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Prodi</label>
                <select class="form-control @error('prodi') is-invalid @enderror" name="prodi">
                    <option value="">-- Select Prodi --</option>
                    <option value="Teknik Informatika" {{ old('prodi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Teknik Komputer" {{ old('prodi') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                </select>
                @error('prodi')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" placeholder="No Telpt" autocomplete="off" value="{{ old('no_telp') }}">
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" placeholder="Tanggal Lahir" autocomplete="off" value="{{ old('tgl_lahir') }}">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" class="form-control @error('kelas') is-invalid @enderror" name="kelas" placeholder="Kelas" autocomplete="off" value="{{ old('kelas') }}">
            </div>

            <div class="form-group">
                <label>Semester</label>
                <input type="text" class="form-control @error('semester') is-invalid @enderror" name="semester" placeholder="Semester" autocomplete="off" value="{{ old('semester') }}">
            </div>

            <label>Join Date</label>
            <input type="date" class="form-control @error('join_date') is-invalid @enderror" name="join_date" placeholder="Join Date" autocomplete="off" value="{{ old('join_date') }}">
            <br />
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('lecture.index') }}" class="btn btn-default">Back to list</a>

        </form>
    </div>
</div>

<!-- End of Main Content -->
@endsection

@push('notif')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('warning'))
<div class="alert alert-warning border-left-warning alert-dismissible fade show" role="alert">
    {{ session('warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
<div class="alert alert-success border-left-success" role="alert">
    {{ session('status') }}
</div>
@endif
@endpush
