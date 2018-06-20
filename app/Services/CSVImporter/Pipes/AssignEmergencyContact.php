<?php

namespace App\Services\CSVImporter\Pipes;

use App\EmergencyContact;
use App\Services\CSVImporter\CSVImportTraveler;
use App\Services\CSVImporter\Exceptions\MissingEmergencyContactNameException;
use App\Services\CSVImporter\Exceptions\MissingEmergencyContactPhoneException;

/**
 * Class AssignEmergencyContact
 * @package App\Services\CSVImporter\Pipes
 */
class AssignEmergencyContact implements CSVImporterPipe
{

    /**
     * @param CSVImportTraveler $traveler
     * @param \Closure $next
     * @return mixed
     * @throws MissingEmergencyContactNameException
     * @throws MissingEmergencyContactPhoneException
     */
    public function handle(CSVImportTraveler $traveler, \Closure $next)
    {
        $this->validateData($traveler);

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

    /**
     * @param $traveler
     * @throws MissingEmergencyContactNameException
     * @throws MissingEmergencyContactPhoneException
     */
    private function validateData($traveler)
    {
        if ( ! isset($traveler->getRow()->contents['emergency_contact_name'])
            || empty($traveler->getRow()->contents['emergency_contact_name'])) {
            throw new MissingEmergencyContactNameException('Emergency contact is missing a name.');
        }

        if ( ! isset($traveler->getRow()->contents['emergency_contact_phone'])
            || empty($traveler->getRow()->contents['emergency_contact_phone'])) {
            throw new MissingEmergencyContactPhoneException('Emergency contact is missing a phone number.');
        }
    }
}