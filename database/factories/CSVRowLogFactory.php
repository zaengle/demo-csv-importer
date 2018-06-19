    <?php

    use Faker\Generator as Faker;

    $factory->define(\App\CSVRowLog::class, function(Faker $faker) {
        return [
            'csv_row_id'   => function () {
                return factory(\App\CSVRow::class)->create()->id;
            },
            'pipe'            => null,
            'level'           => null,
            'message'         => $faker->sentence,
        ];
    });