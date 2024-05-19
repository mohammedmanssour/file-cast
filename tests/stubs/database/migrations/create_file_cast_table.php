<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('file_cast_table', function (Blueprint $table) {
            $table->id();
            $table->string('path')->nullable();
        });
    }
};
