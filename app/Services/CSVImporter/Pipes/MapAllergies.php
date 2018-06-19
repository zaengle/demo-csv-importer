<?php

namespace App\Services\CSVImporter\Pipes;

use App\Allergy;
use App\Services\CSVImporter\CSVImportTraveler;

class MapAllergies implements CSVImporterPipe
{

    /**
     * @param CSVImportTraveler $traveler
     * @param \Closure $next
     * @return mixed
     */
    public function handle(CSVImportTraveler $traveler, \Closure $next)
    {
        if ( ! isset($traveler->getRow()->contents['allergies'])) {
            return $next($traveler);
        }

        collect(explode(',', $traveler->getRow()->contents['allergies']))
            ->each(function ($allergy) use ($traveler) {
                $traveler->getParticipant()->allergies()->attach(
                    Allergy::firstOrCreate([
                        'title' => strtolower(trim($allergy))
                    ]));
            });

        return $next($traveler);
    }
}