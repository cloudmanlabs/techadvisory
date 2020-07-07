<?php

namespace App\Http\Controllers;

use App\Exports\SecurityLogExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SecurityLogController extends Controller
{
    public function exportAll()
    {
        /** @var \App\User $user */
        $user = auth()->user();

        if(!$user->isAccentureAdmin()){
            abort(404);
        }

        $export = new SecurityLogExport();

        return Excel::download($export, 'security_logs.xlsx');
    }
}
