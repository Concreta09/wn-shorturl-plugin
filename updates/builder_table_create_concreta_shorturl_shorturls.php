<?php namespace Concreta\ShortURL\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateConcretaShorturlShorturls extends Migration
{
    public function up()
    {
        Schema::create('concreta_shorturl_shorturls', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->text('destination_url');
            $table->string('url_key')->unique();
            $table->string('default_short_url');
            $table->boolean('single_use');
            $table->boolean('forward_query_params')->default(false);
            $table->boolean('track_visits');
            $table->integer('redirect_status_code')->default(301);
            $table->boolean('track_ip_address')->default(false);
            $table->boolean('track_operating_system')->default(false);
            $table->boolean('track_operating_system_version')->default(false);
            $table->boolean('track_browser')->default(false);
            $table->boolean('track_browser_version')->default(false);
            $table->boolean('track_referer_url')->default(false);
            $table->boolean('track_device_type')->default(false);
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('deactivated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('concreta_shorturl_shorturls');
    }
}
