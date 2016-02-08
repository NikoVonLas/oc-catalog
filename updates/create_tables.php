<?php namespace Tiipiik\Catalog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{

    public function up()
    {
        Schema::create('tiipiik_catalog_categories', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->integer('nest_left');
            $table->integer('nest_right');
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });
        
        Schema::create('tiipiik_catalog_products', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->integer('items_available')->nullable();
            $table->decimal('price', 8, 2)->default('0.00');
            $table->decimal('discount_price', 8, 2)->default('0.00');
            $table->timestamps();
        });
        
        Schema::create('tiipiik_catalog_custom_fields', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('template_code')->nullable();
            $table->string('display_name')->nullable();
            $table->text('default_value')->nullable();
            $table->timestamps();
        });
        
        Schema::create('tiipiik_catalog_custom_values', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('custom_field_id')->unsigned()->nullable()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        
        // Relation between categories and products
        Schema::create('tiipiik_catalog_prods_cats', function ($table) {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['product_id', 'category_id']);
        });
        
        // Relation between custom fields and custom values
        Schema::create('tiipiik_catalog_csf_csv', function ($table) {
            $table->engine = 'InnoDB';
            $table->integer('custom_value_id')->unsigned();
            $table->integer('custom_field_id')->unsigned();
            $table->primary(['custom_value_id', 'custom_field_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiipiik_catalog_categories');
        Schema::dropIfExists('tiipiik_catalog_products');
        Schema::dropIfExists('tiipiik_catalog_custom_fields');
        Schema::dropIfExists('tiipiik_catalog_custom_values');
        Schema::dropIfexists('tiipiik_catalog_prods_cats');
        Schema::dropIfExists('tiipiik_catalog_csf_csv');
    }
}
