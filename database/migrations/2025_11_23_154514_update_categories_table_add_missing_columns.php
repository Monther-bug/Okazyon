<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Add slug column if it doesn't exist
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            
            // Add is_active column if it doesn't exist
            if (!Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('type');
            }
            
            // Rename image_url to image if needed
            if (Schema::hasColumn('categories', 'image_url') && !Schema::hasColumn('categories', 'image')) {
                $table->renameColumn('image_url', 'image');
            }
        });
        
        // Generate slugs for existing categories
        DB::table('categories')->whereNull('slug')->orWhere('slug', '')->get()->each(function ($category) {
            DB::table('categories')
                ->where('id', $category->id)
                ->update(['slug' => Str::slug($category->name) ?: 'category-' . $category->id]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'slug')) {
                $table->dropColumn('slug');
            }
            
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            
            if (Schema::hasColumn('categories', 'image')) {
                $table->renameColumn('image', 'image_url');
            }
        });
    }
};
