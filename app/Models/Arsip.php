<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsips';

    protected $fillable = [
        'nomor_definitif',
        'nomor_sementara',
        'seri',
        'masalah',
        'kode_klasifikasi',
        'tingkat_perkembangan',
        'isi_informasi',
        'tanggal_terhitung',
        'tanggal_termuda',
        'kondisi',
        'jumlah',
        'satuan_arsip',
        'indeks_nama',
        'indeks_tempat',
        'indeks_masalah',
        'daftar_singkatan',
        'kepanjangan_singkatan',
        'daftar_istilah',
        'arti_istilah',
        'file_path',
        'file_name',
        'kategori',
        'status',
        'user_id',
    ];

    protected $casts = [
        'tanggal_terhitung' => 'date',
        'tanggal_termuda'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Status constants
    const STATUS_ACTIVE   = 'active';
    const STATUS_ARCHIVED = 'archived';
    const STATUS_PENDING  = 'pending';

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeArchived($query)
    {
        return $query->where('status', self::STATUS_ARCHIVED);
    }

    public function getJudulAttribute(): string
    {
        return $this->seri ?? $this->nomor_definitif ?? 'Tanpa Judul';
    }
}
