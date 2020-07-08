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
                    'Time' => $log->created_at,
                    'Text' => $log->text
                ];
            });

        $logs->prepend([
            'User ID', 'User Name', 'Time', 'Text'
        ]);

        return $logs;
    }
}
