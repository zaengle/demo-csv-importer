<?php

namespace Tests\Services\CSVImporter;

use App\CSVRow;
use App\Services\CSVImporter\CSVImporter;
use App\Services\CSVImporter\CSVImportTraveler;
use App\Services\CSVImporter\Exceptions\MissingEmergencyContactNameException;
use App\Services\CSVImporter\Exceptions\MissingEmergencyContactPhoneException;
use App\Services\CSVImporter\Exceptions\MissingParticipantEmailException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CSVImporterTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_creates_a_log_for_a_successful_row_import()
    {
        $row = factory(CSVRow::class)->create([
            'contents' => [
                'first_name'              => 'John',
                'last_name'               => 'Doe',
                'email'                   => 'john@example.com',
                'emergency_contact_name'  => 'Jane Doe',
                'emergency_contact_phone' => '555 555 5555'
            ]
        ]);

        (new CSVImporter(
            new CSVImportTraveler()
        ))->importRow($row);

        $this->assertDatabaseHas('csv_row_logs', [
            'code'       => null,
            'level'      => 'success',
            'csv_row_id' => $row->getKey()
        ]);

        $this->assertEquals('imported', $row->fresh()->status);
    }

    /** @test */
    public function it_creates_a_log_if_a_row_is_missing_a_participant_email()
    {
        $row = factory(CSVRow::class)->create([
            'contents' => [
                'first_name' => 'John',
                'last_name'  => 'Doe'
            ]
        ]);

        (new CSVImporter(
            new CSVImportTraveler()
        ))->importRow($row);

        $this->assertDatabaseHas('csv_row_logs', [
            'code'       => MissingParticipantEmailException::CODE,
            'level'      => 'error',
            'csv_row_id' => $row->getKey()
        ]);

        $this->assertEquals('failed', $row->fresh()->status);
    }

    /** @test */
    public function it_creates_a_log_if_a_row_is_missing_an_emergency_contact_phone()
    {
        $row = factory(CSVRow::class)->create([
            'contents' => [
                'first_name'             => 'John',
                'last_name'              => 'Doe',
                'email'                  => 'john@example.com',
                'emergency_contact_name' => 'Jane Doe'
            ]
        ]);

        (new CSVImporter(
            new CSVImportTraveler()
        ))->importRow($row);

        $this->assertDatabaseHas('csv_row_logs', [
            'code'       => MissingEmergencyContactPhoneException::CODE,
            'level'      => 'error',
            'csv_row_id' => $row->getKey()
        ]);

        $this->assertEquals('failed', $row->fresh()->status);
    }

    /** @test */
    public function it_creates_a_log_if_a_row_is_missing_an_emergency_contact_name()
    {
        $row = factory(CSVRow::class)->create([
            'contents' => [
                'first_name'              => 'John',
                'last_name'               => 'Doe',
                'email'                   => 'john@example.com',
                'emergency_contact_phone' => '555-555-55555'
            ]
        ]);

        (new CSVImporter(
            new CSVImportTraveler()
        ))->importRow($row);

        $this->assertDatabaseHas('csv_row_logs', [
            'code'       => MissingEmergencyContactNameException::CODE,
            'level'      => 'error',
            'csv_row_id' => $row->getKey()
        ]);

        $this->assertEquals('failed', $row->fresh()->status);
    }
}