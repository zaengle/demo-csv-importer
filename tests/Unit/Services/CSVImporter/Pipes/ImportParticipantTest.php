<?php

namespace Tests\Services\CSVImporter\Pipes;

use App\CSVRow;
use App\Services\CSVImporter\CSVImportTraveler;
use App\Services\CSVImporter\Pipes\ImportParticipant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportParticipantTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_imports_a_new_participant_from_a_csv_row()
    {
        $rowContents = [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'john-doe@example.com'
        ];

        $csvRow = factory(CSVRow::class)->create(['contents' => $rowContents]);

        (new ImportParticipant())->handle(
            (new CSVImportTraveler())->setRow($csvRow),
            function () {
            }
        );

        $this->assertDatabaseHas('participants', $rowContents);
    }
}