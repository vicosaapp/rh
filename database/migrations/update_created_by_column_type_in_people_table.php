<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            // Primeiro remove a coluna existente
            $table->dropColumn('created_by');
            
            // Recria com o tipo correto
            $table->unsignedBigInteger('created_by')->nullable()->after('created_at');
        });
    }

    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->unsignedInteger('created_by')->nullable()->after('created_at');
        });
    }
}; 