<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::query();

        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }
        if ($request->filled('status') && $request->status !== 'Status') {
            $query->where('status', strtolower($request->status));
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_definitif', 'like', '%' . $request->search . '%');
            });
        }

        $arsips = $query->orderBy('nomor_definitif', 'asc')->paginate(10);
        $total  = Arsip::count();
        $active = Arsip::where('status', 'active')->count();
        $categories = Arsip::distinct()->pluck('kategori')->filter();

        return view('arsip.index', compact('arsips', 'total', 'active', 'categories'));
    }

    public function create()
    {
        return view('arsip.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_definitif'       => 'nullable|string|max:100',
            'nomor_sementara'       => 'nullable|string|max:100',
            'seri'                  => 'nullable|string|max:255',
            'masalah'               => 'nullable|string|max:255',
            'kode_klasifikasi'      => 'nullable|string|max:50',
            'tingkat_perkembangan'  => 'nullable|string|max:50',
            'isi_informasi'         => 'nullable|string',
            'tanggal_terhitung'     => 'nullable|date',
            'tanggal_termuda'       => 'nullable|date',
            'kondisi'               => 'nullable|string|max:50',
            'jumlah'                => 'nullable|string|max:100',
            'satuan_arsip'          => 'nullable|string|max:50',
            'indeks_nama'           => 'nullable|string|max:255',
            'indeks_tempat'         => 'nullable|string|max:255',
            'indeks_masalah'        => 'nullable|string|max:255',
            'daftar_singkatan'      => 'nullable|string|max:255',
            'kepanjangan_singkatan' => 'nullable|string|max:255',
            'daftar_istilah'        => 'nullable|string|max:255',
            'arti_istilah'          => 'nullable|string',
            'file'                  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('arsip-files', 'public');
            $validated['file_path'] = $path;
            $validated['file_name'] = $request->file('file')->getClientOriginalName();
        }

        $validated['status']   = 'active';
        $validated['kategori'] = $this->guessKategori($validated['kode_klasifikasi'] ?? '');

        Arsip::create($validated);

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil ditambahkan!');
    }

    public function show(Arsip $arsip)
    {
        return view('arsip.show', compact('arsip'));
    }

    public function edit(Arsip $arsip)
    {
        return view('arsip.edit', compact('arsip'));
    }

    public function update(Request $request, Arsip $arsip)
    {
        $validated = $request->validate([
            'nomor_definitif'       => 'nullable|string|max:100',
            'seri'                  => 'nullable|string|max:255',
            'isi_informasi'         => 'nullable|string',
            'kondisi'               => 'nullable|string|max:50',
            'status'                => 'nullable|string|in:active,archived,pending',
        ]);

        $arsip->update($validated);

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil diperbarui!');
    }

    public function destroy(Arsip $arsip)
    {
        if ($arsip->file_path) {
            Storage::disk('public')->delete($arsip->file_path);
        }
        $arsip->delete();

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }

    private function guessKategori(string $kode): string
    {
        $kode = strtoupper($kode);
        if (str_starts_with($kode, 'KU')) return 'Finance';
        if (str_starts_with($kode, 'HK')) return 'Legal';
        if (str_starts_with($kode, 'KP')) return 'HR Records';
        return 'Umum';
    }
}
