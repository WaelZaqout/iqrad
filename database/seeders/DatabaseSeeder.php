<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // تشغيل سييدر الأدوار والصلاحيات
        $this->call([
            RoleAdminSeeder::class,
        ]);

        // إنشاء يوزر أدمن
        $adminUser = User::create([
            'name' => 'wael zaqout',
            'email' => 'wael@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // ربط الأدمن برول "admin"
        $adminUser->assignRole('admin');
    }
}
