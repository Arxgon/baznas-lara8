<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    /** @use HasFactory<\Database\Factories\YearFactory> */
    use HasFactory;

    protected $table = 'years';

    protected $fillable = ['year'];

    // Array of month names in Indonesian
    public static $monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    // Relationship with the months table (One-to-Many)
    public function months()
    {
        return $this->hasMany(Month::class, 'year_id');
    }

    // Method untuk menghitung total collection dalam satu tahun
    public function totalCollection()
    {
        return $this->months()->sum('collection');
    }

    // Method untuk menghitung total distribution dalam satu tahun
    public function totalDistribution()
    {
        return $this->months()->sum('distribution');
    }
}
