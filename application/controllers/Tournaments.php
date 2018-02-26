<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';

//need to change all variables so that it suits user data

class Tournaments extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tournaments_model');
    }
    public function index_get()
    {
        $tournaments = $this->tournaments_model->get();
        if (!is_null($tournaments)) {
            $this->response(array('response' => $tournaments), 200);
        } else {
            $this->response(array('error' => 'There arent any users'), 404);
        }
    }
    public function find_get($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $tournament = $this->tournaments_model->get($id);
        if (!is_null($tournament)) {
            $this->response(array('response' => $tournament), 200);
        } else {
            $this->response(array('error' => 'Tournament not found'), 404);
        }
    }
    public function index_post()
    {
        if (!$this->post('tournament')) {
            $this->response(null, 400);
        }
        $id = $this->tournaments_model->save($this->post('tournament'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }

    public function index_put()
    {
        if (!$this->put('tournament')) {
            $this->response(null, 400);
        }
        $update = $this->tournaments_model->update($this->put('tournament'));
        if (!is_null($update)) {
            $this->response(array('response' => 'tournament made!'), 200);
        } else {
            $this->response(array('error', 'something has happened to the server'), 400);
        }
    }
    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }
        $delete = $this->tournaments_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array('response' => 'tournament deleted'), 200);
        } else {
            $this->response(array('error', 'something is broken'), 400);
        }
    }
}