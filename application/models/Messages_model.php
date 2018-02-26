<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Messages_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('messages')->where('id', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return null;
        }
        $query = $this->db->select('*')->from('messages')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }


    public function save($message)
    {
        $this->db->set($this->_setMessage($message))->insert('messages');
        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($message)
    {
        $id = $message['id'];
        $this->db->set($this->_setMessage($message))->where('id', $id)->update('messages');
        if ($this->db->affected_rows() === 1) { //id wasnt matching anything in table, so affected rows = 0
            return true;
        }
        return null;
    }


    public function delete($id)
    {
        $this->db->where('id', $id)->delete('messages');
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return null;
    }



    private function _setMessage($message)
    {
        return array(
            'senderID' => $message['senderID'],
            'recipientID' => null,
            'subject' => $message['subject'],
            'body' => $message['body'],
            'uploadID' => null,
            'time_stamp' => $message['time_stamp']
        );
    }
}