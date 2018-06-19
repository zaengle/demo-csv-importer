    <?php

    use Faker\Generator as Faker;

    $factory->define(\App\CSVRow::class, function (Faker $faker) {
        return [
            'contents'             => [],
            'csv_upload_id' => function () {
                return factory(\App\CSVUpload::class)->create()->id;
            }
        ];
    });