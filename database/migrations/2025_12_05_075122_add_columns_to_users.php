<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
           $table->text('address')->after('email')->nullable();
           $table->string('phone')->after('address')->nullable();
           $table->string('gender')->after('phone')->nullable();
           $table->boolean('status')->default(true)->after('gender');
           $table->string('image')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'address', 'phone', 'gender', 'status', 'image'
            ]);
        });
    }
};
