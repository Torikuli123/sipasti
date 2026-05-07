@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Laporan Arsip</h2>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('export.index') }}" class="btn btn-outline">
            <i class="fas fa-file-excel" style="color:var(--success);"></i> Export Excel
        </a>
        <a href="{{ route('arsip.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Arsip
        </a>
    </div>
</div>

<!-- Summary Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-database"></i></div>
        <div>
            <div class="stat-label">Total Records</div>
            <div class="stat-value">{{ $total ?? '12,482' }}</div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> +12% from last month</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="stat-label">Active Reports</div>
            <div class="stat-value">{{ $active ?? '854' }}</div>
            <div class="stat-change" style="color:var(--text-muted);">System-wide active files</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-hdd"></i></div>
        <div>
            <div class="stat-label">Storage Used</div>
            <div class="stat-value">245 GB</div>
            <div style="margin-top:6px;">
                <div class="progress-bar" style="height:5px; background:var(--border); border-radius:3px; overflow:hidden;">
                    <div style="width:68%; height:100%; background:var(--accent); border-radius:3px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF2F2; color:var(--danger);"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-label">Pending Review</div>
            <div class="stat-value">42</div>
            <div class="stat-change down"><i class="fas fa-exclamation"></i> Requires attention</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="section-card">
    <!-- Filter Bar -->
    <div class="filter-bar">
        <span class="filter-label">Filter by:</span>
        <select class="filter-select" name="category" onchange="this.form.submit()">
            <option>All Categories</option>
            <option>Finance</option>
            <option>Legal</option>
            <option>HR Records</option>
            <option>Strategy</option>
        </select>
        <select class="filter-select" name="status">
            <option>Status</option>
            <option>Active</option>
            <option>Archived</option>
            <option>Pending</option>
        </select>
        <span class="showing-info">Showing 1–10 of {{ $total ?? '12,482' }}</span>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID Archive</th>
                    <th>Judul Arsip</th>
                    <th>Kategori</th>
                    <th>Tanggal Upload</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsips ?? [] as $arsip)
                <tr>
                    <td><span class="doc-id">{{ $arsip->nomor_definitif }}</span></td>
                    <td>
                        <div class="doc-title">{{ $arsip->judul }}</div>
                        <div class="doc-file">{{ $arsip->file_name ?? '' }}</div>
                    </td>
                    <td>
                        <span class="badge-cat cat-{{ strtolower($arsip->kategori ?? 'finance') }}">{{ $arsip->kategori ?? '-' }}</span>
                    </td>
                    <td>{{ $arsip->created_at ? $arsip->created_at->format('d M Y') : '-' }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($arsip->status ?? 'active') }}">
                            <span style="width:5px; height:5px; border-radius:50%; background:currentColor; display:inline-block;"></span>
                            {{ ucfirst($arsip->status ?? 'Active') }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon view" title="View"><i class="fas fa-eye"></i></button>
                            <a href="{{ route('arsip.edit', $arsip->id) }}" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('arsip.destroy', $arsip->id) }}" onsubmit="return confirm('Yakin hapus arsip ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                {{-- Demo rows --}}
                @php
                $demoData = [
                    ['#ARC-2024-09', 'Laporan Keuangan Q1 2024', 'finance', 'Financial_Report_Q1.pdf', '12 Nov 2024', 'active'],
                    ['#ARC-2024-045', 'Surat Keputusan Direksi No. 4', 'legal', 'SK_Dir_04_2024.docx', '15 Mar 2024', 'active'],
                    ['#ARC-2023-982', 'Data Karyawan Periode 2023', 'hr', 'Employee_Records_2023.xlsx', '20 Dec 2023', 'archived'],
                    ['#ARC-2024-172', 'Kontrak Vendor IT Services', 'legal', 'Vendor_ContractIT.pdf', '05 Apr 2024', 'active'],
                ];
                @endphp
                @foreach($demoData as $d)
                <tr>
                    <td><span class="doc-id">{{ $d[0] }}</span></td>
                    <td>
                        <div class="doc-title">{{ $d[1] }}</div>
                        <div class="doc-file">{{ $d[2] }}</div>
                    </td>
                    <td><span class="badge-cat cat-{{ $d[2] }}">{{ ucfirst($d[2]) }}</span></td>
                    <td>{{ $d[4] }}</td>
                    <td>
                        <span class="status-badge status-{{ $d[5] }}">
                            <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                            {{ ucfirst($d[5]) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon view"><i class="fas fa-eye"></i></button>
                            <button class="btn-icon edit"><i class="fas fa-pen"></i></button>
                            <button class="btn-icon delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <div style="display:flex; gap:6px; align-items:center;">
            <button class="page-btn">Previous</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">Next</button>
        </div>
        <div class="page-jump">
            Jump to page:
            <input type="number" value="1" min="1">
        </div>
    </div>
</div>
@endsection
