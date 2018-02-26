<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Tournaments_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('tournaments')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('tournaments')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($tournament, $tournamentName, $startDate, $endDate, $location, $teamIDs, $leagues, $matches)
    {
        $this->db->set($this->_setTournament($tournament, $tournamentName, $startDate, $endDate, $location, $teamIDs, $leagues, $matches))->insert('tournaments');
        return null;
    }

    public function update($tournamentName, $startDate, $endDate, $location, $teamIDs, $leagues, $matches)
    {
        $id = $tournamentName['id']; //not sure whether this is correct
        $this->db->set($this->_setTournament($tournamentName, $startDate, $endDate, $location, $teamIDs, $leagues, $matches))->where('id', $id)->update('tournaments');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('tournaments');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }


    private function _setTournament($tournamentName, $startDate, $endDate, $location, $teamIDs, $leagues, $matches)
    {
        return array(
            'id' => "", //not sure whether this is the correct way of passing null
            'tournamentName' => $tournamentName['tournamentName'],
            'startDate' => $startDate['startDate'],
            'endDate' => $endDate['endDate'],
            'location' => $location['location'],
            'teamIDs' => $teamIDs['teamIDs'],
            'leagues' => $leagues['leagues'],
            'matches' => $matches['matches']
        );
    }
}