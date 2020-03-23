<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->states('admin')->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $user = factory(User::class)->states('accenture')->create([
            'name' => 'accenture',
            'email' => 'accenture@accenture.com',
        ]);
        $user = factory(User::class)->states('client')->create([
            'name' => 'client',
            'email' => 'client@client.com',
        ]);
        $user = factory(User::class)->states('vendor')->create([
            'name' => 'vendor',
            'email' => 'vendor@vendor.com',
        ]);

        error_log('Users created successfully');
    }
}
