<?php

namespace App\Services\CSVImporter\Pipes;

use App\EmergencyContact;
use App\Services\CSVImporter\CSVImportTraveler;

class AssignEmergencyContact implements CSVImporterPipe
{

    /**
     * @param CSVImportTraveler $traveler
     * @param \Closure $next
     * @return mixed
     */
    public function handle(CSVImportTraveler $traveler, \Closure $next)
    {
        if ( ! isset($traveler->getRow()->contents['emergency_contact_name'])
            || ! isset($traveler->getRow()->contents['emergency_contact_phone'])) {
            return $next($traveler);
        }

        $traveler->getParticipant()
            ->emergencyContact()
            ->associate(
                EmergencyContact::firstOrCreate([
                    'name'  => $traveler->getRow()->contents['emergency_contact_name'],
                    'phone' => $traveler->getRow()->contents['emergency_contact_phone']
                ])
            )->save();

        return $next($traveler);
    }
}