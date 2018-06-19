<?php

namespace App\Requests\CSVUploads;

use Illuminate\Foundation\Http\FormRequest;

class StoreCSVUploadRequest extends FormRequest
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
            'csvFile' => 'required|mimes:csv,txt'
        ];
    }
}