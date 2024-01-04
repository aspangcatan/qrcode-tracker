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
            ->orderBy('id','DESC')
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
                'health_record_no' => $data['health_record_no'],
                'patient' => $data['patient'],
                'age' => $data['age'],
                'sex' => $data['sex'],
                'civil_status' => $data['civil_status'],
                'address' => $data['address'],
                'date_examined' => $data['date_examined'],
                'date_discharged' => $data['date_discharged'],
                'doctor' => $data['doctor'],
                'doctor_designation' => $data['doctor_designation'],
                'doctor_license' => $data['doctor_license'],
                'requesting_person' => $data['requesting_person'],
                'relationship' => $data['relationship'],
                'purpose' => $data['purpose'],
                'second_purpose' => $data['second_purpose'],
                'or_no' => $data['or_no'],
                'amount' => $data['amount'],
                'charge_slip_no' => $data['charge_slip_no'],
                'date_requested' => $data['date_requested'],
                'date_completed' => null,
                'days_barred' => $data['days_barred'],
                'prepared_by' => $data['prepared_by'],
                'received_by' => $data['received_by'],
                'updated_at' => now()
            ]);
    }

    public function updateDateCompleted($id, $date_completed)
    {
        DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->update([
                'date_completed' => $date_completed,
                'updated_at' => now(),
                'status' => 'FOR RELEASE'
            ]);
    }

    public function updateDateIssued($id, $date_issued, $released_by)
    {
        DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->update([
                'date_issued' => $date_issued,
                'released_by' => $released_by,
                'updated_at' => now(),
                'status' => 'RELEASED'
            ]);
    }

    public function updateStatus($id, $status,$released_by)
    {
        DB::table('qr_tracker.certificates')
            ->where('id', '=', $id)
            ->update([
                'status' => $status,
                'released_by' => $released_by,
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

    public function generateReport($from_date, $to_date)
    {
        return DB::table('qr_tracker.certificates')
            ->select([
                'patient',
                DB::raw('CASE
            WHEN type = "ordinary" THEN "ORDINARY MEDCERT - ER/OPD"
            WHEN type = "maipp" THEN "PREDESIGNED - ER/OPD"
            WHEN type = "medico_legal" THEN "MEDICO LEGAL"
            WHEN type = "ordinary_inpatient" THEN "ORDINARY MEDCERT - INPATIENT"
            WHEN type = "maipp_inpatient" THEN "PREDESIGNED - INPATIENT"
            WHEN type = "coc" THEN "CERTIFICATE OF CONFINEMENT"
            ELSE type
        END AS type'), // Display type with custom values
                'charge_slip_no',
                'or_no',
                'received_by',
                'prepared_by',
                'requesting_person',
                DB::raw('COALESCE(relationship, "") AS relationship'),
                DB::raw('DATE_FORMAT(date_requested, "%m/%d/%Y %h:%i %p") AS date_requested'),
                DB::raw('DATE_FORMAT(date_completed, "%m/%d/%Y %h:%i %p") AS date_completed'),
                'certificate_no',
                DB::raw('DATE_FORMAT(date_issued, "%m/%d/%Y %h:%i %p") AS date_issued'),
                'released_by',
                'status'
            ])
            ->where(function ($query) use ($from_date, $to_date) {
                $query->whereDate('created_at', '>=', $from_date);
                $query->whereDate('created_at', '<=', $to_date);
            })
            ->get();
    }

    public function getLatestId()
    {
        return DB::table('qr_tracker.certificates')
            ->orderBy('id', 'desc') // Orders by ID in descending order to get the latest one
            ->first();
    }
}
