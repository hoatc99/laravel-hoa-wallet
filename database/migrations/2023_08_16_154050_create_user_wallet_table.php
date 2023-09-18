<?php

use App\Models\User;
use App\Models\Wallet;
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
        Schema::create('user_wallet', function (Blueprint $table) {
            $table->foreignIdFor(Wallet::class);
            $table->foreignIdFor(User::class);
            $table->integer('wallet_order');
            $table->boolean('is_common');
            $table->boolean('is_hidden');
            $table->primary(['wallet_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet');
    }
};
