<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class SustainedService
{
    public function getSustainedByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.sustained_details')
            ->where('certificate_id', '=', $certificate_id)
            ->first();
    }

    public function  store($data)
    {
        return DB::table('qr_tracker.sustained_details')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.sustained_details')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
