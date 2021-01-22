<?php

use Carbon\Traits\Timestamp;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUpdatedatToResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('residents', function (Blueprint $table) {
            //columns
            $table->id();
            $table->string('fname', 50);
            $table->char('mname', 1)->nullable();
            $table->string('lname', 50);
            $table->string('issue', 50);
            $table->string('category', 30);
            $table->string('purpose', 100)->nullable();
            $table->date('issue_date');
            $table->string('session', 2);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            //non columns
            $table->charset = 'utf8';
            $table->collation = 'utf8_bin';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residents');
    }
}
