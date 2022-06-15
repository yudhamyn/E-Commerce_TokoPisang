<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang bangka/uli",
                'description' => "Pisang Paling enak",
                "price" => 12000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang nangka",
                'description' => "Pisang Paling enak",
                "price" => 12000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang raja bulu",
                'description' => "Pisang Paling enak",
                "price" => 20000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg"
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang raja sereh",
                'description' => "Pisang Paling enak",
                "price" => 18000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang ambon lumut",
                'description' => "Pisang Paling enak",
                "price" => 16000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang ambon jepang",
                'description' => "Pisang Paling enak",
                "price" => 18000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg"
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang kepok",
                'description' => "Pisang Paling enak",
                "price" => 16000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang tanduk",
                'description' => "Pisang Paling enak",
                "price" => 24000,
                "stock" => 10,
                "weight" => "6 biji berat 2kg "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang emas",
                'description' => "Pisang Paling enak",
                "price" => 25000,
                "stock" => 10,
                "weight" => "1 sisir  "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang barangan",
                'description' => "Pisang Paling enak",
                "price" => 15000,
                "stock" => 10,
                "weight" => "1 sisir "
            ],
            [
                "image" => '/product/produk1.jpg',
                "name" => "Pisang Muli",
                'description' => "Pisang Paling enak",
                "price" => 12000,
                "stock" => 10,
                "weight" => "1 sisir berat 2kg"
            ]
        ]);
    }
}
