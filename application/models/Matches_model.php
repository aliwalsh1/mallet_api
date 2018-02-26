<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Matches_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('matches')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('matches')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($match)
    {
        $this->db->set($this->_setMatch($match))->insert('matches');
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($match)
    {
        $id = $match['id'];
        $this->db->set($this->_setMatch($match))->where('id', $id)->update('matches');
        if ($this->db->affected_rows() === 1) { //id wasnt matching anything in table, so affected rows = 0
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('matches');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }

    private function _setMatch($match)
    {
        return array(
            'firstTeamID' => $match['firstTeamID'],
            'secondTeamID' => $match['secondTeamID'],
            'firstTeamColours' => $match['firstTeamColours'],
            'secondTeamColours' => $match['secondTeamColours'],
            'pitch' => $match['pitch'],
            'dateAndTime' => $match['dateAndTime'],
            'leagueID' => $match['leagueID'],
            'firstTeamScore' => $match['firstTeamScore'],
            'secondTeamScore' => $match['secondTeamScore']
        );
    }
}