Cliquez ici pour réinitialiser votre mot de passe: <a href="{{ $link = url('patient/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
