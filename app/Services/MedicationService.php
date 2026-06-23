<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class MedicationService
{

    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.medications')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.medications')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.medications')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
