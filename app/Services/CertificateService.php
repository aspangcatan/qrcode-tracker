<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class CertificateService
{

    public function index($user_id, $filters, $page)
    {
        return DB::table('qr_tracker.certificates')
            ->where(function ($query) use ($user_id, $filters) {
                if (!session('access_rights') === 'admin') {
                    $query->where('user_id', '=', $user_id);
                }

                if ($filters['filter_patient'] != '') {
                    $query->where('patient', 'LIKE', '%' . $filters['filter_patient'] . '%');
                }
                if ($filters['filter_date_issued'] != '') {
                    $query->where('date_issued', '=', $filters['filter_date_issued']);
                }
            })
            ->skip($page)
            ->take(11)
            ->get();
    }

    public function getCertificateById($id)
    {
        return DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->first();
    }

    public function getCertificateByHash($hashed_value)
    {
        return DB::table('qr_tracker.certificates')
            ->where('hashed_value', '=', $hashed_value)
            ->first();
    }

    public function store($data)
    {
        return DB::table('qr_tracker.certificates')->insertGetId($data);
    }

    public function updateCertificate($id, $data)
    {
        DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->update([
                'certificate_no' => $data['certificate_no'],
                'health_record_no' => $data['health_record_no'],
                'date_issued' => $data['date_issued'],
                'patient' => $data['patient'],
                'age' => $data['age'],
                'sex' => $data['sex'],
                'civil_status' => $data['civil_status'],
                'address' => $data['address'],
                'date_examined' => $data['date_examined'],
                'doctor' => $data['doctor'],
                'doctor_designation' => $data['doctor_designation'],
                'doctor_license' => $data['doctor_license'],
                'requesting_person' => $data['requesting_person'],
                'purpose' => $data['purpose'],
                'or_no' => $data['or_no'],
                'amount' => $data['amount'],
                'days_barred' => $data['days_barred'],
                'updated_at' => now()
            ]);
    }

    public function appendHashedValue($id, $url, $hashed_value)
    {
        DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->update([
                'url' => $url,
                'hashed_value' => $hashed_value
            ]);
    }


    public function delete($id)
    {
        DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->delete();
    }

    public function generateReport($month, $year)
    {
        return DB::table('qr_tracker.certificates');
    }
}
