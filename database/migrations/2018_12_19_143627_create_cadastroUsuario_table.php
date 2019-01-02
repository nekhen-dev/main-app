<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadastroUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastroUsuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_hash');
            $table->string('cpf_cnpj');
            $table->string('endereco');
            $table->string('endereco_num');
            $table->string('endereco_comp');
            $table->string('cidade');
            $table->string('uf');
            $table->string('cep');
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
        Schema::dropIfExists('cadastroUsuario');
    }
}
