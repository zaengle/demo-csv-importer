<?php

namespace App\Jobs;

use App\CSVRow;
use App\CSVUpload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeCSVUploadContentIntoCSVRows implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var CSVUpload
     */
    private $csvUpload;

    /**
     * Create a new job instance.
     *
     * @param CSVUpload $csvUpload
     */
    public function __construct(CSVUpload $csvUpload)
    {
        $this->csvUpload = $csvUpload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->csvUpload->file_contents)
            ->each(function ($csvRow) {
                dispatch(new ImportCSVRow(CSVRow::create([
                    'csv_upload_id' => $this->csvUpload->getKey(),
                    'contents'      => $this->normalizeCSVRow($csvRow)
                ])));
            });
    }

    /**
     * @param array $csvRow
     * @return array
     */
    private function normalizeCSVRow(array $csvRow)
    {
        return collect($this->csvUpload->column_mapping)
            ->flatMap(function ($columnName, $index) use ($csvRow) {
                return [$columnName => $csvRow[$index]];
            })->toArray();
    }
}
