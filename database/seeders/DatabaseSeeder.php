<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\NgType;
use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Unit', 'DC'],
            ['Unit', 'MA'],
            ['Unit', 'Sub-Assy'],
            ['Unit', 'PPIC'],
            ['Body', 'INJ'],
            ['Body', 'PT'],
            ['Body', 'Sub-Assy'],
            ['Body', 'PPIC'],
        ] as [$category, $name]) {
            Area::firstOrCreate(
                ['category' => $category, 'name' => $name],
                ['is_active' => true]
            );
        }

        foreach ([
            ['P', 'NG Part'],
            ['H', 'NG Holder'],
            ['C', 'NG Cover'],
        ] as [$code, $name]) {
            NgType::firstOrCreate(
                ['code' => $code],
                ['name' => $name, 'is_active' => true]
            );
        }

        $ppicArea = Area::where(['category' => 'Unit', 'name' => 'PPIC'])->first();

        User::updateOrCreate(
            ['email' => 'user@omd.local'],
            [
                'name' => 'Leader PPIC',
                'password' => Hash::make('password'),
                'role' => 'user',
                'user_group' => 'ppic',
                'area_id' => $ppicArea?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'produksi@omd.local'],
            [
                'name' => 'Leader Produksi',
                'password' => Hash::make('password'),
                'role' => 'user',
                'user_group' => 'produksi',
                'area_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'member@omd.local'],
            [
                'name' => 'OMD Member',
                'password' => Hash::make('password'),
                'role' => 'omd_member',
                'user_group' => null,
                'area_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'leader@omd.local'],
            [
                'name' => 'OMD',
                'password' => Hash::make('password'),
                'role' => 'omd_leader',
                'user_group' => null,
                'area_id' => null,
            ]
        );

        $targets = [4 => 950, 5 => 855, 6 => 855, 7 => 855, 8 => 855, 9 => 855];
        foreach ($targets as $month => $quantity) {
            Target::updateOrCreate(
                ['year' => 2026, 'month' => $month, 'area_id' => null],
                ['target_qty' => $quantity]
            );
        }
    }
}
