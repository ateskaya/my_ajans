<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('articles')
            ->where('image_url', 'like', '%unsplash.com%')
            ->update(['image_url' => null]);

        DB::table('case_studies')
            ->where('cover_image', 'like', '%unsplash.com%')
            ->update(['cover_image' => null]);
    }

    public function down(): void
    {
        // Unsplash URLs were removed because they return 404; no safe restore.
    }
};
