<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddServerToConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('server_driver')->default('sqlsrv');
            $table->string('server_url')->nullable();
            $table->string('server_host')->default('localhost');
            $table->integer('server_port')->default(1433);
            $table->string('server_database')->default('crudlaravelsql');
            $table->string('server_username')->default('sa');
            $table->string('server_password');
            $table->string('server_charset')->default('utf8');
            $table->string('server_prefix')->default('');
            $table->boolean('server_prefix_indexes')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
}
