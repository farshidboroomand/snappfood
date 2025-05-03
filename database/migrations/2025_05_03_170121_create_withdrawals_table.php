<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\V1\Wallets\Enums\WithdrawalStatus;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdrawals', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignUuid('wallet_id')
                  ->constrained('wallets')
                  ->onDelete('cascade');

            $table->string('from_sheba_number', 24);
            $table->string('to_sheba_number', 24);

            $table->double('amount');
            $table->text('note')->nullable();
            $table->enum('status', WithdrawalStatus::list())->default(WithdrawalStatus::PENDING);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
