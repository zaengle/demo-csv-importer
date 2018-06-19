    <?php

    use Faker\Generator as Faker;

    $factory->define(\App\CSVUpload::class, function(Faker $faker) {
        return [
            'original_filename' => $faker->word . '.csv',
            'has_headers'       => true,
            'file_contents'     => [
                ["first_name" => "Prince", "last_name" => "Rau", "email" => "ndickinson@hotmail.com"],
                ["first_name" => "Loraine", "last_name" => "Erdman", "email" => "pgerhold@gmail.com"],
                ["first_name" => "Stacey", "last_name" => "Raynor", "email" => "hbauch@gmail.com"],
            ],
            'column_mapping'    => []
        ];
    });