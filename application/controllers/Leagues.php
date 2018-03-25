<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Leagues extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Leagues_model');
    }
    public function index_get()
    {
        $leagues = $this->Leagues_model->get();
        if (!is_null($leagues)) {
            $this->response(array('response' => $leagues), 200);
        } else {
            $this->response(array('error' => 'There arent any leagues'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $league = $this->Leagues_model->get($id);
        if (!is_null($league)) {
            $this->response(array('response' => $league), 200);
        } else {
            $this->response(array('error' => 'league not found'), 404);
        }
    }
    public function index_post() //users/teamUpdate, have a different function name
    {
        if (!$this->post('league')) {
            $this->response(null, 400);
        }
        $id = $this->Leagues_model->save($this->post('league'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('league')) {
            $this->response(null, 400);

        }

        //at the moment, it is only using 'save' because 'update' function is not working- need to add checks to see which
        //fields need changing and then only update those fields
        //now simply creates a new user each time put is called
        $update = $this->Leagues_model->save($this->put('league'));
        if (!is_null($update)) {
            $this->response(array('response' => 'league created!'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);

        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->Leagues_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'league deleted'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
}