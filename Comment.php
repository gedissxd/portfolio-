<?php

class Comment
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllComments()
    {
        $result = $this->db->getConnection()->query(
            "SELECT * FROM komentaras ORDER BY created_at DESC"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function saveComment($data)
    {
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO komentaras (name, email, comment, parent_id) 
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssi",
            $data['name'],
            $data['email'],
            $data['comment'],
            $data['parent_id']
        );

        return $stmt->execute();
    }
}