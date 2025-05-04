<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\V1\Wallets\Enums\TransactionType;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transactions', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('wallet_id')
                  ->constrained('wallets')
                  ->onDelete('cascade');

            $table->double('amount');
            $table->enum('type', TransactionType::list());
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
