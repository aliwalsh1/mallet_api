<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Results_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('results')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('results')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($result)
    {
        $this->db->set($this->_setResult($result))->insert('results');
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($result)
    {
        $id = $result['id'];
        $this->db->set($this->_setResult($result))->where('id', $id)->update('results');
        if ($this->db->affected_rows() === 1) { //id wasnt matching anything in table, so affected rows = 0
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('results');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }



    private function _setResult($result)
    {
        return array(
            'firstTeamID' => $result['firstTeamID'],
            'secondTeamID' => $result['secondTeamID'],
            'firstTeamResult' => $result['firstTeamResult'],
            'secondTeamResult' => $result['secondTeamResult']
        );
    }
}