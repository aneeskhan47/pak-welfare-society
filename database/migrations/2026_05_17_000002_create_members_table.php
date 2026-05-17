<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();

            $table->foreignId('document_file_id')->constrained('document_files')->cascadeOnDelete();
            $table->boolean('is_owner')->default(false);
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('membership_number')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile_number')->nullable()->unique();

            $table->integer('list_order')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by_id')->nullable()->comment('the user who created this')->constrained('users', 'id');
            $table->foreignId('updated_by_id')->nullable()->comment('the user who updated this')->constrained('users', 'id');

            $table->timestamps();
            $table->softDeletes();

            $table->index('document_file_id');
            $table->index('is_owner');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
