<?php

namespace Tests\Feature\CSVUploads;

use App\CSVUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CSVUploadTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_imports_data_from_a_valid_csv_with_headers()
    {
        $csvFilename = 'valid-csv-with-headers.csv';
        $basePath = base_path('Tests/Stubs/' . $csvFilename);

        $csvFile = new UploadedFile(
            $basePath,
            $csvFilename,
            'text/csv',
            null,
            null,
            true
        );

        $this->post(route('csv-uploads.store'), [
            'csvFile' => $csvFile,
            'hasHeaders'   => true
        ]);

        $this->assertDatabaseHas('csv_uploads', [
            'original_filename' => $csvFilename,
            'has_headers'       => true
        ]);

        $upload = CSVUpload::where([
            'original_filename' => $csvFilename
        ])->first();

        $this->assertEquals([
            ["first_name" => "Prince", "last_name" => "Rau", "email" => "ndickinson@hotmail.com"],
            ["first_name" => "Loraine", "last_name" => "Erdman", "email" => "pgerhold@gmail.com"],
            ["first_name" => "Stacey", "last_name" => "Raynor", "email" => "hbauch@gmail.com"],
        ], $upload->file_contents);
    }

    /** @test */
    public function it_imports_data_from_a_valid_csv_without_headers()
    {
        $csvFilename = 'valid-csv-without-headers.csv';
        $basePath = base_path('Tests/Stubs/' . $csvFilename);

        $csvFile = new UploadedFile(
            $basePath,
            $csvFilename,
            'text/csv',
            null,
            null,
            true
        );

        $this->post(route('csv-uploads.store'), [
            'csvFile' => $csvFile
        ]);

        $this->assertDatabaseHas('csv_uploads', [
            'original_filename' => $csvFilename,
            'has_headers'       => false
        ]);

        $upload = CSVUpload::where([
            'original_filename' => $csvFilename
        ])->first();

        $this->assertEquals([
            ["Prince", "Rau", "ndickinson@hotmail.com"],
            ["Loraine", "Erdman", "pgerhold@gmail.com"],
            ["Stacey", "Raynor", "hbauch@gmail.com"],
        ], $upload->file_contents);
    }

    /** @test */
    public function it_saves_the_column_mapping_for_a_csv_upload()
    {
        $csvUpload = factory(CSVUpload::class)->create([
            'column_mapping' => []
        ]);

        $fields = [
            'first_name',
            'email',
            'last_name'
        ];

        $this->post(route('csv-uploads.map-columns.store', [
            'csvUpload' => $csvUpload,
            'fields' => $fields
        ]));

        $this->assertEquals($fields, $csvUpload->fresh()->column_mapping);
    }
}