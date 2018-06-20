@extends('layouts/main')

@section('content')
    <div class="w-full max-w-md mx-auto overflow-hidden">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h3 class="pb-4 mt-0 font-bold">All Uploads</h3>

            <table class="w-full mb-8 -mx-2">
                <thead>
                <tr>
                    <th class="p-2 text-left">Filename</th>
                    <th class="p-2 text-left">Total</th>
                    <th class="p-2 text-left">Imported</th>
                    <th class="p-2 text-left">Warned</th>
                    <th class="p-2 text-left">Failed</th>
                    <th></th>
                </tr>
                </thead>
                @if($csvUploads->count())
                    <tbody>
                    @foreach($csvUploads as $csvUpload)
                        <tr>
                            <td class="p-2 text-sm">
                                {{ $csvUpload->original_filename }}
                            </td>
                            <td class="p-2 text-sm">
                                {{ count($csvUpload->file_contents) }}
                            </td>
                            <td class="p-2 text-sm">
                                {{ $csvUpload->importedRows->count() }}
                            </td>
                            <td class="p-2 text-sm">
                                {{ $csvUpload->warnedRows->count() }}
                            </td>
                            <td class="p-2 text-sm">
                                {{ $csvUpload->failedRows->count() }}
                            </td>

                            <td class="p-2 text-sm">
                                <a href="{{ route('csv-uploads.show', $csvUpload->getKey()) }}" class="text-blue">Details</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td class="p-2 text-sm">No results</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <a class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 no-underline rounded" href="{{ route('csv-uploads.create') }}">Upload CSV</a>
        </div>
    </div>
@endsection