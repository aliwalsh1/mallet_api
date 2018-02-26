<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

class Users extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }
    public function index_get()
    {
        $users = $this->users_model->get();
        if (!is_null($users)) {
            $this->response(array('response' => $users), 200);
        } else {
            $this->response(array('error' => 'There arent any users'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $user = $this->users_model->get($id);
        if (!is_null($user)) {
            $this->response(array('response' => $user), 200);
        } else {
            $this->response(array('error' => 'user not found'), 404);
        }
    }
    public function index_post() //users/teamUpdate, have a different function name
    {
        if (!$this->post('user')) {
            $this->response(null, 400);
        }
        $id = $this->users_model->save($this->post('user'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('user')) {
            $this->response(null, 400);

        }

        //at the moment, it is only using 'save' because 'update' function is not working- need to add checks to see which
        //fields need changing and then only update those fields
        //now simply creates a new user each time put is called
        $update = $this->users_model->save($this->put('user'));
        if (!is_null($update)) {
            $this->response(array('response' => 'user made!'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);

        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->users_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'user deleted'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
}