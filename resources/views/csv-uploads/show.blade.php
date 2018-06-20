@extends('layouts/main')

@section('content')
    <div class="w-full max-w-lg mx-auto overflow-hidden">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h3 class="pb-4 mt-0 font-bold">{{ $csvUpload->original_filename }}</h3>

            <table class="w-full mb-8 -mx-2">
                <thead>
                <tr>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left">Data</th>
                    <th class="p-2 text-left">Logs</th>
                </tr>
                </thead>
                @if($csvUpload->rows->count())
                    <tbody>
                    @foreach($csvUpload->rows as $row)
                        <tr>
                            <td class="p-2 text-sm">
                                @if($row->status == 'imported')
                                    <span class="text-green">Imported</span>
                                @elseif($row->status == 'warned')
                                    <span class="text-orange">Imported <span class="text-xs">(w/warning)</span></span>
                                @elseif($row->status == 'failed')
                                    <span class="text-red">Failed</span>
                                @endif
                            </td>
                            <td class="p-2 text-sm">
<pre class="text-xs bg-grey-lightest p-2 rounded"><code>{{ var_export($row->contents) }}</code></pre>
                            </td>

                            <td class="p-2 text-sm">

                                <ul class="list-reset">
                                    @foreach($row->logs as $log)
                                        @if($log->level == 'success')
                                            <li class="text-green">{{ $log->message }}</li>
                                        @elseif($log->level == 'info')
                                            <li class="text-blue">{{ $log->message }}</li>
                                        @elseif($log->level == 'error')
                                            <li class="text-red">{{ $log->message }}</li>
                                        @elseif($log->level == 'warn')
                                            <li class="text-orange">{{ $log->message }}</li>
                                        @else
                                            <li>{{ $log->message }}</li>
                                        @endif
                                    @endforeach
                                </ul>

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
        </div>
    </div>
@endsection