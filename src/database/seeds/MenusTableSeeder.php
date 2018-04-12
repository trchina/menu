<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'id' => '1',
                'name' => '商品管理',
                'parent_id' => '0',
                'sort' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '2',
                'name' => '商品管理-1',
                'parent_id' => '1',
                'sort' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '3',
                'name' => '商品管理-2',
                'parent_id' => '1',
                'sort' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '4',
                'name' => '商品管理-1-1',
                'parent_id' => '2',
                'sort' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '5',
                'name' => '订单管理',
                'parent_id' => '0',
                'sort' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '6',
                'name' => '订单管理-1',
                'parent_id' => '5',
                'sort' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('menus')->insert($menus);
    }
}
