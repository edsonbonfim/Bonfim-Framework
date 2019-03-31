<?php

namespace Database\Migrations;

use Bonfim\ActiveRecord\Schema;
use Bonfim\ActiveRecord\Table;

class TweetSchema extends Schema
{
    public function up()
    {
        $this->create('tweets', function(Table $table) {
            $table->increments();
            $table->timestamps();
        });
    }

    public function down()
    {

    }
}
