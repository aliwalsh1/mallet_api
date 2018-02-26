<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('users')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('users')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($user)
    {
        $this->db->set($this->_setUser($user))->insert('users');
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($user)
    {
        $id = $user['id'];
        $this->db->set($this->_setUser($user))->where('id', $id)->update('users');
        if ($this->db->affected_rows() === 1) { //id wasnt matching anything in table, so affected rows = 0
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('users');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }


    private function _setUser($user)
    {
        return array(
            'username' => $user['username'],
            'title' => $user['title'],
            'first' => $user['first'],
            'last' => $user['last'],
            'gender' => $user['gender'],
            'email' => $user['email'],
            'handicap' => $user['handicap'],
            'ip' => $user['ip'],
            'currentPlayer' => $user['currentPlayer'],
            '_password' => $user['_password'],
            'teamIDs' => $user['teamIDs']
        );
    }
}