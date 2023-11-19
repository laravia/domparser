<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domparsers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url');
            $table->string('element')->nullable();
            $table->string('cronjob')->nullable();
            $table->string('email')->nullable();
            $table->boolean('unique')->nullable()->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domparsers');
    }
};
