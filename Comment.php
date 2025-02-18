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

    public function getCommentsByPage($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;

        // Get total count
        $countResult = $this->db->getConnection()->query("SELECT COUNT(*) as total FROM komentaras");
        $totalComments = $countResult->fetch_assoc()['total'];

        // Get paginated comments
        $result = $this->db->getConnection()->query(
            "SELECT * FROM komentaras ORDER BY created_at DESC LIMIT $perPage OFFSET $offset"
        );

        return [
            'comments' => $result->fetch_all(MYSQLI_ASSOC),
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_items' => $totalComments,
                'total_pages' => ceil($totalComments / $perPage),
                'has_next' => ($page * $perPage) < $totalComments,
                'has_previous' => $page > 1
            ]
        ];
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