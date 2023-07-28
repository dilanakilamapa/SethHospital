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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('PhoneNumber');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->unsignedBigInteger('age');
            $table->enum("gender",['male','female']);
            $table->unsignedBigInteger('OTP');
            $table->enum("OTP_verify",['true','false'])->default('false');
            $table->timestamp('otp_expiry')->nullable();
            $table->enum("sync", ['true', 'false'])->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};