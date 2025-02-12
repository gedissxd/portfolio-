<?php

class Reminder
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllReminders()
    {
        $result = $this->db->getConnection()->query(
            "SELECT * FROM personreminder"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}