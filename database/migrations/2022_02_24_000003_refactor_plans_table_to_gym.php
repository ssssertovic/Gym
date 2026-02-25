<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorPlansTableToGym extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'country') && !Schema::hasColumn('plans', 'price')) {
                $table->decimal('price', 8, 2)->default(0)->after('name');
            } elseif (!Schema::hasColumn('plans', 'price')) {
                $table->decimal('price', 8, 2)->default(0)->after('name');
            }
            if (!Schema::hasColumn('plans', 'duration_days')) {
                $table->integer('duration_days')->nullable()->default(30)->after('price');
            }
            if (!Schema::hasColumn('plans', 'description')) {
                $table->text('description')->nullable()->after('duration_days');
            }
        });

        if (Schema::hasColumn('plans', 'country')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->dropColumn('country');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'duration_days')) {
                $table->dropColumn('duration_days');
            }
            if (Schema::hasColumn('plans', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('plans', 'price')) {
                $table->dropColumn('price');
            }
            if (!Schema::hasColumn('plans', 'country')) {
                $table->string('country')->default('')->after('name');
            }
        });
    }
}
