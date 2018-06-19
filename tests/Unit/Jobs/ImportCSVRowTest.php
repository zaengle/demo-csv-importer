<?php

namespace Tests\Unit\Jobs;

use App\CSVRow;
use App\CSVUpload;
use App\Jobs\ImportCSVRow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportCSVRowTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_imports_the_data_from_a_csv_row()
    {
        $csvUpload = factory(CSVUpload::class)->create();

        $csvRow = factory(CSVRow::class)->create([
            'csv_upload_id' => $csvUpload->id,
            'contents'             => [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'john-doe@gmail.com'
            ]
        ]);

        (new ImportCSVRow($csvRow))->handle();

        $this->assertNull($csvRow->fresh()->errored_at);

        $this->assertDatabaseHas('users', [
            'email'      => 'john-doe@gmail.com',
            'first_name' => 'John',
            'last_name'  => 'Doe'
        ]);
    }
}