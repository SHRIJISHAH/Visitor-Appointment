<!-- Login Form -->

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Noto Sans' rel='stylesheet'>
        <link rel="stylesheet" href="page1.css">
        <title>User Login</title>
    </head>
    <style>
        button {
            background: #ED5579;
            border: 0px;
            border-radius: 7px;
            width: 351px;
            height: 50px;
            left: 5px;
            margin-top: 15px;
        }
        .btn {
            font-family: Noto Sans;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            color: #FFFFFF;
        }
        .element2 {
            width: 358px;
            height: 50px;
            margin-top: 319px;
            left: 16px;
        }
        input {
            width: 351px;
            height: 50px;
            border: 1px solid #EDF1F7;
        }
        .input2 {
            margin-top: 20px;
        }
        input::placeholder {
            width: 135px;
            height: 20px;
            top: 15px;
            left: 14px;
            font-family: Noto Sans;
            font-size: 15px;
            font-weight: 400;
            line-height: 20px;
            letter-spacing: 0px;
            text-align: left;
            color: #8F9BB3;
        }
        .symbol {
            left: 130px;
            top: 255px;
            position: absolute;
            text-align: center;
            color: #ED5579;
            font-size: 32px;
            font-family: Noto Sans;
            font-weight: 800;
            line-height: 16px;
            word-wrap: break-word;
        }
        .symbl {
            position: absolute;
            width: 91px;
            height: 91px;
            left: 143px;
            top: 136px;
        }
        .vector {
            position: absolute;
            left: 12.5%;
            right: 12.5%;
            top: 12.5%;
            bottom: 12.5%;
            background: #FFFFFF;
        }
        .path {
            position: absolute;
            width: 92px;
            height: 93px;
            left: 142px;
            top: 135px;
            background: #ED5579;
            box-shadow: 0px 3px 30px rgba(0, 0, 0, 0.0784314);
        }
    </style>

    <body>
        <div style="width: 100%; height: 100%; position: relative; background: white">
            <div style="width: 390px; height: 844px; left: 525px; top: 0px; position: absolute; background: white">
                <div
                    style="width: 92px; height: 93px; left: 142px; margin-top: 135px; position: absolute; background: #ED5579; box-shadow: 0px 3px 30px rgba(0, 0, 0, 0.08)">
                </div>
                <div style="width: 91px; height: 91px; left: 143px; top: 136px; position: absolute">
                    <div
                        style="width: 68.25px; height: 68.25px; left: 11.38px; top: 11.38px; position: absolute; background: white">
                    </div>
                </div>
                <div class="symbol">accessi</div>
                <form action="/login" method="POST">
                    @csrf
                    <div class="element2">
                        <input type="number" placeholder="Mobile Number">
                    </div>
                    <button>
                        <div class="btn">GENERATE OTP</div>
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>


<!-- AuthController -->

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Msg91Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $msg91Service;

    public function __construct(Msg91Service $msg91Service)
    {
        $this->msg91Service = $msg91Service;
    }

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users',
            'mobile_no' => 'required|string|max:15|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }

            $user = User::create([
            'name' => $validator->validated()['name'],
            'email' => $validator->validated()['email'],
            'mobile_no' => $validator->validated()['mobile_no'],
        ]);

        Auth::login($user);

        return redirect('/appointment')->with('success', 'Registration successful. You are now logged in.');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                        ->withErrors($validator)
                        ->withInput();
        }

        $mobileNumber = $validator->validated()['mobile_no'];

        $user = User::where('mobile_no', $mobileNumber)->first();

        if ($user) {
            $otp = $this->generateOtp();

            if ($this->msg91Service->sendOtp($user->mobile_no, $otp)) {
                Session::put('mobileNumber', $user->mobile_no);
                Session::put('otp', $otp);

                return redirect('/verify-otp');
            } else {
                return redirect('/login')->with('error', 'Failed to send OTP. Please try again.');
            }
        } else {
            return redirect('/login')->with('error', 'User not found. Please register first.');
        }
    }

    public function showOtpVerificationForm()
    {
        return view('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return redirect('/verify-otp')
                        ->withErrors($validator)
                        ->withInput();
        }

        $enteredOtp = $validator->validated()['otp'];
        $sentOtp = Session::get('otp');
        $mobileNumber = Session::get('mobileNumber');

        if ($sentOtp === $enteredOtp) {
            Session::forget('mobileNumber');
            Session::forget('otp');

            $user = User::where('mobile_no', $mobileNumber)->first();
            Auth::login($user);

            return redirect('/appointment')->with('success', 'OTP verified successfully. You are now logged in.');
        } else {
            return redirect('/verify-otp')->with('error', 'Invalid OTP. Please try again.');
        }
    }

    private function generateOtp()
    {
        return strval(random_int(100000, 999999));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}

