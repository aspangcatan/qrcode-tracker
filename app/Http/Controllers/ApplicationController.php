<?php

namespace App\Http\Controllers;

use App\Models\NurseStation;
use App\Models\User;
use App\Models\UserPrivelege;
use App\Services\CertificateService;
use App\Services\DiagnosisService;
use App\Services\QrHembService;
use App\Services\QrService;
use App\Services\SustainedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ApplicationController extends Controller
{
    protected $qrService, $certificateService, $diagnosisService, $sustainedService;

    public function __construct(QrService $qrService, CertificateService $certificateService,
                                DiagnosisService $diagnosisService, SustainedService $sustainedService)
    {
        $this->qrService = $qrService;
        $this->certificateService = $certificateService;
        $this->diagnosisService = $diagnosisService;
        $this->sustainedService = $sustainedService;
    }

    public function index(Request $request)
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = ['username' => $request->username, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            $user_priv = UserPrivelege::where([['user_id', Auth::id()], ['syscode', 'qr-tracker']])->get()->first();
            if ($user_priv == null) {
                Auth::logout();
                return back()->with(['message' => 'Access denied']);
            }

            session(['access_rights' => $user_priv->level]);
            return redirect()->intended('/home');
        }
        return back()->with(['message' => 'The provided credentials do not match our records.']);
    }

    public function changePassword(Request $request)
    {
        try {
            $user = User::find(Auth::id());
            if (!Hash::check($request->old_password, $user->password)) {
                return ['code' => 500, 'message' => 'Incorrect old password'];
            }

            $user->password = bcrypt($request->new_password);
            $user->save();
            return ['code' => 200, 'message' => 'Password successfully changed'];
        } catch (\Exception $exception) {
            return ['code' => 500, 'message' => $exception->getMessage()];
        }
    }

    public function generateQrCode(Request $request)
    {
        try {
            #GET HASHED_VALUE BY ID
            $qr = $this->qrService->getQrById($request->id);
            return view('qrcode', ['qrcode' => $qr]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    public function displayQrcodeDetails(Request $request)
    {
        try {
            $qr = $this->qrService->getQrByHash($request->_q);
            return view('details', ['data' => $qr]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function getQrList(Request $request)
    {
        try {
            $filters = $request->only(['filter_patient', 'filter_date_issued']);
            $response = $this->qrService->index(Auth::id(), $filters, $request->page * 10);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


    //START OF MODULES
    public function getCertificates(Request $request)
    {
        try {
            $filters = $request->only(['filter_patient', 'filter_date_issued']);
            $response = $this->certificateService->index(Auth::id(), $filters, $request->page * 10);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function storeCertificate(Request $request)
    {
        try {
            $params = [
                'user_id' => 1116,
                'certificate_no' => $request->certificate_no,
                'health_record_no' => $request->health_record_no,
                'date_issued' => $request->date_issued,
                'patient' => $request->patient,
                'age' => $request->age,
                'sex' => $request->sex,
                'civil_status' => $request->civil_status,
                'address' => $request->address,
                'date_examined' => $request->date_examined,
                'doctor' => $request->doctor,
                'doctor_designation' => $request->doctor_designation,
                'doctor_license' => $request->doctor_license,
                'requesting_person' => $request->requesting_person,
                'purpose' => $request->purpose,
                'or_no' => $request->or_no,
                'amount' => $request->amount,
                'type' => $request->type,
                'created_at' => now()
            ];

            $certificate_id = $this->certificateService->store($params);
            $data = now() . $certificate_id;
            $hashedValue = hash('sha256', $data);
            $shortenedHash = substr($hashedValue, 0, 8); // Shorten if needed
            $url = env('APP_URL') . '/qrcode-details?_q=' . $shortenedHash;

            $this->certificateService->appendHashedValue($certificate_id, $url, $shortenedHash);

            //INSERT DIAGNOSIS
            if ($request->diagnosis) {
                $diagnosis = $request->diagnosis;
                $diagnosis_params = [];
                for ($i = 0; $i < count($diagnosis); $i++) {
                    $diagnosis_params[] = [
                        'certificate_id' => $certificate_id,
                        'diagnosis' => $diagnosis[$i]['diagnosis']
                    ];
                }

                $this->diagnosisService->delete($certificate_id);
                $this->diagnosisService->store($diagnosis_params);
            }

            if ($request->sustained) {
                $this->sustainedService->delete($certificate_id);
                $sustained = $request->sustained;
                $sustained['certificate_id'] = $certificate_id;
                $this->sustainedService->store($sustained);
            }

            return response()->json(['message' => 'New record added']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function deleteCertificate(Request $request)
    {
        try {
            $certificate = $this->certificateService->getCertificateById($request->id);

            if (!$certificate) {
                return response()->json(['message' => 'QR not found'], 404);
            }

            if ($certificate->user_id !== Auth::id()) {
                return response()->json(['message' => 'Permission denied'], 404);
            }

            $this->certificateService->delete($request->id);
            return response()->json(['message' => 'Record removed']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }
}
