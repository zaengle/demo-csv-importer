<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CSVRowLog
 * @package App
 */
class CSVRowLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'csv_row_logs';

    /**
     * @var array
     */
    protected $fillable = [
        'csv_row_id',
        'code',
        'pipe',
        'message',
        'level'
    ];

}
