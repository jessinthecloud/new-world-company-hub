<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInventoryRequest extends Migration
{
    public function up()
    {
        Schema::create( 'company_inventory_request', function ( Blueprint $table ) {
            $table->foreignId( 'requester_id' )->constrained('users');
            $table->foreignId( 'confirmed_by_id' )->nullable()->constrained('users');
            $table->foreignId( 'inventory_item_id' )->constrained('inventory_items')->cascadeOnDelete();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'company_inventory_request' );
    }
}