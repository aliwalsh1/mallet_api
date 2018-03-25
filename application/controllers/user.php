<?php
require(APPPATH.'libraries/REST_Controller.php');

class User extends REST_Controller {
	
	function login_post(){ //create token
		
		$user=$this->post('username');
		$pass=$this->post('password');
		
		{//check all input is there
			$param=0;
			if(empty($user)){
			    $param=1;
                $this->response(array('error' => 'Missing username parameter!'), 400);			}
			if(empty($pass)){
			    $param=1;
                $this->response(array('error' => 'Missing password parameter!'), 400);			}
			
			if($param!=0){
                $this->response(array('error' => 'Missing Parameters!!'), 400);

            }
		}
		
		$this->load->database();
		$sql  ="SELECT COUNT(id) AS record, id, username, title, first, last, gender, email, handicap, ip, currentPlayer, _password FROM users WHERE username='$user'; ";
		$query = $this->db->query($sql);
		$data = $query->row();
		
		{   // see if user exists...
			//$usercount = $data->id;
			if ($data->record == "0") {
                $this->response(array('error' => 'User entered does not exist'), 400);

			}
		}
		
//		{//check user has been validated NOT DOING YET
//			if ($data->valid ='0'){
//				$info->status = 'failure';
//				$info->valid = $data->valid;
//				$info->error->code = 41;
//				$info->error->text = 'The user you have entered has not been verified';
//				$this->response($info, 400);
//			}
//		}
		
		
		
		{ // Check login and issue token
			if($data->username == $user && $data->_password == $pass)
			{
				
				$code = uniqid();
				
				$user_id = $data->id;
				//if($data->student_id == NULL ) $type='bussiness'; else $type='student';
				$ip=$_SERVER['REMOTE_ADDR'];
				//$info= array('user_id'=>$user_id, 'ip'=>$ip, 'token'=>$code, 'validuntil'=>$expire);
				$info= array('user_id'=>$user_id, 'ip'=>$ip, 'token'=>$code);
				$this->db->insert('tokens', $info);
                $this->response(array('response' => 'success','token'=> $user_id,'code'=> $code), 200);
//				$output->status = 'success';
//				$output->user_id=$user_id;
//				$output->token = $code;
				//$output->type = $type;  //have 0 as admin, different access levels

				
				//$this->response($output, 200);
				
			}
			else
			{
                $this->response(array('error' => 'Invalid Credentials'), 400);
			}
		}
	}

	function login_put() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The PUT method is not supported by this resource'), 400);
		}
	}
	function login_delete() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The DELETE method is not supported by this resource'), 400);
		}
	}
	function login_get() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The GET method is not supported by this resource'), 400);
		}
	}
	
	function logout_delete($token = null){//delete token
		{   // checking that a token has been supplied
			if ($token == null) { // no token
                $this->response(array('error' => 'Token Required'), 401);
                }
		}
		//$ip=$_SERVER['REMOTE_ADDR'];
		
		$this->load->database();
		$sql  ="SELECT COUNT(id) AS record, user_id, ip FROM tokens WHERE token='$token'; ";
		$query = $this->db->query($sql);
		$data = $query->row();
		
		if ($data->record == "0") {//does token exist?
            $this->response(array('error' => 'Token submitted does not exist'), 400);
            }
		
//		$tokip = $data->ip;
//
//		if($ip == $tokip)
		{
			$sql  ="DELETE FROM tokens WHERE token='$token'; ";
			$query = $this->db->query($sql);  //the sql response, doesnt really matter

            $this->response(array('response' => 'logout success'), 200);


        }
//		else
//		{
//			$output->status = 'failure';
//			$output->error->code = 43;
//			$output->error->text = 'Incorrect ip for token';
//			$this->response($output, 400);
//		}
		

	}
	
	function logout_get() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The GET method is not supported by this resource'), 400);

        }
	}
	function logout_put() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The PUT method is not supported by this resource'), 400);
        }
	}
	function logout_post() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The PUT method is not supported by this resource'), 400);
        }
	}
	
	function username_get($id = null) { //Get username from id to use at the top of the frontend
		{   
			$this->load->database();
			$sql= "SELECT username FROM users WHERE (id = $id) AND (users.valid = 1);";
			$query = $this->db->query($sql);
			$data = $query->result();
            $this->response(array('response' => $data), 400);
            }
	}
	
	function username_delete() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The DELETE method is not supported by this resource'), 400);
        }
	}
	
	function username_put() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The PUT method is not supported by this resource'), 400);
            }
	}
	
	function username_post() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The POST method is not supported by this resource'), 400);
        }
	}
	
		function checktoken_get() { //Check token
		{   
		include 'login.php';
            $this->response(array('response' => 'valid'), 200);
        }
	}
	
	function checktoken_options() { //Check token, have to be logged in
		{   
		include 'login.php';
            $this->response(array('response' => 'valid'), 200);
		}
	}
	
	function checktoken_delete() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The DELETE method is not supported by this resource'), 400);
		}
	}
	
	function checktoken_put() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The PUT method is not supported by this resource'), 400);
        }
	}
	
	function checktoken_post() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The POST method is not supported by this resource'), 400);
        }
	}
	
		function getuserid_get($username = null) { //Get username from id
		{   
			$this->load->database();
			$sql= "SELECT id FROM users WHERE (username = '$username') AND (users.valid = 1);";
			$query = $this->db->query($sql);
			$data = $query->result();
            $this->response(array('data' => $data), 200);
            }
	}
	
	function getuserid_delete() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The DELETE method is not supported by this resource'), 400);

		}
	}
	
	function getuserid_put() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The PUT method is not supported by this resource'), 400);
        }
	}
	
	function getuserid_post() { //Unused Method, unsupported
		{   // unsupported method
            $this->response(array('failure' => 'The POST method is not supported by this resource'), 400);
        }
	}
	
		function id_post($id = null) { //update
		{   // unsupported method
			include 'login.php';
			if(empty($id)){
                $this->response(array('error' => 'missing URI parameter'), 400);

            }
			
			//if($tok_userid != $id)
//			{
//                $this->response(array('failure' => 'You do not have permission to view/edit this'), 400);
//
//            }
			
			$this->load->database();
		 $this->db->where('id',$id);
		 $this->db->update('users',$_POST);
		 $data->rows = $this->db->affected_rows();
		 $this->response($data, 200);
			
			
		}
	}


}
?>