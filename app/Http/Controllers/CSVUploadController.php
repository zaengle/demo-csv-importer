<?php

namespace App\Http\Controllers;

use App\CSVUpload;
use App\Requests\CSVUploads\StoreCSVUploadRequest;

/**
 * Class CSVUploadController
 * @package App\Http\Controllers
 */
class CSVUploadController extends Controller
{

    /**
     * @return $this
     */
    public function index()
    {
        return view('csv-uploads.index')->with([
            'csvUploads' => CSVUpload::all()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('csv-uploads.create');
    }

    /**
     * @param StoreCSVUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreCSVUploadRequest $request)
    {
        $data = collect(array_map('str_getcsv', file($request->file('csvFile')->getRealPath())));

        if ($request->has('hasHeaders')) {
            $headerRow = $data->shift();

            $data->transform(function ($row) use ($headerRow) {
                return collect($row)->mapWithKeys(function ($value, $index) use ($headerRow) {
                    return [$headerRow[$index] => $value];
                })->toArray();
            });
        }

        if ($data->count() >= 1) {
            $csvUpload = CSVUpload::create([
                'original_filename' => $request->file('csvFile')->getClientOriginalName(),
                'has_headers'       => $request->has('hasHeaders'),
                'file_contents'     => $data
            ]);

            return redirect(route('csv-uploads.map-columns.show', $csvUpload->getKey()));
        } else {
            return back()->withError('We were not able to locate any eligible rows. Check the document and try again.');
        }
    }
}