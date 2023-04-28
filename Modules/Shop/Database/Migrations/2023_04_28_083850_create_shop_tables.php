<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->index()->nullable();
            $table->string('slug');
            $table->unique(['slug', 'parent_id']);
            $table->string('name');
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('shop_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->string('attribute_type');
            $table->string('validation_rules')->nullable();
            $table->timestamps();
        });

        Schema::create('shop_attribute_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('attribute_id')->index();
            $table->string('slug');
            $table->string('name');
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')->on('shop_attributes');
        });

        Schema::create('shop_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('sku');
            $table->string('type');
            $table->uuid('parent_id')->index()->nullable();
            $table->unique(['sku', 'parent_id']);
            $table->string('name');
            $table->string('slug');
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->string('status');
            $table->string('stock_status')->default('IN_STOCK');
            $table->boolean('manage_stock')->default(false);
            $table->datetime('publish_date')->nullable()->index();
            $table->text('excerpt')->nullable();
            $table->text('body')->nullable();
            $table->json('metas')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });


        Schema::create('shop_categories_products', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('category_id');

            $table->unique(['product_id', 'category_id']);
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('category_id')->references('id')->on('shop_categories');
        });

        Schema::create('shop_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('shop_products_tags', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('tag_id');

            $table->unique(['product_id', 'tag_id']);
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('tag_id')->references('id')->on('shop_tags');
        });

        Schema::create('shop_product_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('attribute_id');
            $table->string('string_value')->nullable();
            $table->text('text_value')->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->integer('integer_value')->nullable();
            $table->decimal('float_value')->nullable();
            $table->datetime('datetime_value')->nullable();
            $table->date('date_value')->nullable();
            $table->text('json_value')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('shop_attributes')->onDelete('cascade');
        });

        Schema::create('shop_product_inventories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('product_attribute_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('product_attribute_id')->references('id')->on('shop_product_attributes')->onDelete('cascade');
        });

        Schema::create('shop_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->boolean('is_primary')->default(false);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->integer('postcode')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('shop_carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index()->nullable();
            $table->datetime('expired_at')->index();
            $table->decimal('base_total_price', 16, 2)->default(0);
            $table->decimal('tax_amount', 16, 2)->default(0);
            $table->decimal('tax_percent', 16, 2)->default(0);
            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('discount_percent', 16, 2)->default(0);
            $table->decimal('grand_total', 16, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('shop_cart_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cart_id');
            $table->uuid('product_id');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('shop_carts');
            $table->foreign('product_id')->references('id')->on('shop_products');
		});

        Schema::create('shop_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('code')->unique();
            $table->string('status');
            $table->uuid('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->uuid('cancelled_by')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->text('cancellation_note')->nullable();
            $table->datetime('order_date');
            $table->datetime('payment_due');
            $table->decimal('base_total_price', 16, 2)->default(0);
            $table->decimal('tax_amount', 16, 2)->default(0);
            $table->decimal('tax_percent', 16, 2)->default(0);
            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('discount_percent', 16, 2)->default(0);
            $table->decimal('shipping_cost', 16, 2)->default(0);
            $table->decimal('grand_total', 16, 2)->default(0);
            $table->text('customer_note')->nullable();
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('customer_address1')->nullable();
            $table->string('customer_address2')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_province')->nullable();
            $table->integer('customer_postcode')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
            $table->index('code');
            $table->index(['code', 'order_date']);
        });

        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->uuid('product_id');
            $table->integer('qty');
            $table->decimal('base_price', 16, 2)->default(0);
            $table->decimal('base_total', 16, 2)->default(0);
            $table->decimal('tax_amount', 16, 2)->default(0);
            $table->decimal('tax_percent', 16, 2)->default(0);
            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('discount_percent', 16, 2)->default(0);
            $table->decimal('sub_total', 16, 2)->default(0);
            $table->string('sku');
            $table->string('type');
            $table->string('name');
            $table->json('attributes');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->index('sku');
		});

        Schema::create('shop_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('order_id')->index();
            $table->string('payment_type');
            $table->string('status');
            $table->uuid('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->text('note')->nullable();
            $table->uuid('rejected_by')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->text('rejection_note')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->json('payloads')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_payments');
        Schema::dropIfExists('shop_order_items');
        Schema::dropIfExists('shop_orders');
        Schema::dropIfExists('shop_cart_items');
        Schema::dropIfExists('shop_carts');
        Schema::dropIfExists('shop_addresses');
        Schema::dropIfExists('shop_categories_products');
        Schema::dropIfExists('shop_products_tags');
        Schema::dropIfExists('shop_product_inventories');
        Schema::dropIfExists('shop_product_attributes');
        Schema::dropIfExists('shop_tags');
        Schema::dropIfExists('shop_products');
        Schema::dropIfExists('shop_attribute_options');
        Schema::dropIfExists('shop_attributes');
        Schema::dropIfExists('shop_categories');
    }
};
