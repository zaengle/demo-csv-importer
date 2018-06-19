<?php

namespace App\Services\CSVImporter;

use App\CSVRow;
use App\Services\CSVImporter\Pipes\AssignEmergencyContact;
use App\Services\CSVImporter\Pipes\ImportParticipant;
use App\Services\CSVImporter\Pipes\MapAllergies;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class CSVImporter
{

    /**
     * @var CSVImportTraveler
     */
    private $progress;

    public function __construct(CSVImportTraveler $progress)
    {
        $this->progress = $progress;
    }

    public function importRow(CSVRow $row)
    {
        return app(Pipeline::class)
            ->send($this->progress->setRow($row))
            ->through([
                ImportParticipant::class,
                MapAllergies::class,
                AssignEmergencyContact::class
            ])->then(function ($progress) {
                DB::commit();

                return $progress;
            });
    }
}