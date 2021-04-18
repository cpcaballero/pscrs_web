<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/CreatorJwt.php';

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Manila');
		$this->objOfJwt = new CreatorJwt();
	}

	public function index()
	{
		$recipient = 'curiosomarcusjonas24@gmail.com';
		$subject = "PSCRS Online - Password Recovery";
		$message =
			'
			<p>Hi Marcus<p>
			<br>
			<p>PSCRS Online password reset successful.</p>
			<br>
			
			<p>Here is your new TEMPORARY PASSWORD: 123123123.</p>
			
			<br>
			<p>Please change your password immediately after this.</p>
			<p>If you did not request a password reset please ignore this email or reply to let us know.</p>
		';

		$message = $this->email_template($message);
		$config['protocol'] = 'smtp';
		$config['smtp_crypto'] = 'tls';
		$config['smtp_host'] = 'smtp.gmail.com';
		$config['smtp_port'] = '587';
		$config['smtp_user'] = 'pscrsonline@gmail.com';
		$config['smtp_pass'] = 'pscrsonline1234';
		$config['mailtype'] = 'html';
		$config['newline'] = "\r\n";

		$this->email->initialize($config);
		$this->email->from('pscrsonline@gmail.com', 'PSCRS Online');
		$this->email->to($recipient);

		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			echo 'Your Email has successfully been sent.';
		} else {
			show_error($this->email->print_debugger());
		}
	}

	public function email_template($message)
	{
		$template = '
        <!DOCTYPE html>

        <html lang="en">

        <body style="background-color:white;">
        ' . $message . '
        </body>

        </html>
        ';

		return $template;
	}

	public function token()
	{
		$tokenData['user'] = "sample";
		$tokenData['timeStamp'] = Date('Y-m-d h:i:s');
		$jwtToken = $this->objOfJwt->GenerateToken($tokenData);
		$this->dd($jwtToken);
	}

	public function dd($data)
	{
		echo "<pre>";
		print_r($data);
		echo "<pre>";
		die();
	}
}
