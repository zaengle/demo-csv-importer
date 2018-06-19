<?php

namespace App\Http\Controllers;

use App\CSVUpload;
use App\Jobs\DistributeCSVUploadContentIntoCSVRows;
use App\Requests\CSVUploads\StoreCSVUploadColumnMappingRequest;

class MapColumnsController extends Controller
{

    public function show(CSVUpload $csvUpload)
    {
        return view('csv-uploads.map-columns', compact('csvUpload'));
    }

    /**
     * @param CSVUpload $csvUpload
     * @param StoreCSVUploadColumnMappingRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CSVUpload $csvUpload, StoreCSVUploadColumnMappingRequest $request)
    {
        $csvUpload->update([
            'column_mapping' => $request->fields,
        ]);

         $this->dispatch(new DistributeCSVUploadContentIntoCSVRows($csvUpload));

        return redirect(route('csv-uploads.index'));
    }
}