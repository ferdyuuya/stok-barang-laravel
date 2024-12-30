<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id', 
        'quantity'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
