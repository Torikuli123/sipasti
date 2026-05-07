@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Mesin Rekomendasi AI</h2>
        <p>Memanfaatkan Pembelajaran Mesin Untuk Mengoptikan Klasifikasi Dan Temu Kembali Arsip</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('export.index') }}" class="btn btn-outline">
            <i class="fas fa-file-excel" style="color:var(--success);"></i> Export Excel
        </a>
        <button class="btn btn-primary" onclick="runAnalysis()">
            <i class="fas fa-robot"></i> Analisis AI
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
    <!-- Rekomendasi Kategori -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-lightbulb" style="color:var(--warning); margin-right:6px;"></i>
                Rekomendasi Kategori Arsip
            </div>
        </div>
        <div style="padding:14px 16px; font-size:12px; color:var(--text-secondary); background:var(--bg-main); border-bottom:1px solid var(--border);">
            AI Telah Menganalisis 1,240 Dokumen Tertunda. Berdasarkan Pola Data Historis, Kami Menyarankan Perubahan Struktur Berikut:
        </div>
        <div class="ai-reco-grid">
            <div class="reco-card">
                <div class="reco-badge-high">KEYAKINAN TINGGI</div>
                <div class="reco-title">Hukum & Kepatuhan</div>
                <div class="reco-count">420</div>
                <div class="reco-desc">Dokumen Cocok Dengan Pola Ini Dengan Akurasi 98%</div>
            </div>
            <div class="reco-card">
                <div class="reco-badge-med">KEYAKINAN SEDANG</div>
                <div class="reco-title">Sumber Daya Manusia</div>
                <div class="reco-count">158</div>
                <div class="reco-desc">Dokumen Menunggu Tinjuan Untuk Kategori Ini</div>
            </div>
            <div class="reco-card" style="border: 2px dashed var(--border);">
                <div style="font-size:24px; color:var(--text-muted); margin-bottom:8px;">+</div>
                <div class="reco-title" style="color:var(--text-muted);">Saran Kategori Baru</div>
            </div>
        </div>
    </div>

    <!-- Smart Actions -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-bolt" style="color:var(--warning); margin-right:6px;"></i>
                Tindakan Cerdas
            </div>
        </div>
        <div style="padding: 20px;">
            <div style="font-size:12px; color:var(--text-secondary); margin-bottom:16px;">
                Siap Mengoptimalkan Arsip Anda? Biarkan AI Menangani Tugas Klasifikasi Yang Kompleks.
            </div>
            <button class="btn btn-primary" style="width:100%; justify-content:center;" onclick="runAnalysis()">
                <i class="fas fa-magic"></i> Buat Rekomendasi
            </button>

            <div id="progressArea" style="display:none; margin-top:16px;">
                <div style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">Menganalisis dokumen...</div>
                <div class="progress-bar" style="height:8px;">
                    <div class="progress-fill" id="progressFill" style="width:0%; transition: width 0.5s;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
    <!-- Wawasan Data Arsip -->
    <div class="section-card" style="grid-column: span 1;">
        <div class="section-header">
            <div class="section-title">Wawasan Data Arsip</div>
            <a href="#" style="font-size:12px; color:var(--accent); text-decoration:none; font-weight:600;">Lihat Laporan Detail</a>
        </div>
        <div class="insight-row">
            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                <span class="insight-label">Skor Integritas Data</span>
                <span class="insight-val">94.2%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 94.2%; background: var(--success);"></div>
            </div>
        </div>
        <div class="insight-row">
            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                <span class="insight-label">Kepadatan Klasifikasi</span>
                <span class="insight-val">88.5%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 88.5%; background: var(--accent);"></div>
            </div>
        </div>
        <div style="padding: 12px 16px; background:var(--bg-main); margin: 8px 12px; border-radius:var(--radius-sm); font-size:11px; color:var(--text-secondary); line-height:1.6;">
            <i class="fas fa-map-marker-alt" style="color:var(--accent); margin-right:6px;"></i>
            Saran AI: Anda Memiliki Volume Tinggi Laporan Fiskal Yang Belum Terklasifikasi Dari 2022. Disarankan Tag "Arsip Fiskal-22"
        </div>
    </div>

    <!-- Deteksi Duplikasi -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-copy" style="color:var(--warning); margin-right:6px;"></i>
                Deteksi Duplikasi
            </div>
        </div>
        <div class="dup-item">
            <div>
                <div class="dup-name">Invoice_2023_01.pdf</div>
                <div class="dup-sub">△ 3 similar files found</div>
            </div>
            <button class="btn-icon view"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="dup-item">
            <div>
                <div class="dup-name">Contract_Alpha_v2.doc</div>
                <div class="dup-sub" style="color:var(--danger);">△ Exact match in Folder B</div>
            </div>
            <button class="btn-icon view"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <!-- Classification Codes -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-tags" style="color:var(--accent); margin-right:6px;"></i>
                Classification Codes
            </div>
        </div>
        <div style="padding: 16px;">
            @php
            $codes = [
                ['Kearsipan Umum', 'KU.01.01', 'blue'],
                ['Keuangan', 'KU.02.04', 'green'],
                ['Hukum & Perdata', 'HK.01.00', 'purple'],
            ];
            @endphp
            @foreach($codes as $code)
            <div style="display:flex; align-items:center; justify-content:space-between; padding: 8px 0; border-bottom: 1px solid var(--border-light);">
                <span style="font-size:12px; color:var(--text-secondary);">{{ $code[0] }}</span>
                <span class="badge-cat cat-{{ $code[2] == 'blue' ? 'finance' : ($code[2] == 'green' ? 'hr' : 'legal') }}" style="font-family:var(--font-mono);">{{ $code[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Ringkasan Otomatis -->
<div class="section-card">
    <div class="section-header">
        <div class="section-title">
            <i class="fas fa-file-alt" style="color:var(--accent); margin-right:6px;"></i>
            Ringkasan Otomatis
        </div>
    </div>
    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 12px; padding: 16px;">
        @php
        $summaries = [
            ['Ringkasan Laporan Fiskal Q3 Dari Dalam Tahun Periode Saat...', '#1a3a5c'],
            ['Kontrak Hukum 2024 Eksklusiva Tanggap Jatuh Tempo Dan Validitas...', '#2563a8'],
            ['Ringkasan Audit TI Indikator Aktivitas Sistem Yang Dibuat AI...', '#0f2540'],
        ];
        @endphp
        @foreach($summaries as $s)
        <div style="background: {{ $s[1] }}; border-radius: var(--radius-sm); padding: 14px; color:white; font-size: 11px; line-height:1.5; cursor:pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
            {{ $s[0] }}
        </div>
        @endforeach
        <div style="background: var(--bg-main); border: 2px dashed var(--border); border-radius: var(--radius-sm); padding: 14px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--text-muted); font-size:12px; font-weight:600; gap:6px; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
            <i class="fas fa-plus"></i> Buat Ringkasan Baru
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function runAnalysis() {
    const area = document.getElementById('progressArea');
    const fill = document.getElementById('progressFill');
    area.style.display = 'block';
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
            setTimeout(() => {
                area.style.display = 'none';
                fill.style.width = '0%';
                alert('Analisis selesai! 1,240 dokumen berhasil dianalisis.');
            }, 500);
        }
        fill.style.width = progress + '%';
    }, 300);
}
</script>
@endpush
