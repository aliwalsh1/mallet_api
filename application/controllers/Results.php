<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Results extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Results_model');
    }
    public function index_get()
    {
        $results = $this->Results_model->get();
        if (!is_null($results)) {
            $this->response(array('response' => $results), 200);
        } else {
            $this->response(array('error' => 'There arent any results'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $result = $this->Results_model->get($id);
        if (!is_null($result)) {
            $this->response(array('response' => $result), 200);
        } else {
            $this->response(array('error' => 'result not found'), 404);
        }
    }
    public function index_post()
    {
        if (!$this->post('result')) {
            $this->response(null, 400);
        }
        $id = $this->Results_model->save($this->post('result'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('result')) {
            $this->response(null, 400);
        }
        //at the moment, it is only using 'save' because 'update' function is not working- need to add checks to see which
        //fields need changing and then only update those fields
        //now simply creates a new message each time put is called
        $update = $this->Results_model->save($this->put('result'));
        if (!is_null($update)) {
            $this->response(array('response' => 'result created!'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->Results_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'result deleted'), 200);
        } else {
            $this->response(array('error', 'something is broken'), 400);
        }
    }
}