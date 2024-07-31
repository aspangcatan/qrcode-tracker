<?php

namespace App\Http\Controllers;

use App\Models\NurseStation;
use App\Models\User;
use App\Models\UserPrivelege;
use App\Services\CertificateService;
use App\Services\DiagnosisService;
use App\Services\HomisServices;
use App\Services\SustainedService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ApplicationController extends Controller
{
    protected $certificateService, $diagnosisService, $sustainedService, $homisService;

    public function __construct(CertificateService $certificateService, DiagnosisService $diagnosisService,
                                SustainedService $sustainedService, HomisServices $homisService)
    {
        $this->certificateService = $certificateService;
        $this->diagnosisService = $diagnosisService;
        $this->sustainedService = $sustainedService;
        $this->homisService = $homisService;
    }

    public function receiver()
    {
        try {
            return response()->json($this->homisService->receiver());
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function doctors()
    {
        try {
            return response()->json($this->homisService->doctors());
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
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
            $excluded_certificate = ['ordinary', 'maipp', 'medico_legal', 'ordinary_inpatient', 'maipp_inpatient', 'coc', 'medical_abstract'];
            $specific_documents = $request->document_type;
            $type = $request->type;

            for ($i = 0; $i < $request->no_copies; $i++) {
                if (!in_array($type, $excluded_certificate)) {
                    foreach ($specific_documents as $document_type) {
                        $certificate_id = $this->createCertificate($request, $document_type);
                        $this->handleDiagnosis($request->diagnosis, $certificate_id);
                        $this->handleSustained($request->sustained, $certificate_id);
                    }
                } else {
                    $certificate_id = $this->createCertificate($request, '');
                    $this->handleDiagnosis($request->diagnosis, $certificate_id);
                    $this->handleSustained($request->sustained, $certificate_id);
                }
            }

            return response()->json(['message' => 'Operation successful']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function tagCertificate(Request $request)
    {
        try {
            $mi = (Auth::user()->mname) ? Auth::user()->mname[0] . '.' : '';
            $prepared_by = strtoupper(Auth::user()->fname . ' ' . $mi . ' ' . Auth::user()->lname);
            $certificate = $this->certificateService->getCertificateById($request->id);
            if (!$certificate) {
                return response()->json(['message' => 'Certificate ID dont exists'], 404);
            }

            if ($certificate->status === "CANCELLED" || $certificate->status === "RELEASED") {
                return response()->json(['message' => 'Cannot tag ' . $certificate->status . ' records'], 500);
            }

            switch ($request->status) {
                case "FOR RELEASE":
                    if ($certificate->date_completed) {
                        return response()->json(['message' => 'Certificate already tagged as for release'], 500);
                    }
                    $this->certificateService->updateDateCompleted($certificate->id, Carbon::now()->format('Y-m-d\TH:i'));
                    break;
                case "RELEASED":
                    if ($certificate->date_issued) {
                        return response()->json(['message' => 'Certificate already tagged as released'], 500);
                    }
                    if (!$certificate->date_completed) {
                        return response()->json(['message' => 'Certificate not yet for release'], 500);
                    }
                    $this->certificateService->updateDateIssued($certificate->id, Carbon::now()->format('Y-m-d\TH:i'), $prepared_by);
                    break;
                case "CANCELLED":
                    if ($certificate->status == "CANCELLED") {
                        return response()->json(['message' => 'Certificate already tagged as CANCELLED'], 500);
                    }

                    if ($certificate->date_issued) {
                        return response()->json(['message' => 'Certificate already tagged as RELEASED'], 500);
                    }

                    $this->certificateService->updateStatus($certificate->id, 'CANCELLED', $prepared_by);
                    break;
            }
            return response()->json(['message' => 'Tagged successfully by ' . $prepared_by]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function tagAsComplete(Request $request)
    {
        try {
            $mi = (Auth::user()->mname) ? Auth::user()->mname[0] . '.' : '';
            $prepared_by = strtoupper(Auth::user()->fname . ' ' . $mi . ' ' . Auth::user()->lname);
            $certificate = $this->certificateService->getCertificateById($request->id);
            if (!$certificate) {
                return response()->json(['message' => 'Certificate ID dont exists'], 404);
            }
            if ($certificate->date_completed) {
                return response()->json(['message' => 'Certificate already tagged as DONE', 500]);
            }
            $this->certificateService->updateDateCompleted($certificate->id, Carbon::now()->format('Y-m-d\TH:i'), $prepared_by);
            return response()->json(['message' => 'Tagged successfully by ' . $prepared_by]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function cancelCertificate(Request $request)
    {
        try {
            $certificate = $this->certificateService->getCertificateById($request->id);
            if (!$certificate) {
                return response()->json(['message' => 'QR not found'], 404);
            }
            $this->certificateService->updateStatus($request->id, 'CANCELLED');
            return response()->json(['message' => 'Record removed']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    public function partialForm(Request $request)
    {
        $latest_id = $this->certificateService->getLatestId();
        $certificate_no = "000001";
        if ($latest_id) {
            $certificate_no = str_pad(($latest_id->id + 1), 6, "0", STR_PAD_LEFT);
        }
        $certificates = $this->certificateService->getCertificateById($request->id);
        $diagnosis = $this->diagnosisService->getDiagnosisByCertificate($request->id);
        $receivers = $this->homisService->receiver();
        switch ($request->type) {
            case "ordinary":
                if ($request->has('id')) {
                    return view('forms.ordinary', compact('certificates', 'diagnosis', 'receivers'));
                }
                return view('forms.ordinary', compact('certificate_no', 'receivers'));
            case "ordinary_inpatient":
                if ($request->has('id')) {
                    return view('forms.ordinary_inpatient', compact('certificates', 'diagnosis', 'receivers'));
                }
                return view('forms.ordinary_inpatient', compact('certificate_no', 'receivers'));
            case "maipp":
                if ($request->has('id')) {
                    return view('forms.maipp', compact('certificates', 'diagnosis', 'receivers'));
                }
                return view('forms.maipp', compact('certificate_no', 'receivers'));
            case "maipp_inpatient":
                if ($request->has('id')) {
                    return view('forms.maipp_inpatient', compact('certificates', 'diagnosis', 'receivers'));
                }
                return view('forms.maipp_inpatient', compact('certificate_no', 'receivers'));
            case "medico_legal":
                if ($request->has('id')) {
                    $sustained = $this->sustainedService->getSustainedByCertificate($request->id);
                    return view('forms.medico_legal', compact('certificates', 'diagnosis', 'sustained', 'receivers'));
                }
                return view('forms.medico_legal', compact('certificate_no', 'receivers'));
            case "coc":
                if ($request->has('id')) {
                    return view('forms.coc', compact('certificates', 'diagnosis', 'receivers'));
                }
                return view('forms.coc', compact('certificate_no', 'receivers'));
            case "medical_abstract":
                if ($request->has('id')) {
                    return view('forms.medical_abstract', compact('certificates', 'receivers'));
                }
                return view('forms.medical_abstract', compact('certificate_no', 'receivers'));
            case "common":
                if ($request->has('id')) {
                    return view('forms.common', compact('certificates', 'receivers'));
                }
                return view('forms.common', compact('certificate_no', 'receivers'));
            default:
                return [];
        }
    }

    public function printPreview(Request $request)
    {
        try {
            $certificate = $this->certificateService->getCertificateById($request->id);
            if (!$certificate) {
                return response()->json(['message' => 'Certificate record dont exists'], 404);
            }

            $diagnosis = $this->diagnosisService->getDiagnosisByCertificate($request->id);
            switch ($certificate->type) {
                case "coc":
                    return view('pdf.coc',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]
                    );
                case "ordinary":
                    return view('pdf.ordinary',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]);
                case "ordinary_inpatient":
                    return view('pdf.ordinary_inpatient',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]);
                case "maipp":
                    return view('pdf.maipp',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]);
                case "maipp_inpatient":
                    return view('pdf.maipp_inpatient',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]);
                case "medico_legal":
                    $sustained = $this->sustainedService->getSustainedByCertificate($request->id);
                    return view('pdf.medico_legal',
                        [
                            'certificate' => $certificate,
                            'diagnosis' => $diagnosis,
                            'sustained' => $sustained,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]);
                case "medical_abstract":
                    return view('pdf.medical_abstract',
                        [
                            'certificate' => $certificate,
                            'title' => $request->title,
                            'd_margin_top' => $request->d_margin_top,
                            'd_margin_bottom' => $request->d_margin_bottom,
                            's_margin_top' => $request->s_margin_top,
                            's_margin_bottom' => $request->s_margin_bottom,
                            'seal_margin_top' => $request->seal_margin_top
                        ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function generateTableReport(Request $request)
    {
        try {
            $response = $this->certificateService->generateReport($request->from_date, $request->to_date);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function generateReport(Request $request)
    {
        try {
            $row = 7;
            $records = $this->certificateService->generateReport($request->from_date, $request->to_date);
            $templatePath = public_path('excel/SUMMARY_TEMPLATE.xlsx'); // Replace with the actual path to your template
            $spreadsheet = IOFactory::load($templatePath);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('B1', $request->title);
            $sheet->insertNewRowBefore($row, count($records));
            for ($i = 0; $i < count($records); $i++) {
                $sheet->setCellValue('A' . $row, $records[$i]->date_requested);
                $sheet->setCellValue('B' . $row, $records[$i]->certificate_no);
                $sheet->setCellValue('C' . $row, $records[$i]->patient);
                $sheet->setCellValue('D' . $row, $records[$i]->type);
                $sheet->setCellValue('E' . $row, $records[$i]->charge_slip_no);
                $sheet->setCellValue('F' . $row, $records[$i]->or_no);
                $sheet->setCellValue('G' . $row, $records[$i]->received_by);
                $sheet->setCellValue('H' . $row, $records[$i]->prepared_by);
                $sheet->setCellValue('I' . $row, $records[$i]->requesting_person);
                $sheet->setCellValue('J' . $row, $records[$i]->relationship);
                $sheet->setCellValue('K' . $row, $records[$i]->date_completed);
                $sheet->setCellValue('L' . $row, $records[$i]->date_issued);
                $sheet->setCellValue('M' . $row, $records[$i]->released_by);
                $sheet->setCellValue('N' . $row, $records[$i]->status);

                $sheet->getStyle('A' . $row . ':N' . $row)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A' . $row . ':N' . $row)->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A' . $row . ':N' . $row)->getAlignment()->setVertical('middle');
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'Certificate_Report.xlsx'; // The desired filename for the download

            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200, [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',]
            );
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }




    /***HELPERS**/
    /**
     * Create a certificate record.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $specific_document
     * @return int $certificate_id
     */
    private function createCertificate($request, $specific_document) {

        $mi = (Auth::user()->mname) ? Auth::user()->mname[0] . '.' : '';
        $prepared_by = strtoupper(Auth::user()->fname . ' ' . $mi . ' ' . Auth::user()->lname);
        $latest_id = $this->certificateService->getLatestId();
        $registry_no = "000001";
        if ($latest_id) {
            $registry_no = str_pad(($latest_id->id + 1), 6, "0", STR_PAD_LEFT);
        }

        $params = [
            'user_id' => Auth::id(),
            'certificate_no' => $registry_no,
            'health_record_no' => $request->health_record_no,
            'patient' => $request->patient,
            'age' => $request->age,
            'sex' => $request->sex,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
            'date_examined' => $request->date_examined,
            'date_discharged' => $request->date_discharged,
            'doctor' => $request->doctor,
            'doctor_designation' => $request->doctor_designation,
            'doctor_license' => $request->doctor_license,
            'requesting_person' => $request->requesting_person,
            'relationship' => $request->relationship,
            'purpose' => $request->purpose,
            'second_purpose' => $request->second_purpose,
            'or_no' => $request->or_no,
            'amount' => $request->amount,
            'charge_slip_no' => $request->charge_slip_no,
            'registry_no' => $registry_no,
            'date_requested' => $request->date_requested,
            'days_barred' => $request->days_barred,
            'type' => $request->type,
            'ward' => $request->ward,
            'received_by' => $request->received_by,
            'prepared_by' => $prepared_by,
            'status' => 'PENDING',
            'specific_document' => $specific_document,
            'created_at' => now()
        ];

        $certificate = $this->certificateService->getCertificateById($request->id);
        if ($certificate) {
            if ($certificate->date_issued) {
                throw new \Exception('Certificate already issued');
            }

            $this->certificateService->updateCertificate($certificate->id, $params);
            $certificate_id = $certificate->id;
        } else {
            $certificate_id = $this->certificateService->store($params);
            $data = now() . $certificate_id;
            $hashedValue = hash('sha256', $data);
            $shortenedHash = substr($hashedValue, 0, 8);
            $url = 'https://dohcsmc.com/qrcode-tracker/qrcode-details?_q=' . $shortenedHash;
            $this->certificateService->appendHashedValue($certificate_id, $url, $shortenedHash);
        }

        return $certificate_id;
    }

    /**
     * Handle diagnosis data.
     *
     * @param array $diagnosis
     * @param int $certificate_id
     * @return void
     */
    private function handleDiagnosis($diagnosis, $certificate_id) {
        if ($diagnosis) {
            $diagnosis_params = [];
            foreach ($diagnosis as $item) {
                $diagnosis_params[] = [
                    'certificate_id' => $certificate_id,
                    'diagnosis' => $item['diagnosis']
                ];
            }
            $this->diagnosisService->delete($certificate_id);
            $this->diagnosisService->store($diagnosis_params);
        }
    }

    /**
     * Handle sustained data.
     *
     * @param array $sustained
     * @param int $certificate_id
     * @return void
     */
    private function handleSustained($sustained, $certificate_id) {
        if ($sustained) {
            $this->sustainedService->delete($certificate_id);
            $sustained['certificate_id'] = $certificate_id;
            $this->sustainedService->store($sustained);
        }
    }
}
