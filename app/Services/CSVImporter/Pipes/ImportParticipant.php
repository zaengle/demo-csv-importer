<?php

namespace App\Services\CSVImporter\Pipes;

use App\Participant;
use App\Services\CSVImporter\CSVImportTraveler;
use App\Services\CSVImporter\Exceptions\MissingParticipantEmailException;

/**
 * Class ImportParticipant
 * @package App\Services\CSVImporter\Pipes
 */
class ImportParticipant implements CSVImporterPipe
{

    /**
     * @param CSVImportTraveler $traveler
     * @param \Closure $next
     * @return mixed
     * @throws MissingParticipantEmailException
     */
    public function handle(CSVImportTraveler $traveler, \Closure $next)
    {
        if ( ! isset($traveler->getRow()->contents['email'])) {
            throw new MissingParticipantEmailException('No email was set for participant.');
        }

        $participant = Participant::firstOrCreate([
            'email' => $traveler->getRow()->contents['email']
        ], [
            'first_name' => $traveler->getRow()->contents['first_name'],
            'last_name'  => $traveler->getRow()->contents['last_name']
        ]);

        $traveler->setParticipant($participant);

        return $next($traveler);
    }
}