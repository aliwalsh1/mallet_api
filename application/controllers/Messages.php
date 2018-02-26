<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

//need to change all variables so that it suits user data

class Messages extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Messages_model');
    }
    public function index_get()
    {
        $messages = $this->Messages_model->get();
        if (!is_null($messages)) {
            $this->response(array('response' => $messages), 200);
        } else {
            $this->response(array('error' => 'There arent any users'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $message = $this->Messages_model->get($id);
        if (!is_null($message)) {
            $this->response(array('response' => $message), 200);
        } else {
            $this->response(array('error' => 'message not found'), 404);
        }
    }
    public function index_post()
    {
        if (!$this->post('message')) {
            $this->response(null, 400);
        }
        $id = $this->Messages_model->save($this->post('message'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('message')) {
            $this->response(null, 400);
        }
        //at the moment, it is only using 'save' because 'update' function is not working- need to add checks to see which
        //fields need changing and then only update those fields
        //now simply creates a new message each time put is called
        $update = $this->Messages_model->save($this->put('message'));
        if (!is_null($update)) {
            $this->response(array('response' => 'message created!'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->Messages_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'message deleted'), 200);
        } else {
            $this->response(array('error', 'something is broken'), 400);
        }
    }
}