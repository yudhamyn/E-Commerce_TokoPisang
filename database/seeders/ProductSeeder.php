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
                'image' => '/product/produk1.jpg',
                'name' => 'Insektisida',
                'description' => "Insektisida adalah bahan-bahan kimia bersifat racun yang dipakai untuk membunuh serangga.",
                'price' => 22000,
                'stock' => 10
            ],
            [
                'image' => '/product/produk1.jpg',
                'name' => 'Fungisida',
                'description' => "Insektisida adalah sistemik yang bersifat protektif dan kuratif berbentuk pekatan suspensi berwarna merah muda digunakan untuk mengendalikan penyakit bulai (Peronosclerospora maydis) pada tanaman jagung.",
                'price' => 22000,
                'stock' => 10
            ],
            [
                'image' => '/product/produk1.jpg',
                'name' => 'Herbisida',
                'description' => "Insektisida adalah sistemik yang bersifat protektif dan kuratif berbentuk pekatan suspensi berwarna merah muda digunakan untuk mengendalikan penyakit bulai (Peronosclerospora maydis) pada tanaman jagung.",
                'price' => 22000,
                'stock' => 10
            ],
            [
                'image' => '/product/produk1.jpg',
                'name' => 'Bakterisida',
                'description' => "Insektisida adalah sistemik yang bersifat protektif dan kuratif berbentuk pekatan suspensi berwarna merah muda digunakan untuk mengendalikan penyakit bulai (Peronosclerospora maydis) pada tanaman jagung.",
                'price' => 22000,
                'stock' => 10
            ],
            [
                'image' => '/product/produk1.jpg',
                'name' => 'Perstisida',
                'description' => "Insektisida adalah sistemik yang bersifat protektif dan kuratif berbentuk pekatan suspensi berwarna merah muda digunakan untuk mengendalikan penyakit bulai (Peronosclerospora maydis) pada tanaman jagung.",
                'price' => 22000,
                'stock' => 10
            ],
        ]);
    }
}
