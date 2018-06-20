<?php

namespace App\Services\CSVImporter\Pipes;

use App\Allergy;
use App\Services\CSVImporter\CSVImportTraveler;

/**
 * Class MapAllergies
 * @package App\Services\CSVImporter\Pipes
 */
class MapAllergies implements CSVImporterPipe
{

    const PARTICIPANT_HAS_DIETARY_NEEDS = 'participant_has_dietary_needs';

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

        if ( ! empty($traveler->getRow()->contents['allergies'])) {
            $traveler->getRow()
                ->markWarned()
                ->logs()
                ->create([
                    'code'    => self::PARTICIPANT_HAS_DIETARY_NEEDS,
                    'pipe'    => self::class,
                    'message' => 'Participant has dietary needs!',
                    'level'   => 'info'
                ]);
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