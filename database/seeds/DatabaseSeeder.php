<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [["name" => "create & edit", "slug" => "create & edit"], ["name" => "readonly", "slug" => "readonly"]];
        foreach($permissions as $permission){
            DB::table('permissions')->insert([
                'name' => $permission['name'],
                'slug' => $permission['slug'],
            ]);
        }
        // DB::table('users')->insert([
        //     'first_name' => "admin",
        //     'last_name' => "admin",
        // ]);
        // factory(App\Permission::class, 2)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
