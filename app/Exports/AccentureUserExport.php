<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class AccentureUserExport implements FromCollection
{
    /** @var \Illuminate\Support\Collection $users */
    private $users;

    public function __construct(\Illuminate\Support\Collection $users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = $this->users->map(function (User $user) {
            return [
                'Tool Id' => $user->id,
                'Enterprise Id' => $user->enterpriseName,
                'Name' => $user->name,
                'Email' => $user->email,
                'Role Description' => User::allTypes[$user->userType] ?? '', // Get dynamically
            ];
        });

        $return->prepend([
            'Tool Id' => 'Tool Id',
            'Enterprise Id' => 'Enterprise Id',
            'Name' => 'Name',
            'Email' => 'Email',
            'Role Description' => 'Role Description',
        ]);

        return $return;
    }
}
