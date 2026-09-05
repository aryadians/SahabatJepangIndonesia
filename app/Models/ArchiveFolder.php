<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'color',
        'created_by',
    ];

    /**
     * Folder Induk (Parent)
     */
    public function parent()
    {
        return $this->belongsTo(ArchiveFolder::class, 'parent_id');
    }

    /**
     * Sub-folder (Children)
     */
    public function children()
    {
        return $this->hasMany(ArchiveFolder::class, 'parent_id')->orderBy('name', 'asc');
    }

    /**
     * Berkas arsip di dalam folder ini
     */
    public function archives()
    {
        return $this->hasMany(DigitalArchive::class, 'folder_id')->latest();
    }

    /**
     * Breadcrumbs / Jalur Navigasi Lengkap
     */
    public function getBreadcrumbs(): array
    {
        $crumbs = [];
        $current = $this;

        while ($current) {
            array_unshift($crumbs, [
                'id' => $current->id,
                'name' => $current->name,
            ]);
            $current = $current->parent;
        }

        return $crumbs;
    }
}
