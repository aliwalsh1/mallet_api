<?php
//Check login tokens

$headers = $this->input->request_headers();
{//Get Token from header & check is there
	if(empty($headers['Authorisation']))
	{
        $this->response(array('error' => 'Missing Token!!'), 400);

    }
	
	
}

{//Check token exists
	
	$this->load->database();
	$tok = $headers['Authorisation'];
	$sql = "SELECT COUNT(id) AS records FROM tokens WHERE  token='$tok';";
	//$this->response($sql, 200);
	$query = $this->db->query($sql);
	$data = $query->row();
	if ($data->records == "0") {
        $this->response(array('error' => 'Token does not exist!!'), 400);
	}
	
}

{//Check token is still valid

	$this->load->database();
	$tok = $headers['Authorisation'];
	$sql = "SELECT COUNT(id) AS records, user_id, ip FROM tokens WHERE token='$tok' AND DATEDIFF(CURRENT_TIMESTAMP, _generated)<1;"; //instead of validUntil field "AND generated >DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY)"
	//$this->response($sql, 200);
	$query = $this->db->query($sql);
	$data = $query->row();
	if ($data->records == "0") {
		$sql  ="DELETE FROM tokens WHERE token='$tok'; ";
		$query = $this->db->query($sql);
        $this->response(array('error' => 'Token is not valid! Log in again'), 400);
	}
}

//{//Check Request is from same ip as token
//    //do not need to do, but good to log IP for security
//	$ip=$_SERVER['REMOTE_ADDR'];
//	if($ip!=$data->ip)
//	{
//        $this->response(array('error' => 'IP address does not match token!!'), 400);
//
//    }
//
//}

{//Get user ID associated with token
	$tok_userid = $data->user_id;

}




