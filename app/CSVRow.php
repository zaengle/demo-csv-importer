<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CSVRow extends Model
{
    /**
     * @var string
     */
    protected $table = 'csv_rows';

    /**
     * @var array
     */
    protected $fillable = [
        'csv_upload_id',
        'contents',
        'imported_at',
        'failed_at',
        'warned_at'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'imported_at',
        'failed_at',
        'warned_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'contents' => 'array'
    ];

    /**
     * @param $query
     */
    public function scopePendingImport($query)
    {
        $query->whereNull('imported_at');
    }
}
