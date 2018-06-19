<?php

namespace Tests\Unit\Jobs;

use App\CSVRow;
use App\CSVUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use App\Jobs\DistributeCSVUploadContentIntoCSVRows as Job;

class DistributeCSVUploadContentIntoCSVRowsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_pushes_the_parsed_member_csv_data_into_individual_rows_without_headers()
    {
        Bus::fake();

        $csvUpload = factory(CSVUpload::class)->create([
            'has_headers'    => true,
            'column_mapping' => [
                0 => 'last_name',
                1 => 'first_name',
                2 => 'email'
            ],
            'file_contents'  => [
                [
                    'John',
                    'Doe',
                    'john-doe@gmail.com'
                ],
                [
                    'Jane',
                    'Doe',
                    'jane-doe@gmail.com'
                ],
            ]
        ]);

        (new Job($csvUpload))->handle();

        $this->assertDatabaseHas('csv_rows', [
            'csv_upload_id' => $csvUpload->getKey()
        ]);

        $this->assertTrue(CSVRow::all()->contains(function ($row) {
            return $row->contents === [
                    'last_name'  => 'John',
                    'first_name' => 'Doe',
                    'email'      => 'john-doe@gmail.com'
                ];
        }));

        $this->assertTrue(CSVRow::all()->contains(function ($row) {
            return $row->contents === [
                    'last_name'  => 'Jane',
                    'first_name' => 'Doe',
                    'email'      => 'jane-doe@gmail.com'
                ];
        }));
    }

    /** @test */
    public function it_pushes_the_parsed_member_csv_data_into_individual_rows_with_headers()
    {
        Bus::fake();

        $csvUpload = factory(CSVUpload::class)->create([
            'has_headers'    => true,
            'column_mapping' => [
                'last_name'  => 'last_name',
                'first_name' => 'first_name',
                'email'      => 'email'
            ],
            'file_contents'  => [
                [
                    'last_name' => 'John',
                    'first_name' => 'Doe',
                    'email' => 'john-doe@gmail.com'
                ],
                [
                    'last_name' => 'Jane',
                    'first_name' => 'Doe',
                    'email' => 'jane-doe@gmail.com'
                ],
            ]
        ]);

        (new Job($csvUpload))->handle();

        $this->assertDatabaseHas('csv_rows', [
            'csv_upload_id' => $csvUpload->getKey()
        ]);

        $this->assertTrue(CSVRow::all()->contains(function ($row) {
            return $row->contents === [
                    'last_name'  => 'John',
                    'first_name' => 'Doe',
                    'email'      => 'john-doe@gmail.com'
                ];
        }));

        $this->assertTrue(CSVRow::all()->contains(function ($row) {
            return $row->contents === [
                    'last_name'  => 'Jane',
                    'first_name' => 'Doe',
                    'email'      => 'jane-doe@gmail.com'
                ];
        }));
    }
}