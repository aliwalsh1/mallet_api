<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Matches extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Matches_model');
    }
    public function index_get()
    {
        $matches = $this->Matches_model->get();
        if (!is_null($matches)) {
            $this->response(array('response' => $matches), 200);
        } else {
            $this->response(array('error' => 'There arent any matches'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $match = $this->Matches_model->get($id);
        if (!is_null($match)) {
            $this->response(array('response' => $match), 200);
        } else {
            $this->response(array('error' => 'match not found'), 404);
        }
    }
    public function index_post() //users/teamUpdate, have a different function name
    {
        if (!$this->post('match')) {
            $this->response(null, 400);
        }
        $id = $this->Matches_model->save($this->post('match'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('match')) {
            $this->response(null, 400);

        }

        //at the moment, it is only using 'save' because 'update' function is not working- need to add checks to see which
        //fields need changing and then only update those fields
        //now simply creates a new user each time put is called
        $update = $this->Matches_model->save($this->put('match'));
        if (!is_null($update)) {
            $this->response(array('response' => 'Match created!'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);

        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->Matches_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'match deleted'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
}