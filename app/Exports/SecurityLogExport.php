<?php

namespace App\Exports;

use App\SecurityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SecurityLogExport implements FromCollection, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $logs = SecurityLog::all()
            ->map(function(SecurityLog $log){
                return [
                    'User ID' => optional($log->user)->id,
                    'User Name' => optional($log->user)->name,
                    'Credential Id' => $log->credential_id,
                    'Time' => $log->created_at->addHours(2)->format('Y-m-d H:i:s'),
                    'Text' => $log->text
                ];
            });

        $logs->prepend([
            'User ID', 'User Name', 'Credential Id', 'Time', 'Text'
        ]);

        return $logs;
    }
}
