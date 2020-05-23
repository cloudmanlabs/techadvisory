<?php

namespace App\Exports;

use App\User;
use App\UserCredential;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserCredentialExport implements FromCollection
{
    /** @var User $user */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $return = $this->user->credentials->map(function(UserCredential $credential){
            // email, nombre, ID cliente/vendor, ID usuario
            return [
                'Email' => $credential->email,
                'Name' => $credential->name,
                'Id' => $this->user->id,
                'User Id' => $credential->id
            ];
        });

        $return->prepend([
            'Email' => 'Email',
            'Name' => 'Name',
            'Id' => 'Id',
            'User Id' => 'User Id',
        ]);

        return $return;
    }
}
