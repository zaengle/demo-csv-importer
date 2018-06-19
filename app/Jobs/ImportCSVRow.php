<?php

namespace App\Jobs;

use App\CSVRow;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
     * @return void
     */
    public function handle()
    {
        //
    }
}
