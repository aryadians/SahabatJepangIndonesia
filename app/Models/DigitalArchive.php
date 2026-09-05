<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'archive_no',
        'title',
        'category',
        'reimbursement_id',
        'uploader_name',
        'document_date',
        'file_name',
        'file_type',
        'file_size',
        'file_base64',
        'notes',
    ];

    protected $casts = [
        'document_date' => 'date',
    ];

    /**
     * Relasi ke transaksi reimburse jika berkaitan
     */
    public function reimbursement(): BelongsTo
    {
        return $this->belongsTo(Reimbursement::class, 'reimbursement_id');
    }

    /**
     * Cek apakah berkas merupakan gambar (JPEG, PNG, WEBP)
     */
    public function isImage(): bool
    {
        if (str_starts_with($this->file_base64, 'data:image/')) {
            return true;
        }
        return in_array(strtolower($this->file_type ?? ''), ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
    }

    /**
     * Helper Badge Kategori Arsip
     */
    public function getCategoryBadgeAttribute(): array
    {
        return match ($this->category) {
            'nota_reimburse' => ['label' => 'Nota & Kuitansi Reimburse', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'color' => 'text-emerald-600'],
            'kuitansi_hotel_tiket' => ['label' => 'Tiket & Hotel Dinas', 'bg' => 'bg-blue-100 text-blue-800 border-blue-200', 'color' => 'text-blue-600'],
            'dokumen_mou' => ['label' => 'Naskah Kerjasama MoU', 'bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'color' => 'text-purple-600'],
            'surat_tugas' => ['label' => 'Surat Tugas Dinas Luar Kota', 'bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'color' => 'text-amber-600'],
            'legalitas_izin' => ['label' => 'Legalitas & Izin Lembaga', 'bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'color' => 'text-rose-600'],
            default => ['label' => 'Dokumen Penting Lainnya', 'bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'color' => 'text-slate-600'],
        };
    }

    /**
     * Generate Nomor Arsip Unik
     */
    public static function generateNumber(): string
    {
        $period = now()->format('Ym');
        $count = static::where('archive_no', 'like', "DOC-SJI/{$period}/%")->count() + 1;
        $serial = str_pad($count, 4, '0', STR_PAD_LEFT);
        return "DOC-SJI/{$period}/{$serial}";
    }
}
