<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CSVUpload
 * @package App
 */
class CSVUpload extends Model
{

    /**
     * @var string
     */
    protected $table = 'csv_uploads';

    /**
     * @var array
     */
    protected $fillable = [
        'original_filename',
        'has_headers',
        'file_contents',
        'column_mapping',
        'parsed_at',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'parsed_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'file_contents'  => 'array',
        'column_mapping' => 'array',
        'permissions'    => 'array'
    ];

    public function getHeaderRowAttribute()
    {
        return array_keys($this->file_contents[0]);
    }

    public function getPreviewRowsAttribute()
    {
        return array_slice($this->file_contents, 0, 5);
    }

    public function getAdditionalRowCountAttribute()
    {
        return (count($this->file_contents) - 5) < 0 ? 0 : count($this->file_contents) - 5;
    }

    public function getAvailableFieldsAttribute()
    {
        return [
            'first_name',
            'last_name',
            'email',
        ];
    }
}