// Msg91Service

<?php

namespace App\Services;

use GuzzleHttp\Client;

class Msg91Service
{
    protected $authKey;
    protected $senderId;
    protected $apiUrl = 'http://api.msg91.com/api/sendotp.php';

    public function __construct()
    {
        $this->authKey = config('services.msg91.auth_key');
        $this->senderId = config('services.msg91.sender_id');
    }

    public function sendOtp($mobileNumber, $otp)
    {
        $client = new Client();

        try {
            $message = sprintf('Your OTP code is: %s. Please use this OTP to proceed.', $otp);

            $response = $client->get($this->apiUrl, [
                'query' => [
                    'authkey' => $this->authKey,
                    'mobile' => $mobileNumber,
                    'message' => $message,
                    'sender' => $this->senderId,
                    'otp_length' => '6',
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            \Log::info('Msg91 API Response: ' . json_encode($body));

            if ($body['type'] === 'success') {
                return true;
            } else {
                \Log::error('Error sending OTP: ' . $body['message']);
                return false;
            }
        } catch (\Exception $e) {
           \Log::error('Exception occurred while sending OTP: ' . $e->getMessage());
            return false;
        }
    }

}





















{{ route('superadmin.show-admin', ['id' => $admin->id]) }}
{{ route('superadmin.edit-admin', ['id' => $admin->id]) }}
{{ route('superadmin.delete-admin', ['id' => $admin->id]) }}

























<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\OrganizationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify-otp', [AuthController::class, 'showOtpVerificationForm'])->name('verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/calendar', function () {
        return view('appointment.calendar');
    });

    Route::get('/appointment', [AppointmentController::class, 'showForm']);
    Route::post('/appointment', [AppointmentController::class, 'store']);
    Route::get('/appointment/{token}', [AppointmentController::class, 'showByToken'])->name('appointment.show');
    Route::get('/appointment/qrcode/{token}', [AppointmentController::class, 'showQRCode'])->name('appointment.qrcode');
    Route::get('/appointment/date/{date}', [AppointmentController::class, 'getAppointmentsByDate']);
    Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');
    Route::get('/appointments/{date}', [AppointmentController::class, 'getAppointmentsByDate']);

});

Route::get('/admin/login', [AdminController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/verify-otp', [AdminController::class, 'showOtpVerificationForm'])->name('admin.verify-otp');
Route::post('/admin/verify-otp', [AdminController::class, 'verifyOtp']);

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');

    // Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register.form');
    // Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.submit');
    Route::get('/admin/add-user', [AdminController::class, 'showAddUserForm'])->name('admin.add-user.form');
    Route::post('/admin/add-user', [AdminController::class, 'addUser'])->name('admin.add-user');
    Route::get('/admin/all-appointments', [AdminController::class, 'showAllAppointments'])->name('admin.all-appointments');
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage-users');
    Route::get('/admin/show-all-users', [AdminController::class, 'showAllUsers'])->name('admin.show-all-users');
    Route::get('/admin/show-user/{id}', [AdminController::class, 'showUser'])->name('admin.show-user');
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::post('/admin/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.update-user');
    Route::get('/admin/delete-user/{id}', [AdminController::class, 'deleteUserConfirmation'])->name('admin.delete-user');
    Route::post('/admin/confirm-delete-user/{id}', [AdminController::class, 'confirmDeleteUser'])->name('admin.confirm-delete-user');

    Route::post('/admin/logout', [AdminController::class, 'logoutAdmin'])->name('admin.logout');
});

Route::get('/scan-qr', [QRCodeController::class, 'showScanner'])->name('scan-qr');
Route::post('/scan-qr', [QRCodeController::class, 'scanQRCode'])->name('scan-qr.process');
Route::post('/log-qr-code-scan', [QRCodeController::class, 'logQrCodeScan']);
Route::get('/scan', [QRCodeController::class, 'showScanner'])->name('qr-code-scanner');

// Provider Routes
Route::get('/provider/login', [ProviderController::class, 'showLoginForm']);
Route::post('/provider/login', [ProviderController::class, 'login']);
Route::get('/provider/verify-otp', [ProviderController::class, 'showOtpVerificationForm']);
Route::post('/provider/verify-otp', [ProviderController::class, 'verifyOtp']);

