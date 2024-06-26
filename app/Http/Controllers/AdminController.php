<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Student;
use App\Models\Registration;
use App\Exports\ExportStudents;
use App\Models\PaymentRegistration;
use App\Models\PaymentHistory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use App\Models\Family;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function list_verified_students(Request $request){
        if ($request->ajax()){
            $data = Student::with('families', 'registration') // Load families and registration
    ->where('verify_status', true)
    ->whereExists(function ($query) {
        $query->select('id')
            ->from('registrations')
            ->whereColumn('registrations.student_id', 'students.id')
            ->where('registrations.status','!=', 'accept' );
        })
    ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $registrationUid = $row->registration ? $row->registration->registration_uid : null;

                        $btn = '<a href="' . route('admin.student_detail', ['registration_uid' => $registrationUid]) . '" class="btn btn-primary">View Details</a><br>
                                <form action="'.route('admin.accept_reject_application', ['registration_uid' => $registrationUid, 'status' => 'accept']) . '" method="post">
                                '. csrf_field() . '
                                <button type="submit" class="btn btn-secondary">Accept Registration</button>
                                </form>
                                <form action="'.route('admin.accept_reject_application', ['registration_uid' => $registrationUid, 'status' => 'reject']) . '" method="post">
                                ' . csrf_field(). '
                                <button type="submit" class="btn btn-danger">Reject Registration</button>
                                </form>';

      
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.verified-student');
    }

    public function login_admin(){
        return view('admin.login');
    }
    public function verifikasi_berkas(Request $request, $registration_uid, $status)
    {
        $data = Registration::where('registration_uid', $registration_uid)->with('student')->first();
        if (!$data){
            return redirect()->back()->withErrors(['error', 'data dengan nomor registrasi '+$registration_uid+' tidak ditemukan']);
        }else{
            // dd($data);
            if ($status == 'accept'){
                try{
                    $data->student->update(['verify_status' => true]);
                    $data->save();  
                    return redirect()->back()->with('success', 'berhasil verifikasi berkas');
                }catch(\Exception $e){
                    return redirect()->back()->withErrors(['error', $e->getMessage()]);
                }
    
            }else{
                // validate information why application is rejected
                $this->validate($request, [
                    'verify_information' => 'required'
                ]);
                try{
                    $data->student->update(['verify_status' => false, 'verify_information' => $request->verify_information]);
                    $data->save();

                    return redirect()->back()->with('success', 'berhasil verifikasi berkas');
                }catch(\Exception $e){
                    return redirect()->back()->withErrors(['error', $e->getMessage()]);
                }
            }
        }
    }

    public function accepting_student(){
        $data = Registration::where('status = ?', 'daftar')->where('students.verify_status = ?', true)->with('student')->get();

        return view('admin.accepting-student', ['data' => $data]);
    }
    public function accept_reject_application(Request $request, $registration_uid, $status){
        $data = Registration::where('registration_uid', $registration_uid)->with('student')->first();
        if(!$data){
            return redirect()->back()->withErrors(['error', 'data dengan nomor registrasi '+$registration_uid+' tidak ditemukan']);
        }else{
            if ($status == 'accept'){
                try{
                    $data->status = 'accept';
                    $data->save();

                    return redirect()->route('admin.create_biaya_pendidikan', ['registration_uid' => $registration_uid]);
                }catch(\Exception $e){
                    return redirect()->back()->withErrors(['error', $e->getMessage()]);
                }
    
            }else{
                // validate information why application is rejected
                $this->validate($request, [
                    'status_information' => 'required'
                ]);
                try{
                    $data->status = 'reject';
                    $data->status_information = $request->status_information;
                    $data->save();

                    return redirect()->back()->with('success', 'berhasil mengubah status');
                }catch(\Exception $e){
                    return redirect()->back()->withErrors(['error', $e->getMessage()]);
                }
            }
        }
    }

    public function input_biaya_pendidikan(Request $request, $registration_uid){
        $this->validate($request,[
            'biaya_pendidikan' => 'required|numeric'
        ]);
        try{
            $data = Registration::where("registration_uid", $registration_uid)->first();
    
            $data->amount = $request->biaya_pendidikan;
            $data->save();

            $payment_registration = new PaymentRegistration;
            $payment_registration->registration_id = $data->id;
            $payment_registration->amount = $data->amount;
            $payment_registration->remaining_amount = $data->amount;
            $payment_registration->save();

            return redirect()->back()->with('success', 'berhasil menambah biaya pendidikan');
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error', $e->getMessage()]);
        }
    }

    public function input_pembayaran(Request $request, $registration_uid){
        try{
            $this->validate($request,[
                'amount'
            ]);
            $register_siswa = Registration::where("registration_uid", $registration_uid)->with(['payment_registration', 'payment_history'])->first();
            // add data to eloquent:

            // add to payment_history
            $history = new PaymentHistory;
            $history->registration_id = $register_siswa->id;
            $history->amount = $request->amount;
            $history->save();
            // should add image_url

            // add to payment_registration
            $register_siswa->payment_registration->remaining_amount = ($register_siswa->amount - $request->amount);
            $register_siswa->payment_registration->save();

            $viewData = [
                'registration_id' => $registration_uid,
                'amount' => $history->amount,
                'date' => $history->created_at,
            ];
            $receipt_content = view('admin.payment_receipt', $viewData)->render();
            $history->receipt = $receipt_content;
            $history->save();
            
            return redirect()->back()->with('success', 'berhasil melakukan pembayaran');

        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error', $e->getMessage()]);
        }
    }

    public function create_biaya_pendidikan($registration_uid){
        $data = Registration::where('registration_uid', $registration_uid)->with(['student', 'student.families'])->first();
        return view('admin.input-biaya', ['data' => $data]);
    }

    public function export_students(){
        return Excel::download(new ExportStudents, 'student.xlsx');
    }

    public function unverified_student_data(Request $request){
        if ($request->ajax()){
            $data = Student::with('families', 'registration')
            ->where('verify_status', false)
            ->whereExists(function ($query) {
                $query->select('id')->from('registrations')
                    ->whereColumn('registrations.student_id', 'students.id');
            })->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $registrationUid = $row->registration ? $row->registration->registration_uid : null;
                        $btn = '<a href="' . route('admin.student_detail', ['registration_uid' => $registrationUid]) . '" class="btn btn-primary">View Details</a><br>
                            <form action="' . route('admin.accept_reject_application', ['registration_uid' => $registrationUid, 'status' => 'accept']) . '" method="post">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-secondary">Accept Registration</button>
                            </form>
                            <form action="' . route('admin.accept_reject_application', ['registration_uid' => $registrationUid, 'status' => 'reject']) . '" method="post">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-danger">Reject Registration</button>
                            </form>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.unverified-student');
    }

    public function detail_student($registration_uid){
        // $data = Registration::where('registration_uid', $registration_uid)->with('student')->first();
        $registration = Registration::where('registration_uid', $registration_uid)->first();
        $student = $registration->student;
        if ($student){
            $families = $student->families;
        }

        // dd($);

        return view('admin.detail-student', ['data' => $registration, 'student' => $student, 'families' => $families]);
    }

    public function index(){
        return view('admin.content');
    }

    public function pembayaran($registration_uid){
        $data = Registration::where('registration_uid', $registration_uid)->with(['student', 'student.families'])->first();
        return view('admin.input-pembayaran', ['data' => $data]);
    }

    public function create_student(Request $request){
        DB::beginTransaction();
        try{
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => ['required', 'min:8']
            ]);
            try{
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => 'siswa',
                    'password' => Hash::make($request->password),
                ]);
            }catch(\Exception $ex){
                throw $ex;
            }

            $this->validate($request, [
                'nisn' => 'required|numeric',
                'nik' => 'required|numeric|digits:16',
                'date_of_birth' => 'required',
                'gender' => 'required',
                'religion' => 'required',
                'address' => 'required',
                'last_education' => 'required',
                'phone_number' => 'required',
            ]);
            $date_of_birth_student = Carbon::parse($request->date_of_birth);
            try{
                $student = Student::create([
                    'name' => $request->name,
                    'nisn' => $request->nisn,
                    'nik' => $request->nik,
                    'date_of_birth' => $date_of_birth_student->format('Y-m-d'),
                    'gender' => $request->gender,
                    'religion' => $request->religion,
                    'address' => $request->address,
                    'last_education' => $request->last_education,
                    'phone_number' => $request->phone_number,
                    'user_id' => $user->id,
                    'verify_status' => false
                ]);
            }catch(\Exception $ex){
                throw $ex;
            }
            // dd($request->name_ibu);
            if ($request->name_ibu){
                $date_of_birth_ibu = Carbon::parse($request->date_of_birth_ibu)->format('Y-m-d');
                try{
                    $mother = Family::create([
                        'name' => $request->name_ibu,
                        'nik' => $request->nik_ibu,
                        'date_of_birth' => $date_of_birth_ibu,
                        'gender' => 'perempuan',
                        'religion' => $request->religion_ibu,
                        'address' => $request->address_ibu,
                        'last_education' => $request->last_education_ibu,
                        'phone_number' => $request->phone_number_ibu,
                        'working_as' => $request->working_as_ibu,
                        'income' => $request->income_ibu,
                        'parent_status' => 'ibu',
                        'student_id' => $student->id
                    ]);
                }catch(\Exception $ex){
                    throw $ex;
                }
            }
            if ($request->name_ayah){
                $date_of_birth_ayah = Carbon::parse($request->date_of_birth_ayah)->format('Y-m-d');
                try{
                    $father = Family::create([
                        'name' => $request->name_ayah,
                        'nik' => $request->nik_ayah,
                        'date_of_birth' => $date_of_birth_ayah,
                        'gender' => 'laki-laki',
                        'religion' => $request->religion_ayah,
                        'address' => $request->address_ayah,
                        'last_education' => $request->last_education_ayah,
                        'phone_number' => $request->phone_number_ayah,
                        'working_as' => $request->working_as_ayah,
                        'income' => $request->income_ayah,
                        'parent_status' => 'ayah',
                        'student_id' => $student->id
                    ]);
                }catch(\Exception $ex){
                    throw $ex;
                }
            }
            if ($request->name_wali){
                $date_of_birth_wali = Carbon::parse($request->date_of_birth_wali)->format('Y-m-d');
                try{
                    $wali = Family::create([
                        'name' => $request->name_wali,
                        'nik' => $request->nik_wali,
                        'date_of_birth' => $date_of_birth_wali,
                        'gender' => $request->gender_wali,
                        'religion' => $request->religion_wali,
                        'address' => $request->address_wali,
                        'last_education' => $request->last_education_wali,
                        'phone_number' => $request->phone_number_wali,
                        'working_as' => $request->working_as_wali,
                        'income' => $request->income_wali,
                        'parent_status' => 'wali',
                        'student_id' => $student->id
                    ]);
                    dd($wali);
                }catch(\Exception $ex){
                    throw $ex;
                }
            }
            

            $uniqueId = Str::random(10);
            try{
                $registration = Registration::create([
                    'registration_uid' => $uniqueId,
                    'student_id' => $student->id,
                    'status' => 'daftar'
                ]);
            }catch(\Exception $ex){
                throw $ex;
            }
            DB::commit();
            return redirect()->back()->with('success', 'berhasil melakukan registrasi siswa');
        }catch(\Exception $e){
            DB::rollback();
            $this->rollbackAll(
                isset($user) ? $user : null,
                isset($student) ? $student : null,
                isset($mother) ? $mother : null,
                isset($father) ? $father : null,
                isset($wali) ? $wali : null,
                isset($registration) ? $registration : null
            );
            return redirect()->back()->withErrors(['error_message' => $e->getMessage()]);
        }
    }

    private function rollbackAll(?User $user = null, ?Student $student = null, ?Family $father = null, ?Family $mother = null, ?Family $wali = null, ?Registration $registration = null){
        if ($user) {
            $user->delete();
        }
    
        if ($student) {
            $student->delete();
        }
    
        // Delete family members if created (optional)
        if ($mother) {
            $mother->delete();
        }
        // ... similar checks for father and wali
        if ($father) {
            $father->delete();
        }
        if ($wali) {
            $wali->delete();
        }
        if ($registration) {
            $registration->delete();
        }
    
    }
    public function register_student(){
        return view('admin.register-student');
    }
    public function pay_remaining_amount(Request $request, $registration_uid){
        try{
            $this->validate($request, [
                'pendaftaran',
                'kegiatan_awal',
                'seragam',
                'spp',
                'dsp'
            ]);

            $data = Registration::where('registrations.registration_uid', $registration_uid)->with('payment_registration')->with('student')->first();
            if ($data->payment_registration->remaining_amount > 0){
                // dd(1);
                $payment_history = PaymentHistory::create([
                    'registration_id' => $data->id,
                    'pendaftaran' => $request->pendaftaran ?? 0,
                    'kegiatan_awal' => $request->kegiatan_awal ?? 0,
                    'seragam' => $request->seragam ?? 0,
                    'spp' => $request->spp ?? 0,
                    'dsp' => $request->dsp ?? 0,
                    "image_url" => "",
                    "receipt" => "default_value",
                    'amount' => $request->pendaftaran + $request->kegiatan_awal + $request->seragam + $request->spp + $request->dsp
                ]);
                
                $remaining_amount = $data->payment_registration->remaining_amount - ($request->pendaftaran + $request->kegiatan_awal + $request->seragam + $request->spp + $request->dsp);
                $paid_amount = $data->paid_amount + ($request->pendaftaran + $request->kegiatan_awal + $request->seragam + $request->spp + $request->dsp);
                if ($remaining_amount <= 0){
                    $data->payment_registration->remaining_amount = 0;
                } 
                $data->payment_registration->remaining_amount = $remaining_amount;
                $data->payment_registration->paid_amount = $paid_amount;
                $data->payment_registration->save();
                $data->save();

                $receiptData = [
                    'name' => $data->student->name,
                    'pendaftaran' => $request->pendaftaran,
                    'kegiatan_awal' => $request->kegiatan_awal,
                    'seragam' => $request->seragam,
                    'spp' => $request->spp,
                    'dsp' => $request->dsp,
                    'amount_paid' => $request->pendaftaran + $request->kegiatan_awal + $request->seragam + $request->spp + $request->dsp,
                    'payment_date' => $payment_history->created_at,
                    'remaining_amount' => $data->payment_registration->remaining_amount,
                    'registration_id' => $data->id,
                    'id' => $payment_history->id
                ];

                $receiptUrl = $this->generateReceipt($receiptData);
                $payment_history->receipt = $receiptUrl;
                $payment_history->save();

                // $response = new BinaryFileResponse($receiptUrl);
                // $response->deleteFileAfterSend(true);
                // $response->setContentDisposition('attachment', 'receipt.pdf');

                // Redirect back to the previous page
                Session::flash('payment_history_id', $payment_history->id);
                return Redirect::back()->with('success', 'Receipt downloaded successfully.');
                
            }
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error', $e->getMessage()]);
        }
    }

    public function pay_amount(Request $request, $registration_uid){
        try{
            $data = Registration::where('registration_uid', $registration_uid)->with('student')->with('payment_registration')->first();
            // dd($data);
            return view('student.payment', ['data' => $data]);
        }catch(\Exception $e){
            return view('student.payment')->withErrors(['error', $e->getMessage()]);
        }
    }

    private function generateReceipt($data){
        $dompdf = new Dompdf();
        setlocale(LC_TIME, 'id_ID.UTF-8');

        // Use Carbon's setLocale method
        Carbon::setLocale('id');

        // Create a Carbon instance for your date
        $date = Carbon::now();

        // Format the date in Indonesian
        $formattedDate = $date->translatedFormat('j F Y');
        // dd($formattedDate);

        // Retrieve receipt HTML content (you would need to customize this based on your data)
        // $html = '<html><body>';
        // $html .= '<h1>Kwitansi Pembayaran</h1>';
        // $html .= '<p>Nama siswa: ' . $data['name'] . '</p>';
        // $html .= '<p>Jumlah yang dibayar: ' . $data['amount_paid'] . '</p>';
        // $html .= '<p>Tanggal pembayaran: ' . $data['payment_date'] . '</p>';
        // // Add more receipt details as needed
        // $html .= '</body></html>';
        $html = '<html lang="en">
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .title {
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 20px;
                }
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .table td {
                    padding: 8px;
                    vertical-align: top;
                }
                .table td:first-child {
                    width: 200px;
                }
                .signature-section {
                    text-align: right;
                    margin-top: 50px;
                }
                .signature-line {
                    margin-top: 60px;
                }
            </style>
            <script>
                window.onload = function() {
                    window.print();
                };
            </script>
        </head>
        <body>
        
            <div class="title">BUKTI PEMBAYARAN UANG SEKOLAH</div>
        
            <table class="table">
                <tr>
                    <td>NAMA SISWA</td>
                    <td>: '.$data['name'].'</td>
                </tr>
            </table>
        
            <table class="table">
                <tr>
                    <td>Pendaftaran</td>
                    <td>: Rp. '.$data['pendaftaran'].'</td>
                </tr>
                <tr>
                    <td>Kegiatan Awal PPDB</td>
                    <td>: Rp. '.$data['kegiatan_awal'].'</td>
                </tr>   
                <tr>
                    <td>Seragam/PSAS</td>
                    <td>: Rp. '.$data['seragam'].'</td>
                </tr>
                <tr>
                    <td>SPP Bulan</td>
                    <td>: Rp. '.$data['spp'].'</td>
                </tr>
                <tr>
                    <td>Dana Sumbangan Pendidikan (DSP)</td>
                    <td>: Rp. '.$data['dsp'].'</td>
                </tr>
                <tr>
                    <td>JUMLAH</td>
                    <td>: Rp. '.$data['amount_paid'].'</td>
                </tr>
            </table>
        
            <div class="signature-section">
                Bandung, '.$formattedDate.'<br>
                Bendahara SMA Pasundan 3 Bandung
                <div class="signature-line">--------------------------------------------</div>
            </div>
        
        </body>
        </html>';

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation (optional)
        $dompdf->setPaper('B5', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the generated PDF content
        $pdfContent = $dompdf->output();

        $pdfDirectory = public_path('receipts');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true); // Create the directory recursively
        }

        // Save PDF to server
        $pdfFileName = 'receipt_' . $data['id'] . '.pdf';
        $pdfFilePath = public_path('receipts/' . $pdfFileName); // Use public_path() to get the local file path
        file_put_contents($pdfFilePath, $pdfContent);
        $url = asset('receipts/'.$pdfFileName);

        // Return the file path
        return $url;
    }

    public function list_accept_students(Request $request){
        if ($request->ajax()){
            $data = Student::with('families', 'registration') // Load families and registration
            ->where('verify_status', true)
            ->whereExists(function ($query) {
                $query->select('id')
                    ->from('registrations')
                    ->whereColumn('registrations.student_id', 'students.id')
                    ->where('registrations.status', 'accept');
            })
            ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $registrationUid = $row->registration ? $row->registration->registration_uid : null;

                        $btn = '<a href="' . route('admin.student_detail', ['registration_uid' => $registrationUid]) . '" class="btn btn-primary">View Details</a><br>
                                <a href="'.route('admin.pay_amount', ['registration_uid' => $registrationUid]).'" class="btn btn-success">Pay</a><br>
                                <a href="'.route('admin.check_pay_histories', ['registration_uid' => $registrationUid]).'" class="btn btn-secondary"> Show histories</a>
                                ';

      
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.accept-student');
    }

    public function check_remaining_amount($registration_uid){
        // $user = User::where('id', auth()->id())->with('student')->with('student.registration')->first();
        $data = Registration::where('registration_uid', $registration_uid)->with('payment_registration')->with('payment_histories')->first();
        // dd($data);
        return view('admin.check-remaining-amount', ['data' => $data]);
    }

}
