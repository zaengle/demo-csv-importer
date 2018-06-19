<?php

namespace App\Requests\CSVUploads;

use Illuminate\Foundation\Http\FormRequest;

class StoreCSVUploadColumnMappingRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'fields' => 'required'
        ];
    }
}