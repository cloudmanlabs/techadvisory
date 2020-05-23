<?php

use App\User;
use App\UserCredential;
use App\VendorSolution;
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
            ->states('admin')
            ->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ]);

        // Create the default to be able to login and stuff
        factory(User::class)
            ->states('accenture')
            ->create([
                'name' => 'Accenture',
                'email' => 'accenture@accenture.com',
            ]);
        factory(User::class)
            ->states(['client', 'finishedSetup'])
            ->create([
                'name' => 'Client',
                'email' => 'client@client.com',
            ]);
        $vendor = factory(User::class)
            ->states(['vendor', 'finishedSetup'])
            ->create([
                'name' => 'Vendor',
                'email' => 'vendor@vendor.com',
            ]);

        // $credential = new UserCredential([
        //     'name' => 'nameeee',
        //     'email' => 'test@test.com',
        // ]);
        // $vendor->credentials()->save($credential);

        // Create some other randoms
        factory(User::class, 3)
            ->states(['client', 'finishedSetup'])
            ->create();
        factory(User::class, 4)
            ->states(['vendor', 'finishedSetup'])
            ->create()
            ->each(function($vendor){
                $vendor->vendorSolutions()->save(factory(VendorSolution::class)->create([
                    'vendor_id' => $vendor->id
                ]));
            });


        // Create some that haven't finished set up
        factory(User::class)
            ->states('client')
            ->create([
                'name' => 'New',
                'email' => 'new@client.com',
            ]);
        factory(User::class)
            ->states('vendor')
            ->create([
                'name' => 'New',
                'email' => 'new@vendor.com',
            ])
            ->each(function ($vendor) {
                $vendor->vendorSolutions()->save(factory(VendorSolution::class)->create([
                    'vendor_id' => $vendor->id
                ]));
            });



        error_log('Users created successfully');
    }
}
