<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAttributesTableAddAuditableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(config('rinvex.attributes.tables.attributes'), function (Blueprint $table): void {
            $table->auditable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(config('rinvex.attributes.tables.attributes'), function (Blueprint $table): void {
            $table->dropAuditable();
        });
    }
}
