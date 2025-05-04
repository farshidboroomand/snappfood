<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('sheba_number', 24)->nullable();
            $table->string('national_id', 10)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
