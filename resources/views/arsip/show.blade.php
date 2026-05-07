@extends('layouts.app')

@section('content')
<div class="page-header">
    <div style="display:flex; align-items:center; gap:12px;">
        <a href="{{ route('arsip.index') }}" class="btn-icon" style="width:36px; height:36px; border-radius:50%;"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h2 style="margin:0;">Detail Arsip</h2>
            <p style="margin:0;">Rincian dokumen sistem pengelolaan arsip.</p>
        </div>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('arsip.edit', $arsip) }}" class="btn btn-outline">
            <i class="fas fa-pen"></i> Edit Arsip
        </a>
        @if($arsip->file_path)
        <a href="{{ asset('storage/' . $arsip->file_path) }}" target="_blank" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Buka Dokumen
        </a>
        @endif
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: 1fr 340px;">
    <div class="section-card">
        <div class="section-header">
            <div class="section-title"><i class="fas fa-info-circle" style="color:var(--accent); margin-right:8px;"></i>Informasi Utama</div>
            <span class="status-badge status-{{ $arsip->status }}">
                <span style="width:6px; height:6px; border-radius:50%; background:currentColor; display:inline-block;"></span>
                {{ ucfirst($arsip->status) }}
            </span>
        </div>
        
        <div style="padding: 24px;">
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Nomor Definitif</label>
                    <div style="font-size:16px; font-weight:600; color:var(--text-primary);">{{ $arsip->nomor_definitif ?: '-' }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Nomor Arsip Sementara</label>
                    <div style="font-size:16px; font-weight:600; color:var(--text-primary);">{{ $arsip->nomor_sementara ?: '-' }}</div>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Seri / Judul</label>
                    <div style="font-size:18px; font-weight:700; color:var(--accent);">{{ $arsip->seri ?: 'Tidak ada judul' }}</div>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Masalah / Sub Seri</label>
                    <div style="font-size:15px; color:var(--text-primary);">{{ $arsip->masalah ?: '-' }}</div>
                </div>
            </div>

            <div style="margin-bottom:32px; padding:20px; background:var(--bg-main); border-radius:var(--radius-sm); border-left:4px solid var(--accent);">
                <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px;">Isi Informasi</label>
                <div style="font-size:14px; color:var(--text-primary); line-height:1.6;">
                    {{ $arsip->isi_informasi ?: 'Tidak ada deskripsi informasi.' }}
                </div>
            </div>

            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:20px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Kode Klasifikasi</label>
                    <div style="padding:4px 10px; background:var(--border-light); border-radius:4px; display:inline-block; font-family:var(--font-mono); font-size:13px; font-weight:600;">{{ $arsip->kode_klasifikasi ?: '-' }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Kategori</label>
                    <div class="badge-cat cat-{{ strtolower($arsip->kategori) }}">{{ $arsip->kategori ?: 'Umum' }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Kondisi</label>
                    <div style="font-size:14px; font-weight:600;">{{ $arsip->kondisi }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Jumlah</label>
                    <div style="font-size:14px;">{{ $arsip->jumlah }} {{ $arsip->satuan_arsip }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Kurun Waktu (Tertua)</label>
                    <div style="font-size:14px;">{{ optional($arsip->tanggal_terhitung)->format('d F Y') ?: '-' }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Kurun Waktu (Termuda)</label>
                    <div style="font-size:14px;">{{ optional($arsip->tanggal_termuda)->format('d F Y') ?: '-' }}</div>
                </div>
            </div>
        </div>

        <div style="background:var(--border-light); padding:20px; display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:32px; height:32px; background:var(--bg-card); border:1px solid var(--border); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--text-muted);">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <div style="font-size:10px; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Diinput Oleh</div>
                    <div style="font-size:12px; font-weight:600;">{{ $arsip->user->name ?? 'Administrator' }}</div>
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:10px; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Waktu Entri</div>
                <div style="font-size:12px; font-weight:600;">{{ $arsip->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:16px;">
        <!-- File Preview Card -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-title"><i class="fas fa-paperclip"></i> Dokumen Lampiran</div>
            </div>
            <div style="padding:20px;">
                @if($arsip->file_path)
                    <div style="text-align:center; padding:16px; border:2px dashed var(--border); border-radius:var(--radius-sm);">
                        <i class="fas fa-file-pdf" style="font-size:48px; color:var(--danger); margin-bottom:12px;"></i>
                        <div style="font-size:13px; font-weight:600; margin-bottom:4px; word-break:break-all;">{{ $arsip->file_name }}</div>
                        <div style="font-size:11px; color:var(--text-muted); margin-bottom:16px;">Digital Repository File</div>
                        <a href="{{ asset('storage/' . $arsip->file_path) }}" target="_blank" class="btn btn-primary btn-sm" style="width:100%; justify-content:center;">Lihat File</a>
                    </div>
                @else
                    <div style="text-align:center; padding:32px 16px; color:var(--text-muted);">
                        <i class="fas fa-file-excel" style="font-size:40px; opacity:0.3; margin-bottom:12px;"></i>
                        <div style="font-size:12px;">Tidak ada lampiran file digital.</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Indexing Card -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-title"><i class="fas fa-tags"></i> Indeks & Label</div>
            </div>
            <div style="padding:20px; display:flex; flex-direction:column; gap:14px;">
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Indeks Nama</label>
                    <div style="font-size:13px;">{{ $arsip->indeks_nama ?: 'N/A' }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Indeks Tempat</label>
                    <div style="font-size:13px;">{{ $arsip->indeks_tempat ?: 'N/A' }}</div>
                </div>
                <div>
                    <label style="display:block; font-size:10px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:4px;">Indeks Masalah</label>
                    <div style="font-size:13px;">{{ $arsip->indeks_masalah ?: 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="padding:10px;">
            <form method="POST" action="{{ route('arsip.destroy', $arsip) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini secara permanen?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn" style="background:none; border:none; color:var(--danger); font-size:12px; font-weight:600; cursor:pointer; width:100%; text-align:center;">
                    <i class="fas fa-trash"></i> Hapus Arsip Permanen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
