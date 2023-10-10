<?php

namespace App\Http\Controllers;

use App\Models\NurseStation;
use App\Models\User;
use App\Models\UserPrivelege;
use App\Services\QrHembService;
use App\Services\QrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ApplicationController extends Controller
{
    protected $qrService, $qrHembService;

    public function __construct(QrService $qrService, QrHembService $qrHembService)
    {
        $this->qrService = $qrService;
        $this->qrHembService = $qrHembService;
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

    public function storeQr(Request $request)
    {
        try {
            //GET REQUEST PARAMS
            $params = [
                'user_id' => Auth::id(),
                'patient_name' => $request->patient_name,
                'hospital_no' => $request->hospital_no,
                'certificate_no' => $request->certificate_no,
                'date_issued' => $request->date_issued,
                'created_at' => now()
            ];

            //CHECK IF QR EXISTS
            $qr = $this->qrService->getQrById($request->id);
            if ($qr) {
                //MODIFY RECORD IF ID EXISTS
                $this->qrService->updateQr($qr->id, $params);
            } else {
                //GET QR ID TO BE USED ON GENERATING HASH VALUE
                $qr_id = $this->qrService->store($params);

                $data = now() . $qr_id;
                $hashedValue = hash('sha256', $data);
                $shortenedHash = substr($hashedValue, 0, 8); // Shorten if needed
                $url = env('APP_URL') . '/qrcode-details?_q=' . $shortenedHash;

                $this->qrService->appendHashedValue($qr_id, $url, $shortenedHash);
            }

            return response()->json(['message' => 'QR successfully saved']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function deleteQr(Request $request)
    {
        try {
            //CHECK FIRST IF ID EXISTS AND IT BELONGS TO THE CREATOR
            $qrcode = $this->qrService->getQrById($request->id);

            if (!$qrcode) {
                return response()->json(['message' => 'QR not found'], 404);
            }

            if ($qrcode->user_id !== Auth::id()) {
                return response()->json(['message' => 'Permission denied'], 404);
            }

            $this->qrService->delete($request->id);
            return response()->json(['message' => 'QR successfully removed']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    ///////////////////////////
    ///

    public function generateQrHembCode(Request $request)
    {
        try {
            #GET HASHED_VALUE BY ID
            $qr = $this->qrHembService->getQrById($request->id);
            return view('qrcode_hemb', ['qrcode' => $qr]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    public function displayQrHembcodeDetails(Request $request)
    {
        try {
            $qr = $this->qrHembService->getQrByHash($request->_q);
            return view('details_hemb', ['data' => $qr]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function getQrHembList(Request $request)
    {
        try {
            $filters = $request->only(['filter_patient', 'filter_date_issued']);
            $response = $this->qrHembService->index(Auth::id(), $filters, $request->page * 10);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function storeQrHemb(Request $request)
    {
        try {
            //GET REQUEST PARAMS
            $params = [
                'user_id' => Auth::id(),
                'patient_name' => $request->patient_name,
                'date_training' => $request->date_training,
                'date_expiry' => $request->date_expiry,
                'institution' => $request->institution,
                'created_at' => now()
            ];

            //CHECK IF QR EXISTS
            $qr = $this->qrHembService->getQrById($request->id);
            if ($qr) {
                //MODIFY RECORD IF ID EXISTS
                $this->qrHembService->updateQr($qr->id, $params);
            } else {
                //GET QR ID TO BE USED ON GENERATING HASH VALUE
                $qr_id = $this->qrHembService->store($params);

                $data = now() . $qr_id;
                $hashedValue = hash('sha256', $data);
                $shortenedHash = substr($hashedValue, 0, 8); // Shorten if needed
                $url = env('APP_URL') . '/qrcode-hemb-details?_q=' . $shortenedHash;

                $this->qrHembService->appendHashedValue($qr_id, $url, $shortenedHash);
            }

            return response()->json(['message' => 'QR successfully saved']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function deleteQrHemb(Request $request)
    {
        try {
            //CHECK FIRST IF ID EXISTS AND IT BELONGS TO THE CREATOR
            $qrcode = $this->qrHembService->getQrById($request->id);

            if (!$qrcode) {
                return response()->json(['message' => 'QR not found'], 404);
            }

            if ($qrcode->user_id !== Auth::id()) {
                return response()->json(['message' => 'Permission denied'], 404);
            }

            $this->qrHembService->delete($request->id);
            return response()->json(['message' => 'QR successfully removed']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }


}
