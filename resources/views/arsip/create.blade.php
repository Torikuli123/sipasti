@extends('layouts.app')

@section('content')
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    Silakan isi formulir di bawah ini dengan lengkap untuk mendaftarkan arsip baru.
</div>

<div class="page-header">
    <div>
        <h2>Form Input Arsip</h2>
        <p>Pencatatan data arsip permanen dan dinamis.</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" form="arsipForm" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
</div>

<form id="arsipForm" method="POST" action="{{ route('arsip.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- Main Info Section -->
    <div class="form-section">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Nomor Definitif</label>
                <input type="text" name="nomor_definitif" class="form-control"
                    placeholder="Contoh: 001/ARS/2024" value="{{ old('nomor_definitif') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Arsip Sementara</label>
                <input type="text" name="nomor_sementara" class="form-control"
                    placeholder="Input nomor sementara" value="{{ old('nomor_sementara') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Seri</label>
                <input type="text" name="seri" class="form-control"
                    placeholder="Masukkan seri arsip" value="{{ old('seri') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Masalah (Sub Seri)</label>
                <input type="text" name="masalah" class="form-control"
                    placeholder="Detail sub seri" value="{{ old('masalah') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Kode Klasifikasi</label>
                <input type="text" name="kode_klasifikasi" class="form-control"
                    placeholder="Contoh: HK.01.02" value="{{ old('kode_klasifikasi') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tingkat Perkembangan</label>
                <select name="tingkat_perkembangan" class="form-control">
                    <option value="">Pilih tingkat</option>
                    <option value="Asli" {{ old('tingkat_perkembangan') == 'Asli' ? 'selected' : '' }}>Asli</option>
                    <option value="Copy" {{ old('tingkat_perkembangan') == 'Copy' ? 'selected' : '' }}>Copy</option>
                    <option value="Tembusan" {{ old('tingkat_perkembangan') == 'Tembusan' ? 'selected' : '' }}>Tembusan</option>
                    <option value="Pertinggal" {{ old('tingkat_perkembangan') == 'Pertinggal' ? 'selected' : '' }}>Pertinggal</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label class="form-label">Isi Informasi</label>
                <textarea name="isi_informasi" class="form-control" rows="3"
                    placeholder="Deskripsi ringkas mengenai isi arsip">{{ old('isi_informasi') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Tertua</label>
                <input type="date" name="tanggal_terhitung" class="form-control" value="{{ old('tanggal_terhitung') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Termuda</label>
                <input type="date" name="tanggal_termuda" class="form-control" value="{{ old('tanggal_termuda') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-control">
                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label class="form-label">Jumlah Arsip</label>
                <div class="quantity-row">
                    <div class="quantity-field">
                        <input type="number" min="1" step="1" name="jumlah" class="form-control"
                            placeholder="Masukkan jumlah" value="{{ old('jumlah') }}">
                    </div>
                    <div class="quantity-field">
                        <select name="satuan_arsip" class="form-control">
                            <option value="" disabled {{ old('satuan_arsip') ? '' : 'selected' }}>Satuan Arsip</option>
                            <option value="Lembar" {{ old('satuan_arsip') == 'Lembar' ? 'selected' : '' }}>Lembar</option>
                            <option value="Sampul" {{ old('satuan_arsip') == 'Sampul' ? 'selected' : '' }}>Sampul</option>
                            <option value="Buku" {{ old('satuan_arsip') == 'Buku' ? 'selected' : '' }}>Buku</option>
                            <option value="Bungkus" {{ old('satuan_arsip') == 'Bungkus' ? 'selected' : '' }}>Bungkus</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indexes Section -->
    <div class="form-section">
        <div class="form-section-title">
            <i class="fas fa-tags" style="color:var(--accent);"></i>
            Indeks & Istilah
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Indeks Nama Orang/Organisasi/Perusahaan</label>
                <input type="text" name="indeks_nama" class="form-control"
                    placeholder="Nama entitas terkait" value="{{ old('indeks_nama') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Indeks Tempat</label>
                <input type="text" name="indeks_tempat" class="form-control"
                    placeholder="Lokasi terkait" value="{{ old('indeks_tempat') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Indeks Masalah</label>
                <input type="text" name="indeks_masalah" class="form-control"
                    placeholder="Kata kunci masalah" value="{{ old('indeks_masalah') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Daftar Singkatan</label>
                <input type="text" name="daftar_singkatan" class="form-control"
                    placeholder="Contoh: KTP, KK" value="{{ old('daftar_singkatan') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Kepanjangan Singkatan</label>
                <input type="text" name="kepanjangan_singkatan" class="form-control"
                    placeholder="Definisi singkatan" value="{{ old('kepanjangan_singkatan') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Daftar Istilah</label>
                <input type="text" name="daftar_istilah" class="form-control"
                    placeholder="Istilah khusus" value="{{ old('daftar_istilah') }}">
            </div>

            <div class="form-group full-width">
                <label class="form-label">Arti Istilah</label>
                <input type="text" name="arti_istilah" class="form-control"
                    placeholder="Penjelasan arti istilah" value="{{ old('arti_istilah') }}">
            </div>
        </div>
    </div>

    <!-- Upload Section -->
    <div class="form-section">
        <div class="form-section-title">
            <i class="fas fa-upload" style="color:var(--accent);"></i>
            Upload File
        </div>

        <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
            <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <div class="upload-text">Klik untuk upload atau drag and drop</div>
            <div class="upload-sub">PDF, JPEG, atau PNG (Maks. 10MB)</div>
            <input type="file" id="fileInput" name="file" style="display:none" accept=".pdf,.jpg,.jpeg,.png"
                onchange="handleFile(this)">
        </div>

        <div id="filePreview" style="display:none;" class="uploaded-file">
            <i class="fas fa-file-pdf"></i>
            <div>
                <div class="file-name" id="fileName">arsip_kepegawaian_2024.pdf</div>
                <div class="file-size" id="fileSize">2.4 MB</div>
            </div>
            <div style="margin-left:auto; display:flex; gap:8px;">
                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('fileInput').click()">Ganti File Arsip</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="previewFile()">Preview File Arsip</button>
            </div>
        </div>

        @error('file')
            <div class="alert alert-error" style="margin-top:10px;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit -->
    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
        <a href="{{ route('arsip.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Arsip
        </button>
    </div>
</form>
@endsection

@push('styles')
<style>
    .quantity-row {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 0.85rem;
    }
    .quantity-row .quantity-field {
        display: flex;
        flex-direction: column;
    }
    .quantity-row .form-control {
        border: 1px solid rgba(148, 163, 184, 0.32);
        border-radius: 1rem;
        padding: 0.88rem 1rem;
        background: #ffffff;
        color: #1f2937;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .quantity-row .form-control:focus {
        border-color: rgba(59, 130, 246, 0.75);
        outline: none;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
    }
    @media (max-width: 640px) {
        .quantity-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
const uploadArea = document.getElementById('uploadArea');

// Drag & drop
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = 'var(--accent)';
    uploadArea.style.background = '#EFF6FF';
});
uploadArea.addEventListener('dragleave', () => {
    uploadArea.style.borderColor = '';
    uploadArea.style.background = '';
});
uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '';
    uploadArea.style.background = '';
    const files = e.dataTransfer.files;
    if (files.length) {
        document.getElementById('fileInput').files = files;
        showFile(files[0]);
    }
});

function handleFile(input) {
    if (input.files && input.files[0]) {
        showFile(input.files[0]);
    }
}

function showFile(file) {
    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent = (file.size / 1024 / 1024).toFixed(1) + ' MB';
    document.getElementById('filePreview').style.display = 'flex';
}

function previewFile() {
    const file = document.getElementById('fileInput').files[0];
    if (file) {
        const url = URL.createObjectURL(file);
        window.open(url, '_blank');
    }
}
</script>
@endpush
