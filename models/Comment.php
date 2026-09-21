<?php
require_once __DIR__ . '/../core/Model.php';

class Comment extends Model {
    
    /**
     * جلب جميع التعليقات الخاصة بصورة معينة مع بيانات المستخدم
     * @param int $photoId
     * @return array
     */
    public function getCommentsByPhotoId($photoId) {
        $query = "SELECT comments.*, users.first_name, users.last_name 
                  FROM comments 
                  JOIN users ON comments.user_id = users.id 
                  WHERE comments.photo_id = :photo_id 
                  ORDER BY comments.date_time DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['photo_id' => $photoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * إضافة تعليق جديد على صورة
     * @param int $photoId
     * @param int $userId
     * @param string $commentText
     * @return bool
     */
    public function addComment($photoId, $userId, $commentText) {
        $query = "INSERT INTO comments (photo_id, user_id, comment) VALUES (:photo_id, :user_id, :comment)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'photo_id' => $photoId,
            'user_id' => $userId,
            'comment' => $commentText
        ]);
    }
}