<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Leagues_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('leagues')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('leagues')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($league)
    {
        $this->db->set($this->_setLeague($league))->insert('leagues');
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($league)
    {
        $id = $league['id'];
        $this->db->set($this->_setLeague($league))->where('id', $id)->update('leagues');
        if ($this->db->affected_rows() === 1) { //id wasnt matching anything in table, so affected rows = 0
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('leagues');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }

    private function _setLeague($league)
    {
        return array(
            'leagueName' => $league['leagueName']
        );
    }
}