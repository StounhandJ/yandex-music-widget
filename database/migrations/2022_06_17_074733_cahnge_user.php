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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(["id", "name", "email", "email_verified_at", "password"]);
            $table->dropRememberToken();
            $table->string("token");
            $table->string("login");
        });

        Schema::drop("password_resets");
        Schema::drop("personal_access_tokens");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
