@extends('layouts/main')

@section('content')
    <div class="w-full max-w-sm mx-auto overflow-hidden">

        @if(session()->has('error'))
            <div class="text-center bg-red rounded text-white max-w-sm mx-auto p-4 mb-8">
                {{ session()->get('error') }}
            </div>
        @endif

<form action="{{ route('csv-uploads.store') }}" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <h3 class="pb-4 mt-0 font-bold">Upload CSV</h3>
    <div class="mb-4">
        <input type="file" name="csvFile" id="csvFile">
    </div>
    <div class="mb-4">
        <input id="hasHeaders" name="hasHeaders" type="checkbox">
        <label for="hasHeaders">File contains header row</label>
    </div>
    <div class="mt-4">
        <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="submit">Upload</button>
    </div>
</form>
    </div>
@endsection