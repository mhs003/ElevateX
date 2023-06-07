<?php
namespace Module;

class Model
{
    public $db = null;
    public bool $connected = false;

    public function __construct()
    {

    }

    public function connect(): bool
    {
        $cdb = \Config::getDb();
        $this->db = new \mysqli($cdb['host'], $cdb['user'], $cdb['pass'], $cdb['name']);
        $this->connected = ((bool) $this->db->connect_errno) ? false : true;

        return $this->connected;
    }

    public function disconnect(): void
    {
        $this->db->close();
    }

    public function isConnected() {
        return $this->connected;
    }

    public function getError()
    {
        if (array_key_exists('error', (array) $this->db) && !empty($this->db->error)) {
            return $this->db->error;
        } else {
            return $this->db->connect_error;
        }
    }
}