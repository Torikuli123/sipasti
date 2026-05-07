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
            <div class="stat-value">{{ number_format($total) }}</div>
            <div class="stat-change" style="color:var(--text-muted);">Keseluruhan data arsip</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="stat-label">Active Reports</div>
            <div class="stat-value">{{ number_format($active) }}</div>
            <div class="stat-change" style="color:var(--text-muted);">Arsip berstatus aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-hdd"></i></div>
        <div>
            <div class="stat-label">Storage Efficiency</div>
            <div class="stat-value">Optimized</div>
            <div style="margin-top:6px;">
                <div class="progress-bar" style="height:5px; background:var(--border); border-radius:3px; overflow:hidden;">
                    <div style="width:100%; height:100%; background:var(--success); border-radius:3px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF2F2; color:var(--danger);"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-label">Pending Review</div>
            <div class="stat-value">{{ \App\Models\Arsip::where('status', 'pending')->count() }}</div>
            <div class="stat-change down" style="color:var(--text-muted);">Membutuhkan tindakan</div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="section-card">
    <!-- Filter Bar -->
    <form action="{{ route('arsip.index') }}" method="GET" class="filter-bar" id="filterForm">
        <span class="filter-label">Filter by:</span>
        <select class="filter-select" name="category" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <select class="filter-select" name="status" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        
        <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
            <div class="search-box" style="margin:0; padding:4px 12px; border-radius:var(--radius-sm);">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari nomor atau judul..." value="{{ request('search') }}" style="width:180px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if(request()->anyFilled(['category', 'status', 'search']))
                <a href="{{ route('arsip.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </div>
    </form>

    <!-- Table -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nomor Definitif</th>
                    <th>Judul Arsip</th>
                    <th>Kategori</th>
                    <th>Tanggal Upload</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsips as $arsip)
                <tr>
                    <td><span class="doc-id">{{ $arsip->nomor_definitif ?: '-' }}</span></td>
                    <td>
                        <div class="doc-title">{{ $arsip->judul }}</div>
                        <div class="doc-file">{{ $arsip->file_name ?? 'No attachment' }}</div>
                    </td>
                    <td>
                        <span class="badge-cat cat-{{ strtolower($arsip->kategori ?? 'umum') }}">{{ $arsip->kategori ?? '-' }}</span>
                    </td>
                    <td>{{ $arsip->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($arsip->status) }}">
                            <span style="width:5px; height:5px; border-radius:50%; background:currentColor; display:inline-block;"></span>
                            {{ ucfirst($arsip->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('arsip.show', $arsip) }}" class="btn-icon view" title="View"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('arsip.edit', $arsip) }}" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('arsip.destroy', $arsip) }}" onsubmit="return confirm('Yakin hapus arsip ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">
                        <i class="fas fa-folder-open" style="font-size:24px; display:block; margin-bottom:10px;"></i>
                        Tidak ada arsip yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($arsips->hasPages())
    <div class="pagination">
        <div style="display:flex; gap:6px; align-items:center;">
            {{ $arsips->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        <div class="showing-info">
            Showing {{ $arsips->firstItem() }}–{{ $arsips->lastItem() }} of {{ $arsips->total() }} records
        </div>
    </div>
    @endif
</div>
@endsection
