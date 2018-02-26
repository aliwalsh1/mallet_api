<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Teams_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('teams')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('teams')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($team)
    {
        $this->db->set($this->_setTeam($team))->insert('teams');
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($team)
    {
        $id = $team['id'];
        $this->db->set($this->_setTeam($team))->where('id', $id)->update('teams');
        if ($this->db->affected_rows() === 1) { //id wasnt matching anything in table, so affected rows = 0
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('teams');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }


    private function _setTeam($team)
    {
        return array(
            'teamName' => $team['teamName'],
            'level' => $team['level'],
            'colours' => $team['colours'],
            'tournIDs' => $team['tournIDs']
        );
    }
}