<?php
require(APPPATH.'libraries/REST_Controller.php');

class Matches extends REST_Controller {
    /*
POST match/new
GET match/list
GET match/id
GET match/team_id (?)
PUT match/assign_team (?)
PUT match/complete
    */
    function list_get(){// list all valid matches
        $this->load->database();
        $sql= 'SELECT * FROM matches;';
        $query = $this->db->query($sql);
        $data = $query->result();
        $this->response(array('response' => $data), 200);
    }

    function played_get($cat =null){// list all matches that have yet to be played
        $this->load->database();
        $sql= "SELECT * FROM matches WHERE (firstTeamScore IS NOT NULL) AND (secondTeamScore IS NOT NULL);";
        $query = $this->db->query($sql);
        $data = $query->result();

        $this->response($data, 200);
    }

    function list_delete() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The DELETE method is not supported by this resource';
            $this->response($info, 400);
        }
    }
    function list_put() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The PUT method is not supported by this resource';
            $this->response($info, 400);
        }
    }
    function list_post() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The POST method is not supported by this resource';
            $this->response($info, 400);
        }
    }

    function id_get($id =null){ //get match by id
        if(empty($id)){
            $info->status = 'failure';
            $info->error->code = 36;
            $info->error->text = 'Missing uri parameter!';
            $this->response($info, 400);
        }
        $this->load->database();

        {//check exists
            $sql = "SELECT COUNT('id') AS records FROM matches WHERE  id='$id';";
            $query = $this->db->query($sql);
            $data2 = $query->row();
            if ($data2->records == "0") {
                $info->status = 'failure';
                $info->error->code = 43;
                $info->error->text = 'Record does not exist!';
                $this->response($info, 400);
            }

        }

        $sql= "SELECT * FROM matches WHERE (id='$id');";
        $query = $this->db->query($sql);
        $data = $query->result();



        $this->response($data, 200);
    }

    function id_delete() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The DELETE method is not supported by this resource';
            $this->response($info, 400);
        }
    }
    function id_post() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The POST method is not supported by this resource';
            $this->response($info, 400);
        }
    }
    function id_put() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The PUT method is not supported by this resource';
            $this->response($info, 400);
        }
    }

    function team_id_get($id = null){ //get a team's matches
//        include 'login.php';
        if(empty($id)){
            $info->status = 'failure';
            $info->error->code = 36;
            $info->error->text = 'Missing uri parameter!';
            $this->response($info, 400);
        }
//        {//Check user has privileges to access this
//            if($tok_userid !=$id)
//            {
//                $info->status = 'failure';
//                $info->error->code = 42;
//                $info->error->text = 'You do not have permission to access / change this!';
//                $this->response($info, 400);
//            }
//        }

        $this->load->database();
        $sql= "SELECT id from matches where (firstTeamID=$id) or (secondTeamID=$id);";
        $query = $this->db->query($sql);
        $data = $query->result();

        $this->response($data, 200);
    }
    function match_id_delete() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The DELETE method is not supported by this resource';
            $this->response($info, 400);
        }
    }
    function match_id_put() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The PUT method is not supported by this resource';
            $this->response($info, 400);
        }
    }
    function match_id_post() { //Unused Method, unsupported
        {   // unsupported method
            $info->status = 'failure';
            $info->error->code = 40;
            $info->error->text = 'The POST method is not supported by this resource';
            $this->response($info, 400);
        }
    }


//    public function new_post()
//        //make it check whether the team IDs are actually present/choose from a dropdown list
//    {
//        if (!$this->post('match')) {
//            $info->error->text = 'It aint working hunnie';
//            $this->response($info, data, 400);
//        }
//        $id = $this->Matches_model->save($this->post('match'));
//
//        if (!is_null($id)) {
//            $this->response(array('response' => $id), 200);
//        } else {
//            $this->response(array('error', 'something has happened to the server'), 400);
//        }
//    }

    function index_post()
    { // post a new match
        //firstTeamID, secondTeamID, firstTeamColours, secondTeamColours, pitch, dateAndTime, LeagueID, firstTeamScore, secondTeamScore
        $firstTeamID=$this->post('firstTeamID');
        $secondTeamID = $this->post('secondTeamID');
        $firstTeamColours=$this->post('firstTeamColours');
        $secondTeamColours=$this->post('secondTeamColours');
        $pitch=$this->post('pitch');
        $dateAndTime=$this->post('dateAndTime');
        $LeagueID=$this->post('LeagueID');
        $firstTeamScore=$this->post('firstTeamScore');
        $secondTeamScore =$this->post('secondTeamScore');

        //should check that any required fields are filled

        //post service
            $this->load->database();
            $info= array('firstTeamID'=>$firstTeamID, 'secondTeamID'=>$secondTeamID, 'firstTeamColours'=>$firstTeamColours, 'secondTeamColours'=>$secondTeamColours, 'pitch'=>$pitch, 'dateAndTime'=>$dateAndTime, 'LeagueID'=>$LeagueID, 'firstTeamScore'=>$firstTeamScore, 'secondTeamScore'=>$secondTeamScore);
            $this->db->insert('matches', $info);
            if ($this->db->affected_rows() === 1) {
                return $this->db->insert_id();
            }
            $this->response(200);
    }

}
?>