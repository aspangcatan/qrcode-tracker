<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class PlanService
{

    public function getByCertificate($certificate_id)
    {
        return DB::table('qr_tracker.plans')
            ->where('certificate_id', '=', $certificate_id)
            ->get();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.plans')->insert($data);
    }

    public function delete($certificate_id)
    {
        DB::table('qr_tracker.plans')
            ->where('certificate_id', '=', $certificate_id)
            ->delete();
    }
}
