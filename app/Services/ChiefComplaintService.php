<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class ChiefComplaintService
{

    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.chief_complaints')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.chief_complaints')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.chief_complaints')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
