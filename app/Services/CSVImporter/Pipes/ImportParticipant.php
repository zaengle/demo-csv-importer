<?php

namespace App\Services\CSVImporter\Pipes;

use App\Participant;
use App\Services\CSVImporter\CSVImportTraveler;

class ImportParticipant implements CSVImporterPipe
{

    /**
     * @param CSVImportTraveler $traveler
     * @param \Closure $next
     * @return mixed
     */
    public function handle(CSVImportTraveler $traveler, \Closure $next)
    {
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