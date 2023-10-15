<?php

namespace App\Http\Controllers;

use App\Models\NurseStation;
use App\Models\User;
use App\Models\UserPrivelege;
use App\Services\CertificateService;
use App\Services\DiagnosisService;
use App\Services\SustainedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class ApplicationController extends Controller
{
    protected $certificateService, $diagnosisService, $sustainedService;

    public function __construct(CertificateService $certificateService,
                                DiagnosisService $diagnosisService, SustainedService $sustainedService)
    {
        $this->certificateService = $certificateService;
        $this->diagnosisService = $diagnosisService;
        $this->sustainedService = $sustainedService;
    }

    public function index()
    {
        if (Auth::check()) return redirect()->route('home');
        return view('login');
    }

    public function home()
    {
        if (!Auth::check()) return redirect()->route('login');
        return view('home');
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

    public function changePassword
    (Request $request)
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

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function displayQrcodeDetails(Request $request)
    {
        try {
            $qr = $this->certificateService->getCertificateByHash($request->_q);
            return view('details', ['data' => $qr]);
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
                'user_id' => Auth::id(),
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
                'days_barred' => $request->days_barred,
                'type' => $request->type,
                'created_at' => now()
            ];

            //CHECK IF ID EXISTS
            $certificate = $this->certificateService->getCertificateById($request->id);
            if ($certificate) {
                //UPDATE INFORMATION
                $certificate_id = $request->id;
                $this->certificateService->updateCertificate($certificate_id, $params);
                $message = 'Record updated';
            } else {
                $certificate_id = $this->certificateService->store($params);
                $data = now() . $certificate_id;
                $hashedValue = hash('sha256', $data);
                $shortenedHash = substr($hashedValue, 0, 8); // Shorten if needed
                $url = env('APP_URL') . '/qrcode-details?_q=' . $shortenedHash;
                $this->certificateService->appendHashedValue($certificate_id, $url, $shortenedHash);
                $message = 'New record added';
            }

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

            return response()->json(['message' => $message]);
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

    public function partialForm(Request $request)
    {
        switch ($request->type) {
            case "ordinary":
                if ($request->has('id')) {
                    $certificates = $this->certificateService->getCertificateById($request->id);
                    $diagnosis = $this->diagnosisService->getDiagnosisByCertificate($request->id);
                    return view('forms.ordinary', compact('certificates', 'diagnosis'));
                }

                return view('forms.ordinary');
            case "maipp":
                if ($request->has('id')) {
                    $certificates = $this->certificateService->getCertificateById($request->id);
                    $diagnosis = $this->diagnosisService->getDiagnosisByCertificate($request->id);
                    return view('forms.maipp', compact('certificates', 'diagnosis'));
                }

                return view('forms.maipp');
            case "medico_legal":
                if ($request->has('id')) {
                    $certificates = $this->certificateService->getCertificateById($request->id);
                    $diagnosis = $this->diagnosisService->getDiagnosisByCertificate($request->id);
                    $sustained = $this->sustainedService->getSustainedByCertificate($request->id);
                    return view('forms.medico_legal', compact('certificates', 'diagnosis', 'sustained'));
                }
                return view('forms.medico_legal');
        }
    }

    public function printPreview(Request $request)
    {
        try {

            $certificate = $this->certificateService->getCertificateById($request->id);

            //CHECK CERTIFICATE TYPE
            if (!$certificate) {
                return response()->json(['message' => 'Certificate record dont exists'], 404);
            }

            $diagnosis = $this->diagnosisService->getDiagnosisByCertificate($request->id);

            switch ($certificate->type) {
                case "ordinary":
                    return view('pdf.ordinary', ['certificate' => $certificate, 'diagnosis' => $diagnosis]);
                case "maipp":
                    return view('pdf.maipp', ['certificate' => $certificate, 'diagnosis' => $diagnosis]);
                case "medico_legal":
                    $sustained = $this->sustainedService->getSustainedByCertificate($request->id);
                    return view('pdf.medico_legal', ['certificate' => $certificate, 'diagnosis' => $diagnosis, 'sustained' => $sustained]);
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }
}
