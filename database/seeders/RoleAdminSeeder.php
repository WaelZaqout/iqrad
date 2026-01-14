<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAdminSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        // صلاحيات المقترض
        $borrower_permissions = [
            'add_project',
            'edit_project_before_approval',
            'view_project_status',
            'view_project_funding',
            'upload_documents',
            'contact_admin',
            'view_repayment_schedule',
            'make_repayment',
            'manage_profile',
        ];

        $investor_permissions = [
            'view_projects',             // رؤية المشاريع المتاحة
            'view_project_details',      // رؤية تفاصيل مشروع معين
            'make_investment',           // الاستثمار في مشروع
            'manage_wallet',             // إدارة المحفظة
            'view_transactions',         // عرض جميع المعاملات المالية
            'view_earnings',             // رؤية الأرباح المالية
            'view_repayments',           // رؤية الدفعات المستلمة
            'track_investments',         // تتبع استثماراته
            'contact_support',           // مراسلة الإدارة
            'manage_profile',            // إدارة الملف الشخصي
        ];

        // إنشاء الصلاحيات
        foreach ($borrower_permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
        }
        foreach ($investor_permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
        }

        // إضافة صلاحية الوصول الكامل
        Permission::firstOrCreate(['name' => 'full access', 'guard_name' => $guard]);

        // إنشاء الأدوار
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        $borrower = Role::firstOrCreate(['name' => 'borrower', 'guard_name' => $guard]);
        $investor = Role::firstOrCreate(['name' => 'investor', 'guard_name' => $guard]);
        // ربط الصلاحيات
        $admin->syncPermissions(Permission::all());
        $borrower->syncPermissions($borrower_permissions);
        $investor->syncPermissions($investor_permissions);
    }
}
