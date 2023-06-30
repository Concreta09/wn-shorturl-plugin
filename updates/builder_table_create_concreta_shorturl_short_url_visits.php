<?php namespace Concreta\ShortURL\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateConcretaShorturlShortUrlVisits extends Migration
{
    public function up()
    {
        Schema::create('concreta_shorturl_short_url_visits', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('short_url_id');
            $table->string('ip_address')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('operating_system_version')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('referer_url')->nullable();
            $table->string('device_type')->nullable();
            $table->dateTime('visited_at');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('concreta_shorturl_short_url_visits');
    }
}
