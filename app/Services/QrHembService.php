<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class QrHembService
{

    public function index($user_id, $filters, $page)
    {
        return DB::table('qr_tracker.qr_hembs')
            ->where('user_id', '=', $user_id)
            ->where(function ($query) use ($filters) {
                if ($filters['filter_patient'] != '') {
                    $query->where('patient_name', 'LIKE', '%' . $filters['filter_patient'] . '%');
                }
                if ($filters['filter_date_issued'] != '') {
                    $query->where('date_training', '=', $filters['filter_date_issued']);
                }
            })
            ->skip($page)
            ->take(11)
            ->get();
    }

    public function getQrById($id)
    {
        return DB::table('qr_tracker.qr_hembs')
            ->where('id', '=', $id)
            ->first();
    }

    public function getQrByHash($hashed_value)
    {
        return DB::table('qr_tracker.qr_hembs')
            ->where('hashed_value', '=', $hashed_value)
            ->first();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.qr_hembs')->insertGetId($data);
    }

    public function updateQr($id, $data)
    {
        DB::table('qr_tracker.qr_hembs')
            ->where('id', '=', $id)
            ->update([
                'patient_name' => $data['patient_name'],
                'date_training' => $data['date_training'],
                'date_expiry' => $data['date_expiry'],
                'institution' => $data['institution'],
                'updated_at' => now()
            ]);
    }

    public function appendHashedValue($id, $url, $hashed_value)
    {
        DB::table('qr_tracker.qr_hembs')
            ->where('id', '=', $id)
            ->update([
                'url' => $url,
                'hashed_value' => $hashed_value
            ]);
    }


    public function delete($id)
    {
        DB::table('qr_tracker.qr_hembs')
            ->where('id', '=', $id)
            ->delete();
    }

}
