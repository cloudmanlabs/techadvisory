<?php

namespace App\Exports;

use App\UserCredential;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class MultiUserCredentialExport implements FromCollection
{
    /** @var Collection $user */
    private $user;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $ret = collect([
            [
                'Email' => 'Email',
                'Name' => 'Name',
                'Id' => 'Id',
                'User Id' => 'User Id',
            ]
        ]);
        foreach ($this->users as $key => $user) {
            # code...
            $return = $user->credentials->map(function (UserCredential $credential) use ($user) {
                // email, nombre, ID cliente/vendor, ID usuario
                return [
                    'Email' => $credential->email,
                    'Name' => $credential->name,
                    'Id' => $user->id,
                    'User Id' => $credential->id
                ];
            });

            $ret->concat($return);
        }

        return $ret;
    }
}
