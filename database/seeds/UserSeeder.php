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
        factory(User::class)
            ->states(['admin','guimEmail'])
            ->create([
                'name' => 'guim',
            ]);
        factory(User::class)
            ->states('admin')
            ->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
            ]);

        // Create the default to be able to login and stuff
        factory(User::class)
            ->states('accenture')
            ->create([
                'name' => 'accenture',
                'email' => 'accenture@accenture.com',
            ]);
        factory(User::class)
            ->states('client')
            ->create([
                'name' => 'client',
                'email' => 'client@client.com',
            ]);
        factory(User::class)
            ->states('vendor')
            ->create([
                'name' => 'vendor',
                'email' => 'vendor@vendor.com',
            ]);

        // Create some other randoms
        factory(User::class, 4)
            ->states('client')
            ->create();
        factory(User::class, 4)
            ->states('vendor')
            ->create();

        error_log('Users created successfully');
    }
}
