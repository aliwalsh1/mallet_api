<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Teams extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('teams_model');
    }
    public function index_get()
    {
        $teams = $this->teams_model->get();
        if (!is_null($teams)) {
            $this->response(array('response' => $teams), 200);
        } else {
            $this->response(array('error' => 'There arent any teams'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $team = $this->teams_model->get($id);
        if (!is_null($team)) {
            $this->response(array('response' => $team), 200);
        } else {
            $this->response(array('error' => 'team not found'), 404);
        }
    }
    public function index_post() //users/teamUpdate, have a different function name
    {
        if (!$this->post('team')) {
            $this->response(null, 400);
        }
        $id = $this->teams_model->save($this->post('team'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('team')) {
            echo("first");
            $this->response(null, 400);

        }
        //at the moment, it is only using 'save' because 'update' function is not working- need to add checks to see which
        //fields need changing and then only update those fields
        //now simply creates a new team each time put is called
        $update = $this->teams_model->save($this->put('team'));
        if (!is_null($update)) {
            $this->response(array('response' => 'team made!'), 200);
        } else {
            echo("second");
            $this->response(array('error', 'something has happened to the server'), 400);

        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->teams_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'team deleted'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
}