Route::middleware(['auth:provider'])->group(function () {
    Route::get('/provider/dashboard', [ProviderController::class, 'dashboard'])->name('provider.dashboard');
    Route::get('/provider/show-form', [ProviderController::class, 'showForm'])->name('provider.showForm');
    Route::get('/provider/logout', [ProviderController::class, 'logoutProvider']);

    Route::get('/provider/show-superadmins', [ProviderController::class, 'showSuperadmins'])->name('provider.showSuperadmins');
    Route::get('/provider/organizations', [ProviderController::class, 'showOrganizations'])->name('provider.organizations');
    Route::get('/provider/create-organization', [ProviderController::class, 'showForm'])->name('provider.showForm');
    Route::post('/provider/create-organization', [ProviderController::class, 'addOrganization'])->name('provider.create-organization');

});

// Superadmin Routes
Route::get('/superadmin/dashboard', [SuperadminController::class, 'dashboard'])->name('superadmin.dashboard');

Route::get('/superadmin/login', [SuperadminController::class, 'showLoginForm'])->name('superadmin.login');
Route::post('/superadmin/login', [SuperadminController::class, 'login']);

// Route::get('/superadmin/register', [SuperadminController::class, 'showRegistrationForm']);
// Route::post('/superadmin/register', [SuperadminController::class, 'register']);
Route::get('/superadmin/dashboard', [SuperadminController::class, 'dashboard']);
Route::post('/superadmin/logout', [SuperadminController::class, 'logout'])->name('superadmin.logout');
Route::get('/superadmin/manage-admins', [SuperadminController::class, 'manageAdmins']);

Route::get('/superadmin/verify/{token}', [SuperadminController::class, 'verify'])->name('superadmin.verify');
Route::get('/superadmin/verify/{token}', [SuperadminController::class, 'showVerificationForm'])->name('superadmin.verify');
Route::post('/superadmin/verify', [SuperadminController::class, 'verify']);

// Organization Routes
Route::get('/organization/{id}', [OrganizationController::class, 'show']);
Route::get('/organization/{id}/edit', [OrganizationController::class, 'edit']);
Route::put('/organization/{id}', [OrganizationController::class, 'update']);
Route::delete('/organization/{id}', [OrganizationController::class, 'destroy']);



// Route::group(['prefix' => 'superadmin'], function () {
//     Route::get('/login', [SuperadminController::class, 'showLoginForm']);
//     Route::post('/login', [SuperadminController::class, 'login'])->name('superadmin.login');

//     Route::get('/register', [SuperadminController::class, 'showRegistrationForm']);
//     Route::post('/register', [SuperadminController::class, 'register'])->name('superadmin.register');


//     Route::middleware(['auth:superadmin'])->group(function () {
//         Route::get('/dashboard', [SuperadminController::class, 'dashboard'])->name('superadmin.dashboard');
//         Route::get('/manage-admins', [SuperadminController::class, 'manageAdmins'])->name('superadmin.manage-admins');
//         Route::post('/logout', [SuperadminController::class, 'logout'])->name('superadmin.logout');
//         Route::get('/superadmin/edit-admin/{id}', [SuperadminController::class, 'editAdmin'])->name('superadmin.edit-admin');
//         Route::put('/superadmin/update-admin/{id}', [SuperadminController::class, 'updateAdmin'])->name('superadmin.update-admin');
//         Route::get('/superadmin/show-admin/{id}', [SuperadminController::class, 'showAdmin'])->name('superadmin.show-admin');
//         Route::get('/superadmin/delete-admin/{id}', [SuperadminController::class, 'deleteAdminConfirmation'])->name('superadmin.delete-admin');
//         Route::delete('/superadmin/confirm-delete-admin/{id}', [SuperadminController::class, 'confirmDeleteAdmin'])->name('superadmin.confirm-delete-admin');

//     });
// });

// Route::group(['prefix' => 'provider'], function () {

//     Route::get('/login', [ProviderController::class, 'showLoginForm']);
//     Route::post('/login', [ProviderController::class, 'login']);

//     Route::get('/verify-otp', [ProviderController::class, 'showOtpVerificationForm']);
//     Route::post('/verify-otp', [ProviderController::class, 'verifyOtp']);

//     Route::middleware(['auth:provider'])->group(function () {
//         Route::get('/dashboard', [ProviderController::class, 'dashboard']);
//         Route::get('/logout', [ProviderController::class, 'logoutProvider']);

//         // Add organization routes
//         Route::get('/add-organization', [ProviderController::class, 'showForm']);
//         Route::post('/add-organization', [ProviderController::class, 'addOrganization']);
//     });
// });
