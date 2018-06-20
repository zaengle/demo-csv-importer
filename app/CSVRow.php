<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CSVRow
 * @package App
 */
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
     * @return string
     */
    public function getStatusAttribute()
    {
        if ( ! is_null($this->attributes['imported_at'])) {
            if ( ! is_null($this->attributes['warned_at'])) {
                return 'warned';
            }

            return 'imported';
        }

        if ( ! is_null($this->attributes['failed_at'])) {
            return 'failed';
        }
    }

    /**
     * @param $query
     */
    public function scopePendingImport($query)
    {
        $query->whereNull('imported_at');
    }

    /**
     * @param $query
     */
    public function scopeImported($query)
    {
        $query->whereNotNull('imported_at');
    }

    /**
     * @param $query
     */
    public function scopeWarned($query)
    {
        $query->whereNotNull('warned_at');
    }

    /**
     * @param $query
     */
    public function scopeFailed($query)
    {
        $query->whereNotNull('failed_at');
    }

    /**
     * @return $this
     */
    public function markImported()
    {
        $this->update([
            'imported_at' => Carbon::now()
        ]);

        $this->logs()->create([
            'message' => 'Row successfully imported.',
            'level'   => 'success'
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function markFailed()
    {
        $this->update([
            'failed_at' => Carbon::now()
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function markWarned()
    {
        $this->update([
            'warned_at' => Carbon::now()
        ]);

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(CSVRowLog::class, 'csv_row_id');
    }
}
