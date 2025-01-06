<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('months', function (Blueprint $table) {
            $table->id();
             $table->enum('month_name', [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ])->comment('Create months enum in Indonesian language');
            $table->foreignId('year_id')->constrained('years')->onDelete('cascade');

            $table->bigInteger('collection')->unsigned()->default(0)->comment('en for penghimpunan');
            $table->bigInteger('distribution')->unsigned()->default(0)->comment('en for pendistribusian');

            $table->timestamps();

            $table->unique(['month_name', 'year_id']); // Membatasi bulan unik
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('months');
    }
}
