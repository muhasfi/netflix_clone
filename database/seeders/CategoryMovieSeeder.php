<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategoryMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('content.category_movie')->truncate();

        $categoryIds = DB::table('content.categories')->pluck('id')->toArray();
        $movieIds = DB::table('content.movies')->pluck('id')->toArray();

        foreach ($movieIds as $movieId) {
            $randomCategories = array_rand($categoryIds, rand(1, 3));
            $randomCategories = (array) $randomCategories;

            foreach ($randomCategories as $categoryId) {
                DB::table('content.category_movie')->insert([
                    'category_id' => $categoryIds[$categoryId],
                    'movie_id' => $movieId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}