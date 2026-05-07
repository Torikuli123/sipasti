@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Edit Arsip</h2>
        <p>Perbarui data arsip: <strong>{{ $arsip->nomor_definitif }}</strong></p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" form="editForm" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
    </div>
</div>

<form id="editForm" method="POST" action="{{ route('arsip.update', $arsip->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-section">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Nomor Definitif</label>
                <input type="text" name="nomor_definitif" class="form-control" value="{{ old('nomor_definitif', $arsip->nomor_definitif) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Seri / Judul</label>
                <input type="text" name="seri" class="form-control" value="{{ old('seri', $arsip->seri) }}">
            </div>
            <div class="form-group full-width">
                <label class="form-label">Isi Informasi</label>
                <textarea name="isi_informasi" class="form-control" rows="4">{{ old('isi_informasi', $arsip->isi_informasi) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-control">
                    @foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $k)
                    <option value="{{ $k }}" {{ $arsip->kondisi == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $arsip->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="archived" {{ $arsip->status == 'archived' ? 'selected' : '' }}>Archived</option>
                    <option value="pending" {{ $arsip->status == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
        </div>
    </div>

    <div style="display:flex; justify-content:flex-end; gap:10px;">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
    </div>
</form>
@endsection
