<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();  
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("account_currency_id");
            $table->string("account_name");
            $table->string("account_number");
            $table->text("account_currency");
            $table->float("account_balance")->default('0');
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("account_currency_id")->references("id")->on('account_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
