<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shortened_urls', function (Blueprint $table) {
            $table->id();                                          // auto-increment primary key
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');                           // delete URLs when user is deleted
            $table->text('original_url');                         // the long URL
            $table->string('short_code')->unique();               // e.g. "aB3kQ9"
            $table->unsignedBigInteger('clicks')->default(0);     // click counter
            $table->timestamp('expires_at')->nullable();          // optional expiry
            $table->timestamps();                                  // created_at + updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortened_urls');
    }
};
