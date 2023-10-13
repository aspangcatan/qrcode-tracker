<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class DiagnosisService
{

    public function getDiagnosisByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.diagnosis')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.diagnosis')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.diagnosis')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
