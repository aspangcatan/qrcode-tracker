<?php

namespace App\Services;


use App\Models\Homis;
use App\Models\HProvider;
use Illuminate\Support\Facades\DB;

class HomisServices
{

    public function receiver()
    {
        return DB::table('tdh_user.user_priv as p')
            ->join('tdh_user.users as u','p.user_id','=','u.id')
            ->where('p.syscode','=','qr-tracker')
            ->where('p.level','=','MEDICAL')
            ->select(DB::raw("UPPER(CONCAT(u.fname, ' ', LEFT(u.mname, 1), '. ', u.lname)) as name"))
            ->get();
    }

    public function doctors()
    {
        $results = HProvider::with('hpersonal')->get();
        $formattedResults = $results->map(function ($provider) {
            $middlenameInitial = $provider->hpersonal->middlename ? substr($provider->hpersonal->middlename, 0, 1) . '.' : '';
            $fullName = "DR. {$provider->hpersonal->firstname} {$middlenameInitial} {$provider->hpersonal->lastname}";
            $licno = preg_replace('/\D/', '', $provider->licno); // Remove non-numeric characters

            return [
                'license_no' => $licno,
                'name' => $fullName,
                'designation' => $provider->hpersonal->postitle
            ];
        });

        return $formattedResults;
    }

}
