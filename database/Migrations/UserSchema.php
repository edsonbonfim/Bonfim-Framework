<?php

namespace Database\Migrations;

use Bonfim\ActiveRecord\Schema;
use Bonfim\ActiveRecord\Table;

class UserSchema extends Schema
{
    public function up()
    {
        $this->create('users', function(Table $table) {
            $table->increments();
            $table->timestamps();
        });
    }

    public function down()
    {

    }
}
