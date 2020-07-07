<?php

use App\User;
use App\UserCredential;
use App\VendorSolution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            ->states('accentureAdmin')
            ->create([
                'name' => 'Accenture',
                'email' => 'accenture@accenture.com',
            ]);
        $client = factory(User::class)
            ->states(['client', 'finishedSetup'])
            ->create([
                'name' => 'Client',
                'email' => 'sadf@client.com',
            ]);
        $vendor = factory(User::class)
            ->states(['vendor', 'finishedSetup'])
            ->create([
                'name' => 'Vendor',
                'email' => 'asdf@vendor.com',
            ]);

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
        $newClient = factory(User::class)
            ->states('client')
            ->create([
                'name' => 'New',
                'email' => 'asdfasdfasfd@client.com',
            ]);
        $newVendor = factory(User::class)
            ->states('vendor')
            ->create([
                'name' => 'New',
                'email' => 'asdfasdfa@vendor.com',
            ]);
        $newVendor->vendorSolutions()->save(factory(VendorSolution::class)->create([
            'vendor_id' => $vendor->id
        ]));

        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'client@client.com',
            'password' => Hash::make('password')
        ]);
        $client->credentials()->save($credential);
        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'vendor@vendor.com',
            'password' => Hash::make('password')
        ]);
        $vendor->credentials()->save($credential);
        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'new@client.com',
            'password' => Hash::make('password')
        ]);
        $newClient->credentials()->save($credential);
        $credential = new UserCredential([
            'name' => 'nameeee',
            'email' => 'new@vendor.com',
            'password' => Hash::make('password')
        ]);
        $newVendor->credentials()->save($credential);


        error_log('Users created successfully');
    }
}
