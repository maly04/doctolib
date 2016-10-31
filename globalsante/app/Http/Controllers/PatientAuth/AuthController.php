<?php

namespace App\Http\Controllers\Patientauth;

use App\UserPatient;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
//use Auth;

class AuthController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login#patient';
    protected $guard = 'userPatient';

    // public function __construct(TokenRepositoryInterface $tokens,
    //    UserProvider $users,
    //    MailerContract $mailer,
    //    $emailView)
    //     {
    //      $this->users = new UserPatient();
    //      $this->mailer = $mailer;
    //      $this->tokens = $tokens;
    //      $this->emailView = $emailView;
    //     }
    
    
    public function showLoginForm()
    {
        if (Auth::guard('userPatient')->check())
        {
            return redirect('/login#patient');
        }
        
        return view('PatientAuth.auth.login');
    }
    
    public function showRegistrationForm()
    {
        return view('PatientAuth.register');
    }
    
    public function resetPassword()
    {
        //echo "testing";
        return view('PatientAuth.auth.passwords.email');
    }
    
    public function logout(){
        Auth::guard('userPatient')->logout();
        return redirect('/login#patient');
    }
}
