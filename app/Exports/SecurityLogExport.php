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
                    'User' => optional($log->user)->id,
                    'Time' => $log->created_at,
                    'Text' => $log->text
                ];
            });

        $logs->prepend([
            'User', 'Time', 'Text'
        ]);

        return $logs;
    }
}
