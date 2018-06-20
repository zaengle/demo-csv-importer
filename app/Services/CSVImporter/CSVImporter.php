<?php

namespace App\Services\CSVImporter;

use App\CSVRow;
use App\CSVRowLog;
use App\Services\CSVImporter\Exceptions\MissingEmergencyContactNameException;
use App\Services\CSVImporter\Exceptions\MissingEmergencyContactPhoneException;
use App\Services\CSVImporter\Exceptions\MissingParticipantEmailException;
use App\Services\CSVImporter\Pipes\AssignEmergencyContact;
use App\Services\CSVImporter\Pipes\ImportParticipant;
use App\Services\CSVImporter\Pipes\MapAllergies;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

/**
 * Class CSVImporter
 * @package App\Services\CSVImporter
 */
class CSVImporter
{

    /**
     * @var CSVImportTraveler
     */
    private $traveler;

    /**
     * CSVImporter constructor.
     * @param CSVImportTraveler $traveler
     */
    public function __construct(CSVImportTraveler $traveler)
    {
        $this->traveler = $traveler;
    }

    /**
     * @param CSVRow $row
     * @return bool
     */
    public function importRow(CSVRow $row)
    {
        try {
            DB::beginTransaction();

            return app(Pipeline::class)
                ->send($this->traveler->setRow($row))
                ->through([
                    ImportParticipant::class,
                    MapAllergies::class,
                    AssignEmergencyContact::class
                ])->then(function ($progress) {
                    $this->traveler->getRow()->markImported();
                    DB::commit();

                    return $progress;
                });
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logException($e);

            return false;
        }
    }

    /**
     * @param \Exception $e
     */
    private function logException(\Exception $e)
    {
        switch (get_class($e)) {

            case MissingParticipantEmailException::class;
                $pipe = MissingParticipantEmailException::class;
                $code = MissingParticipantEmailException::CODE;
                break;
            case MissingEmergencyContactPhoneException::class;
                $pipe = MissingEmergencyContactPhoneException::class;
                $code = MissingEmergencyContactPhoneException::CODE;
                break;
            case MissingEmergencyContactNameException::class;
                $pipe = MissingEmergencyContactNameException::class;
                $code = MissingEmergencyContactNameException::CODE;
                break;

            default:
                $code = 'general_error';
                break;
        }

        $this->traveler->getRow()
            ->markFailed()
            ->logs()
            ->create([
                'pipe'    => $pipe ?? null,
                'code'    => $code ?? null,
                'message' => $e->getMessage(),
                'level'   => CSVRowLog::LEVEL_ERROR
            ]);
    }
}