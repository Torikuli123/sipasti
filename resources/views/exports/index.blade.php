@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Ekspor Data Arsip</h2>
        <p>Atur filter dan lihat pratinjau data arsip sebelum diunduh ke Excel.</p>
    </div>
</div>

<div class="export-grid">
    <div>
        <div class="form-section" style="margin-bottom:16px;">
            <div class="form-section-title">
                <i class="fas fa-sliders-h" style="color:var(--accent);"></i>
                Filter Ekspor
            </div>

            <form id="filterForm" method="GET" action="{{ route('export.index') }}">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Upload Mulai</label>
                        <input type="date" name="start_date" class="form-control" id="filterStartDate" value="{{ request('start_date') }}" onchange="submitFilter()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Upload Akhir</label>
                        <input type="date" name="end_date" class="form-control" id="filterEndDate" value="{{ request('end_date') }}" onchange="submitFilter()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-control" id="filterCategory" onchange="submitFilter()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $categoryOption)
                                <option value="{{ $categoryOption }}" {{ request('category') === $categoryOption ? 'selected' : '' }}>{{ $categoryOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama File</label>
                        <input type="text" name="filename" class="form-control" id="filterFilename" value="{{ request('filename', 'export_arsip') }}" placeholder="Nama file unduhan">
                    </div>
                </div>
            </form>

            <form id="downloadForm" method="POST" action="{{ route('export.download') }}">
                @csrf
                <input type="hidden" name="start_date" id="downloadStartDate" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" id="downloadEndDate" value="{{ request('end_date') }}">
                <input type="hidden" name="category" id="downloadCategory" value="{{ request('category') }}">
                <input type="hidden" name="filename" id="downloadFilename" value="{{ request('filename', 'export_arsip') }}">

                <button type="submit" class="btn btn-success" style="margin-top:20px;">
                    <i class="fas fa-download"></i> Download Excel
                </button>
            </form>
        </div>

        <div class="section-card">
            <div class="section-header">
                <div class="section-title"><i class="fas fa-eye" style="color:var(--text-muted);margin-right:6px;"></i> Export Preview (Top 5 Records)</div>
                <span style="font-size:11px; color:var(--text-muted);">Pratinjau data arsip terbaru</span>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID Arsip</th>
                            <th>Nomor Definitif</th>
                            <th>Nomor Arsip Sementara</th>
                            <th>Seri</th>
                            <th>Masalah / Sub Seri</th>
                            <th>Kode Klasifikasi</th>
                            <th>Isi Informasi</th>
                            <th>Tanggal Tertua</th>
                            <th>Tanggal Termuda</th>
                            <th>Kondisi</th>
                            <th>Jumlah</th>
                            <th>Satuan Arsip</th>
                            <th>Tingkat Perkembangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($arsips->isNotEmpty())
                            @foreach($arsips->take(5) as $arsip)
                                <tr>
                                    <td>{{ $arsip->id }}</td>
                                    <td>{{ $arsip->nomor_definitif }}</td>
                                    <td>{{ $arsip->nomor_sementara }}</td>
                                    <td>{{ $arsip->seri }}</td>
                                    <td>{{ $arsip->masalah }}</td>
                                    <td>{{ $arsip->kode_klasifikasi }}</td>
                                    <td>{{ $arsip->isi_informasi }}</td>
                                    <td>{{ optional($arsip->tanggal_terhitung)->format('Y-m-d') }}</td>
                                    <td>{{ optional($arsip->tanggal_termuda)->format('Y-m-d') }}</td>
                                    <td>{{ $arsip->kondisi }}</td>
                                    <td>{{ $arsip->jumlah && $arsip->satuan_arsip ? $arsip->jumlah . ' ' . $arsip->satuan_arsip : $arsip->jumlah }}</td>
                                    <td>{{ $arsip->satuan_arsip }}</td>
                                    <td>{{ $arsip->tingkat_perkembangan }}</td>
                                    <td>{{ $arsip->status }}</td>
                                    <td><a href="{{ route('arsip.show', $arsip) }}" class="btn btn-secondary btn-sm">Detail</a></td>
                                </tr>
                            @endforeach
                        @else
                            @php
                                $sampleData = [
                                    [1, 'ARSIP-2026-001', 'AR-0001', 'Surat Keputusan', 'Kepala Sub Bagian Umum', 'K-01', 'Surat keputusan pengangkatan pegawai', '2026-01-05', '2026-05-01', 'Baik', '10', 'Lembar', 'Final', 'aktif'],
                                    [2, 'ARSIP-2026-002', 'AR-0002', 'Nota Dinas', 'Sub Bagian Kepegawaian', 'K-02', 'Nota dinas permohonan cuti', '2026-02-12', '2026-04-20', 'Baik', '3', 'Sampul', 'Draft', 'aktif'],
                                    [3, 'ARSIP-2026-003', 'AR-0003', 'Laporan Tahunan', 'Sub Bagian Keuangan', 'K-03', 'Laporan pertanggungjawaban tahunan', '2026-03-10', '2026-05-03', 'Baik', '2', 'Buku', 'Final', 'arsip'],
                                    [4, 'ARSIP-2026-004', 'AR-0004', 'Formulir', 'Sub Bagian Arsip', 'K-04', 'Formulir pengajuan arsip baru', '2026-04-01', '2026-05-05', 'Baik', '1', 'Bungkus', 'Draft', 'pending'],
                                    [5, 'ARSIP-2026-005', 'AR-0005', 'Notulen Rapat', 'Sub Bagian Perencanaan', 'K-05', 'Notulen rapat koordinasi internal', '2026-05-01', '2026-05-07', 'Baik', '5', 'Lembar', 'Final', 'aktif'],
                                ];
                            @endphp
                            @foreach($sampleData as $row)
                                <tr>
                                    <td>{{ $row[0] }}</td>
                                    <td>{{ $row[1] }}</td>
                                    <td>{{ $row[2] }}</td>
                                    <td>{{ $row[3] }}</td>
                                    <td>{{ $row[4] }}</td>
                                    <td>{{ $row[5] }}</td>
                                    <td>{{ $row[6] }}</td>
                                    <td>{{ $row[7] }}</td>
                                    <td>{{ $row[8] }}</td>
                                    <td>{{ $row[9] }}</td>
                                    <td>{{ $row[9] . ' ' . $row[10] }}</td>
                                    <td>{{ $row[10] }}</td>
                                    <td>{{ $row[11] }}</td>
                                    <td>{{ $row[12] }}</td>
                                    <td><span class="badge badge-secondary">Contoh</span></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="export-summary">
            <div style="margin-bottom:16px; padding-bottom:14px; border-bottom: 1px solid var(--border);">
                <div style="font-size:11px; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;">
                    RINGKASAN EKSPOR
                </div>
                <div class="export-count">{{ $arsips->count() }}</div>
                <div class="export-meta">Total arsip yang sesuai filter</div>
            </div>

            <div class="meta-row">
                <span class="meta-key">Perkiraan Ukuran</span>
                <span class="meta-val">{{ max(1, ceil($arsips->count() * 0.02)) }} KB</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Format</span>
                <span class="meta-val">.xlsx</span>
            </div>

            <div class="tip-box">
                <strong>💡 Tips:</strong><br>
                Opsi filter akan mempengaruhi data pada preview dan file unduhan.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function submitFilter() {
        const filterForm = document.getElementById('filterForm');
        const downloadForm = document.getElementById('downloadForm');

        document.getElementById('downloadStartDate').value = document.getElementById('filterStartDate').value;
        document.getElementById('downloadEndDate').value = document.getElementById('filterEndDate').value;
        document.getElementById('downloadCategory').value = document.getElementById('filterCategory').value;
        document.getElementById('downloadFilename').value = document.getElementById('filterFilename').value || 'export_arsip';

        filterForm.submit();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const filenameInput = document.getElementById('filterFilename');
        filenameInput.addEventListener('input', function () {
            document.getElementById('downloadFilename').value = this.value || 'export_arsip';
        });
    });
</script>
@endpush
