<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $table = 'months';

    protected $fillable = ['month_name', 'year_id', 'collection', 'distribution'];

    // Relationship with the years table (Many-to-One)
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    protected static function booted()
    {
        static::saving(function ($record) {
            $record->collection = intval(str_replace(['.', ','], '', $record->collection));
            $record->distribution = intval(str_replace(['.', ','], '', $record->distribution));
        });
    }
}
