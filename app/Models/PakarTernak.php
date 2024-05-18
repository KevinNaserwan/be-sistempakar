<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PakarTernak extends Model
{
    use HasFactory;
    protected $table = 'pakar_ternak';
    protected $fillable = [
        'waktu_panen',
        'budget_tahunan',
        'metode_panen',
        'jenis_pakan',
        'jenis_ikan',
        'keyakinan_metode_pakan',
        'keyakinan_metode_panen',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}
