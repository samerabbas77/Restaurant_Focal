<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            'المستخدمين',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',


            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',

            'عرض صلاحية',
            'اضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',

            'التقييمات',
            'إدارة التقييمات',

            'الطلبات',
            'ادارةالطلبات',
            'اضافة زبون',
            'اضافة طلب',
            'تعديل طلب',
            'حذف طلب',
            'استعادة طلب',

            'الطاولات',
            'ادارة الطاولات',
            'تعديل طاولة',
            'استعادة طاولة',
            'الحجوزات',
            'ادارة الحجوزات',
            'اضافة حجز',
            'تعديل حجز',
            'حذف حجز',
            'استعادة حجز',

            'اضافة طاولة',
            'حذف طاولة',


            'الاطباق',
            'ادارة الاطباق',
            'اضافة طبق',
            'تعديل طبق',
            'حذف طبق',
            'استعادة طبق',

            'التصنيفات',
            'إدارةالتصنيفات',
            'اضافة تصنيف',
            'تعديل تصنيف',
            'حذف تصنيف',
            'استعادة تصنيف',
            'استعادة تقييم',
            'حذف تقييم',
            'تفاصيل الطلب',


        ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}
