<?php

use Phinx\Seed\AbstractSeed;

class ProductSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'name'          => $faker->company . ' - ' .$faker->numberBetween($min = 1, $max = 1000) . 'L',
                'price'         => $faker->numberBetween($min = 100, $max = 19000),
                'description'   => $faker->catchPhrase,
                'created_at'    => date('Y-m-d H:i:s'),
                'modified_at'   => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('products', $data);
    }
}