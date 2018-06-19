@extends('layouts/main')
@section('content')
    <div class="w-full max-w-lg mx-auto overflow-hidden">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" style="overflow-x: scroll;">
            <h3 class="pb-4 mt-0 font-bold">Map fields</h3>
    <form class="form-horizontal" method="POST" action="{{ route('csv-uploads.map-columns.store', $csvUpload->getKey() )}}">
        {{ csrf_field() }}
        {{ method_field('post') }}

        <table class="w-full mb-8 -mx-2">
            @if ($csvUpload->has_headers)
                <tr>
                    @foreach ($csvUpload->headerRow as $headerField)
                        <th class="text-left p-2">{{ $headerField }}</th>
                    @endforeach
                </tr>
            @endif
            @foreach ($csvUpload->previewRows as $row)
                <tr>
                    @foreach ($row as $key => $value)
                        <td class="p-2 text-sm">{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
            @if($csvUpload->additionalRowCount)
                <tr>
                    <td colspan="100" class="p-2">
                        <div class="rounded border border-grey-lighter bg-grey-lightest py-2 text-xs text-center ">
                            +{{ $csvUpload->additionalRowCount }} more...
                        </div>
                    </td>
                </tr>
            @endif
            <tr>
                @foreach ($csvUpload->previewRows[0] as $key => $value)
                    <td class="p-2">
                        <div class="inline-block relative w-full">
                            <select name="fields[{{ $key }}]" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight">
                                @foreach ($csvUpload->availableFields as $availableField)
                                    <option value="{{ $availableField }}" @if ($key === $availableField) selected @endif>{{ $availableField }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </td>
                @endforeach
            </tr>
        </table>

        <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded">
            Import Data
        </button>

    </form>
        </div>
    </div>
@endsection