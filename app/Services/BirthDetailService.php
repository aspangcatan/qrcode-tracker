<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class BirthDetailService
{
    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.birth_details')
            ->where('certificate_id', '=', $certificate_id)
            ->first();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.birth_details')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.birth_details')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
