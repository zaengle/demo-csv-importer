<?php

namespace Tests\Services\CSVImporter\Pipes;

use App\CSVRow;
use App\Participant;
use App\Services\CSVImporter\CSVImportTraveler;
use App\Services\CSVImporter\Pipes\MapAllergies;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MapAllergiesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_allergy_record_and_links_the_participant()
    {
        $participant = factory(Participant::class)->create();

        $rowContents = [
            'allergies' => 'gluten, dairy'
        ];

        $csvRow = factory(CSVRow::class)->create(['contents' => $rowContents]);

        $traveler = (new CSVImportTraveler())
            ->setRow($csvRow)
            ->setParticipant($participant);

        (new MapAllergies)->handle($traveler, function () {
        });

        $this->assertTrue($participant->fresh()->allergies->contains(function ($allergy) {
            return $allergy->title == 'gluten';
        }));

        $this->assertTrue($participant->fresh()->allergies->contains(function ($allergy) {
            return $allergy->title == 'dairy';
        }));
    }
}