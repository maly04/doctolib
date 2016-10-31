<?php

namespace App\Http\Controllers\PatientAuth;
use App\Brokers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password as passwords;
use Illuminate\Contracts\Auth\Guard;
use App\UserPatient;
use Password;
use Auth;
use Closure;
use Hash;
use Session;
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $redirectTo = '/login';
    protected $resetView = 'PatientAuth/auth';
    /**
     * Create a new password controller instance.
     *
     * @return void
     */

    public function __construct()
    {        
        $this->subject = 'Demande de réinitialisation de votre mot de passe sur le site Global Santé';
    }
    public function getBroker(){
       // echo "<script>alert(12);</script>";
       return 'userPatient';
    }
    public function showResetForm(Request $request, $token = null){
         if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (view()->exists('PatientAuth/auth/passwords/reset')) {
            return view('PatientAuth/auth/passwords/reset')->with(compact('token', 'email'));
        }

        return view('PatientAuth.auth.reset')->with('token', $token);
        //return view("PatientAuth/auth/passwords/reset");
    }

   // public function showResetForm(Request $request, $token = null)
   //  {
   //      if (is_null($token)) {
   //          return $this->getEmail();
   //      }

   //      $email = $request->input('email');

   //      if (property_exists($this, 'resetView')) {
   //          return view($this->resetView)->with(compact('token', 'email'));
   //      }

   //      if (view()->exists('PatientAuth.auth.passwords.reset')) {
   //          return view('PatientAuth.auth.passwords.reset')->with(compact('token', 'email'));
   //      }

   //      return view('PatientAuth.auth.reset')->with(compact('token', 'email'));
   //  }


 }
