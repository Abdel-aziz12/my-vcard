<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstname');
            $table->enum('sexe', ['M', 'F'])->default('M');
            $table->string('adresse');
            $table->string('phone');
            $table->string('email');
            $table->string('file');
            $table->text('motivation');
            $table->enum('statut', ['en attente', 'programmé', 'terminé'])->default('en attente');
            $table->integer('category_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatures');
    }
};
