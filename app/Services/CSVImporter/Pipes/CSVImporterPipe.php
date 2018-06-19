<?php

namespace App\Services\CSVImporter\Pipes;

use App\Services\CSVImporter\CSVImportTraveler;

/**
 * Interface CSVImporterPipe
 * @package App\Services\CSVImporter\Pipes
 */
interface CSVImporterPipe
{

    /**
     * @param CSVImportTraveler $traveler
     * @param \Closure $next
     * @return mixed
     */
    public function handle(CSVImportTraveler $traveler, \Closure $next);
}