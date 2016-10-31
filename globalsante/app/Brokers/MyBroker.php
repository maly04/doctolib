<?php
	
	namespace App\Brokers;
	use Illuminate\Auth\Passwords\PasswordBroker;
	
	use App\UserPatient;
	class MyBroker extends PasswordBroker
	{
		// public function __construct(TokenRepositoryInterface $tokens,
		//        UserProvider $users,
		//        MailerContract $mailer,
		//        $emailView)
		// {
		//  $this->users = new UserPatient();
		//  $this->mailer = $mailer;
		//  $this->tokens = $tokens;
		//  $this->emailView = $emailView;
		// }

		public function __construct(TokenRepositoryInterface $tokens,
		         UserProvider $users,
		         MailerContract $mailer,
		         $emailView)
		{
		parent::__construct($tokens, new UserPatient(), $mailer, $emailView);
		}
		
		
	}

?>