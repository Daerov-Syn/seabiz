<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('price')->default(0);
                $table->integer('stock')->default(0);
                $table->string('unit')->default('kg');
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('pengguna')->after('gender');
                }
                if (! Schema::hasColumn('users', 'seller_name')) {
                    $table->string('seller_name')->nullable()->after('role');
                }
                if (! Schema::hasColumn('users', 'seller_description')) {
                    $table->text('seller_description')->nullable()->after('seller_name');
                }
                if (! Schema::hasColumn('users', 'seller_phone')) {
                    $table->string('seller_phone')->nullable()->after('seller_description');
                }
                if (! Schema::hasColumn('users', 'seller_address')) {
                    $table->text('seller_address')->nullable()->after('seller_phone');
                }
                if (! Schema::hasColumn('users', 'seller_banner')) {
                    $table->string('seller_banner')->nullable()->after('seller_address');
                }
                if (! Schema::hasColumn('users', 'seller_revenue')) {
                    $table->integer('seller_revenue')->default(0)->after('seller_banner');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products')) {
            Schema::dropIfExists('products');
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
                if (Schema::hasColumn('users', 'seller_name')) {
                    $table->dropColumn('seller_name');
                }
                if (Schema::hasColumn('users', 'seller_description')) {
                    $table->dropColumn('seller_description');
                }
                if (Schema::hasColumn('users', 'seller_phone')) {
                    $table->dropColumn('seller_phone');
                }
                if (Schema::hasColumn('users', 'seller_address')) {
                    $table->dropColumn('seller_address');
                }
                if (Schema::hasColumn('users', 'seller_banner')) {
                    $table->dropColumn('seller_banner');
                }
                if (Schema::hasColumn('users', 'seller_revenue')) {
                    $table->dropColumn('seller_revenue');
                }
            });
        }
    }
};
