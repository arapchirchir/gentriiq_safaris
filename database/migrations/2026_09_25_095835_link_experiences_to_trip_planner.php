<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Experiences replace the hard-coded trip types in the public trip planner.
     */
    public function up(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->boolean('show_in_planner')->default(false)->index()->after('featured');
        });

        // Inquiries keep the experiences a guest picked; an experience in use cannot be deleted.
        Schema::create('experience_inquiry', function (Blueprint $table) {
            $table->foreignId('inquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('experience_id')->constrained()->restrictOnDelete();
            $table->primary(['inquiry_id', 'experience_id']);
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('trip_type');
        });

        DB::table('experiences')
            ->whereIn('slug', ['big-five-safaris', 'honeymoon-safaris', 'family-safaris', 'photography-safaris', 'cultural-tours', 'bush-to-beach'])
            ->update(['show_in_planner' => true]);

        // The planner previously offered these two trip types; keep them available as planner-only experiences.
        DB::table('experiences')->insertOrIgnore([
            [
                'name' => 'Mountain Trekking',
                'slug' => 'mountain-trekking',
                'summary' => 'Guided Kilimanjaro and Mount Kenya climbs with experienced mountain crews.',
                'image' => 'https://images.unsplash.com/photo-1621414050946-1b936a78491f?auto=format&fit=crop&w=800&q=80',
                'featured' => false,
                'show_in_planner' => true,
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beach Holidays',
                'slug' => 'beach-holidays',
                'summary' => 'Relaxed white-sand stays on Diani Beach and Zanzibar.',
                'image' => 'https://images.unsplash.com/photo-1607444807093-eefb769187da?auto=format&fit=crop&w=800&q=80',
                'featured' => false,
                'show_in_planner' => true,
                'sort_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('experiences')->whereIn('slug', ['mountain-trekking', 'beach-holidays'])->delete();

        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('trip_type')->default('safari')->after('token');
        });

        Schema::dropIfExists('experience_inquiry');

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn('show_in_planner');
        });
    }
};
