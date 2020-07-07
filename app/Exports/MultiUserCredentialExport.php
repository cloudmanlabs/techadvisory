<?php

namespace App\Exports;

use App\User;
use App\UserCredential;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;

class MultiUserCredentialExport implements FromCollection
{
    /** @var Collection $user */
    protected $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $return = $this->users->flatMap(function(User $user){
            return $user->credentials->map(function (UserCredential $credential) use ($user) {
                // email, nombre, ID cliente/vendor, ID usuario
                return [
                    'Email' => $credential->email,
                    'Name' => $credential->name,
                    'Id' => $user->id,
                    'User Id' => $credential->id
                ];
            });
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
