<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Follow-up history: an append-only log of staff updates (status + note) per inquiry,
     * replacing the single overwritable internal_notes field.
     */
    public function up(): void
    {
        Schema::create('inquiry_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->cascadeOnDelete();
            // Author details are copied so history keeps its names if a staff account is removed.
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author_name');
            $table->string('author_role')->nullable();
            $table->string('status');
            $table->string('previous_status')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['inquiry_id', 'created_at']);
        });

        // Keep any notes already written on the live site as the first history entry.
        DB::table('inquiries')->whereNotNull('internal_notes')->where('internal_notes', '!=', '')
            ->orderBy('id')
            ->each(function (object $inquiry): void {
                DB::table('inquiry_updates')->insert([
                    'inquiry_id' => $inquiry->id,
                    'author_name' => 'Earlier staff notes',
                    'status' => $inquiry->status,
                    'note' => $inquiry->internal_notes,
                    'created_at' => $inquiry->updated_at,
                    'updated_at' => $inquiry->updated_at,
                ]);
            });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn('internal_notes');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->text('internal_notes')->nullable()->after('special_requests');
        });

        // Fold the history back into one note per inquiry.
        DB::table('inquiry_updates')->whereNotNull('note')->orderBy('id')->get()
            ->groupBy('inquiry_id')
            ->each(function ($updates, $inquiryId): void {
                DB::table('inquiries')->where('id', $inquiryId)->update([
                    'internal_notes' => $updates->map(fn ($u) => "{$u->author_name}: {$u->note}")->implode("\n\n"),
                ]);
            });

        Schema::dropIfExists('inquiry_updates');
    }
};
