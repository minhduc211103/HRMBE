<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // BƯỚC 1: Xử lý dữ liệu cũ để tránh lỗi conflict
        // Chuyển tất cả status lạ về 'new' trước khi ép kiểu ENUM
        DB::table('projects')
            ->whereNotIn('status', ['new', 'pending', 'active', 'done', 'cancelled'])
            ->update(['status' => 'new']);

        // BƯỚC 2: Chạy lệnh Alter Table
        DB::statement("
            ALTER TABLE projects
            MODIFY status ENUM(
                'new',
                'pending',
                'active',
                'done',
                'cancelled'
            ) DEFAULT 'new'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Khi rollback thì trả về String bình thường để không bị mất dữ liệu
        DB::statement("
            ALTER TABLE projects
            MODIFY status VARCHAR(255) DEFAULT 'pending'
        ");
    }
};
