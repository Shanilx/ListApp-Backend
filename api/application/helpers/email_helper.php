<?php

function send_forgot_passsword($first_name, $email, $password_decode)
{
	
	$ci =& get_instance();

	$config['wordwrap'] = TRUE;

	$config['mailtype'] = 'html';
	
	$config['charset'] = 'utf-8';

	$config['priority'] = '1';
	
	$config['crlf']      = "\r\n";
	
	$config['newline']      = "\r\n";

	$config['protocol'] = 'smtp';//$this->config->item('protocol');

	$config['smtp_host']  = SMTP_HOST;
	
	$config['smtp_user']  = SMTP_USER;
	
	$config['smtp_pass']  = SMTP_PASS;
	
	$config['smtp_port']  = SMTP_PORT;

	$ci->email->initialize($config);	

	$ci->email->from(PORTAL_EMAIL, PORTAL_NICKNAME);
	
	$ci->email->to($email);
	
	//$this->email->bcc(BCC_EMAIL); 
	
	$ci->email->subject('Forgot Password');
	
	$str_url = '<p>Your password is:'. $password_decode.'</p>';
	
	//$str_final =  str_replace('## Reset Link ##', $str_url, $str_content);
	
	$data_email['str_final'] = $str_url;
	$data_email['fname'] = $first_name;
	
	$msg = $ci->load->view('email/email_template',$data_email, TRUE);

	$ci->email->message($msg);
	$ci->email->send();

}

function send_user_password($first_name, $email, $password)
{
	
	$ci =& get_instance();

	$config['wordwrap'] = TRUE;

	$config['mailtype'] = 'html';
	
	$config['charset'] = 'utf-8';

	$config['priority'] = '1';
	
	$config['crlf']      = "\r\n";
	
	$config['newline']      = "\r\n";

	$ci->email->initialize($config);	

	$ci->email->from(PORTAL_EMAIL, PORTAL_NICKNAME);
	
	$ci->email->to($email);
	
	//$this->email->bcc(BCC_EMAIL); 
	
	$ci->email->subject('Authentication Information');
	$str_url = "<p>	LIST APP Autentication Information </p>";
	
	$data_email['str_final'] = $str_url;
	$data_email['fname'] = $first_name;
	$data_email['mail_id'] = $email;
	$data_email['password'] = $password;
	
	$msg = $ci->load->view('email/email_template',$data_email, TRUE);

	$ci->email->message($msg);
	$ci->email->send();

}

function send_email_information($to,$from,$subject,$content)
{
	
	$ci =& get_instance();

	$config['protocol'] = 'sendmail';
    $config['wordwrap'] = FALSE;
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
    $ci->load->library('email', $config); 

	$ci->email->initialize($config);	
    
	$ci->email->from($from);
	
	
	$ci->email->to($to);
	
	//$this->email->bcc(BCC_EMAIL); 
	
	$ci->email->subject($subject);
	
    $data_email['str_final'] = $content;
    //$data_email['fname']    = $user_name;
	
	$msg = $ci->load->view('email/email_template',$data_email, TRUE);
	$ci->email->message($msg);


	$send=$ci->email->send();
	if($send)
	{
		return "TRUE";
	}
	else
	{
		return "FALSE";
	}

}


?>