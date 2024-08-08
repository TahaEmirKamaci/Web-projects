<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('appointment');
            $table->string('purpose');
            $table->string('who');
            $table->timestamp('Date');
            $table->timestamp('Date_exit')->nullable();
            $table->timestamps();
            $table->after('Date_exit', function ($table) {
                $table->string('image')->nullable();
            });

        });
    }

    public function down()
    {
        Schema::dropIfExists('records ', function (Blueprint $table) {
           $table->dropColumn('image');
        });
    }
}
