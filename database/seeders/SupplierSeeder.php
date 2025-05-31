<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            [
                'id' => 1,
                'company_name' => 'tech company',
                'contact_name' => 'Ahmad',
                'city' => 'Damascus',
                'country' => 'Syria',
                'phone' => '33324587',
                'fax' => '33324588',
            ],
            [
                'id' => 2,
                'company_name' => 'Durra',
                'contact_name' => 'Saeed',
                'city' => 'Damascus',
                'country' => 'Syria',
                'phone' => '0113855454',
                'fax' => null,
            ],
            [
                'id' => 3,
                'company_name' => 'كهربائيات المرصي',
                'contact_name' => 'محمود',
                'city' => 'حلب',
                'country' => 'سوريا',
                'phone' => null,
                'fax' => null,
            ],
        ]);
    }
}
