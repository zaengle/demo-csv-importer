<?php

namespace App\Jobs;

use App\CSVRow;
use App\Services\CSVImporter\CSVImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportCSVRow implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var CSVRow
     */
    private $csvRow;

    /**
     * Create a new job instance.
     *
     * @param CSVRow $csvRow
     */
    public function __construct(CSVRow $csvRow)
    {
        $this->csvRow = $csvRow;
    }

    /**
     * Execute the job.
     *
     * @param CSVImporter $csvImporter
     * @return void
     */
    public function handle(CSVImporter $csvImporter)
    {
        $csvImporter->importRow($this->csvRow);
    }
}
