<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worker_proofs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Gunakan UUID sebagai primary key
            $table->uuid('user_id'); // Ubah ke UUID
            $table->uuid('order_id'); // Tambahkan order_id sebagai UUID
            $table->string('image_path');
            $table->timestamps();

            // Foreign key relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_proofs');
    }
};
