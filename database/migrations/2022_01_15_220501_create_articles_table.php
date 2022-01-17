<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("name", 120);
            $table->string("categories", 50)->nullable();
            $table->string("identifiant", 50)->nullable();
            $table->integer("price");
            $table->enum("expense", ["oui", "non"]);
            $table->text("observation");
            $table->timestamp("created_at")->useCurrent();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
