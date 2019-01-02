<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadastroUcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastroUc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash');
            $table->string('user_hash');
            $table->integer("tipo_estabelecimento");
            $table->string("endereco");
            $table->string("num_endereco");
            $table->string("cep");
            $table->string("uf");
            $table->integer("municipio");
            $table->integer("concessionaria");
            $table->string("grupo");
            $table->string("classe");
            $table->string("modalidade");
            $table->string("consumo_conv");
            $table->float('consumo_conv_total', 8, 2);
            $table->string("consumo_fp");
            $table->float('consumo_fp_total', 8, 2);
            $table->string("consumo_int");
            $table->float('consumo_int_total', 8, 2);
            $table->string("consumo_p");
            $table->float('consumo_p_total', 8, 2);
            $table->float('consumo_total', 8, 2);
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
        Schema::dropIfExists('cadastroUc');
    }
}
