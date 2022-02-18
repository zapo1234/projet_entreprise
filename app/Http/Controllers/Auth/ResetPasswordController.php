<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repository\Users\UserRepository;
use App\Http\Service\Mailer\ServiceMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    private $userRepository;
    private $serviceMailer;
    
    public function __construct(UserRepository $userRepository, ServiceMailer $serviceMailer)
    {
        $this->userRepository = $userRepository;
        $this->serviceMailer = $serviceMailer;
    }
    
    public function reset_pass()
    {
        return view('auth.passwords.reset');
    }

    public function sendEmail(Request $request)
    {
       // ckeck email (récupérer l'email de user et verifier si existe)
        $email = $request->get('email');
        $user_email = $this->userRepository->getEmail($email);
        if(!$user_email)
        {
          return redirect()->route('auth.passwords.reset')->with('error','cette adresse e-mail n\'est pas identifier !');
        }
     }
}
