<?php
use Module\Model;

class User extends Model
{
    function __construct()
    {
        $this->db->connect();
    }

    public function create($name, $email, $pass)
    {
        $query = sprintf("INSERT INTO users (name, email, pass) VALUES ('%s', '%s', '%s')", $this->db->real_escape_string($name), $this->db->real_escape_string($email), $this->db->real_escape_string(md5($pass)));
        $result = $this->db->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}