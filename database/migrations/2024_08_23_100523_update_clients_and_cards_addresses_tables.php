<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientsAndCardsAddressesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['address_id', 'card_id']);
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->index();
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('address_id')->nullable()->index();
            $table->foreignId('card_id')->nullable()->index();
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
}

