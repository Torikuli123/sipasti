@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Dashboard Overview</h2>
        <p>Ringkasan Aktivitas Pengelola Arsip Dan Kesehatan Sistem</p>
    </div>
    <a href="{{ route('arsip.create') }}" class="btn btn-primary">
        <i class="fas fa-upload"></i> Upload New Document
    </a>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-folder"></i></div>
        <div>
            <div class="stat-label">Total Arsip</div>
            <div class="stat-value">{{ number_format($totalArsip, 0, ',', '.') }}</div>
            <div class="stat-change"><i class="fas fa-arrow-up"></i> +12% Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-label">Arsip Aktif</div>
            <div class="stat-value">{{ number_format($arsipAktif, 0, ',', '.') }}</div>
            <div class="stat-change" style="color:var(--text-muted);"><i class="fas fa-check"></i> Akses Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="stat-label">Arsip Terbaru</div>
            <div class="stat-value">{{ number_format($arsipBaru, 0, ',', '.') }}</div>
            <div class="stat-change" style="color:var(--text-muted);"><i class="fas fa-history"></i> 24 Jam Terakhir</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-label">Pengguna</div>
            <div class="stat-value">{{ number_format($totalUsers, 0, ',', '.') }}</div>
            <div class="stat-change" style="color:var(--text-muted);"><i class="fas fa-building"></i> 8 Staf Departemen</div>
        </div>
    </div>
</div>

<!-- Main Grid -->
<div class="dashboard-grid">
    <!-- Chart -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <div class="section-title">Tren Volume Arsip</div>
                <div class="section-sub">Tingkat Penyimpanan Bulanan Selama 6 Bulan Terakhir</div>
            </div>
            <select class="filter-select">
                <option>Last 6 Months</option>
                <option>Last 12 Months</option>
                <option>This Year</option>
            </select>
        </div>
        <div class="chart-placeholder">
            @php
                $months = ['Jan','Feb','Mar','Apr','May','Jun'];
                $heights = [55, 70, 45, 80, 65, 90];
            @endphp
            @foreach($months as $i => $m)
            <div class="chart-bar-wrap">
                <div class="chart-bar {{ $i < 5 ? 'dim' : '' }}" style="height: {{ $heights[$i] }}px;"></div>
                <span class="chart-label">{{ $m }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- AI Card -->
    <div class="ai-card">
        <div class="ai-badge"><i class="fas fa-robot"></i> AI RECOMMENDATION</div>
        <div class="ai-title">Optimalkan Struktur Penyimpanan</div>
        <div class="ai-desc">AI kami mendeteksi 1.200 dokumen duplikat di Departemen A dan B. Menggabungkan ini dapat membebaskan 14GB ruang penyimpanan.</div>
        <a href="{{ route('ai.index') }}" class="btn-ai">
            <i class="fas fa-chart-line"></i> Analyze Repositories →
        </a>
    </div>
</div>

<!-- Bottom Grid -->
<div class="dashboard-bottom">
    <!-- Recent Activity -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">Aktivitas Terbaru</div>
        </div>
        @foreach($recentActivities as $activity)
        @php
            $actor = $activity->user?->name ?: 'System';
            $itemTitle = $activity->seri ?: $activity->file_name ?: ($activity->nomor_definitif ?: 'Dokumen Baru');
            $metaLabel = $activity->kategori ?: ucfirst($activity->status);
            $iconClass = match ($activity->status) {
                'pending' => 'fa-upload',
                'archived' => 'fa-archive',
                'active' => 'fa-folder-open',
                default => 'fa-file-alt',
            };
            $dotClass = match ($activity->status) {
                'pending' => 'dot-green',
                'archived' => 'dot-blue',
                'active' => 'dot-orange',
                default => 'dot-red',
            };
        @endphp
        <div class="activity-item">
            <div class="activity-dot {{ $dotClass }}"><i class="fas {{ $iconClass }}"></i></div>
            <div>
                <div class="activity-text"><strong>{{ $actor }}</strong> updated {{ $itemTitle }}</div>
                <div class="activity-meta">{{ $activity->updated_at->diffForHumans() }} • {{ $metaLabel }}</div>
            </div>
        </div>
    @endforeach
    </div>

    <!-- Recent Submissions -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">Pengajuan Terbaru</div>
            <a href="{{ route('arsip.index') }}" style="font-size:12px; color:var(--accent); text-decoration:none; font-weight:600;">View All</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Dokumen</th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentArsip as $item)
                        @php
                            $itemTitle = $item->seri ?: $item->file_name ?: ($item->nomor_definitif ?: 'Dokumen Baru');
                            $itemId = $item->nomor_sementara ?: '#'.str_pad($item->id, 4, '0', STR_PAD_LEFT);
                            $statusClass = $item->status === 'pending' ? 'status-pending' : ($item->status === 'archived' ? 'status-archived' : 'status-active');
                            $statusLabel = ucfirst($item->status);
                        @endphp
                        <tr>
                            <td>
                                <div class="doc-title">{{ $itemTitle }}</div>
                            </td>
                            <td><span class="doc-id">{{ $itemId }}</span></td>
                            <td><span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td><a href="{{ route('arsip.show', $item) }}" class="btn-icon view"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding: 20px;">Belum ada pengajuan arsip terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
