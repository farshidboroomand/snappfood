<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\V1\Wallets\Enums\Currencies;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->double('balance')->default(0);
            $table->double('available_balance')->default(0);
            $table->double('blocked_amount')->default(0);
            $table->enum('currency', Currencies::list())->default(Currencies::RIAL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
