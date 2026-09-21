<?php
require_once __DIR__ . '/../core/Model.php';

class Photo extends Model {
    
    // جلب كل الصور المرفوعة مع معلومات المستخدمين
    public function getAllPhotos() {
        $query = "SELECT photos.*, users.first_name, users.last_name 
                  FROM photos 
                  JOIN users ON photos.user_id = users.id 
                  ORDER BY photos.date_time DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // رفع وحفظ صورة جديدة في قاعدة البيانات
    public function uploadPhoto($userId, $title, $description, $fileName) {
        $query = "INSERT INTO photos (user_id, title, description, file_name) VALUES (:user_id, :title, :description, :file_name)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'file_name' => $fileName
        ]);
    }

    // جلب صورة واحدة بالـ ID مع معلومات المستخدم (أضيفت حديثاً)
    public function getPhotoById($id) {
        $query = "SELECT photos.*, users.first_name, users.last_name 
                  FROM photos 
                  JOIN users ON photos.user_id = users.id 
                  WHERE photos.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // حذف الصورة
    public function deletePhoto($id) {
        $query = "DELETE FROM photos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    // تحديث بيانات الصورة
    public function updatePhoto($id, $title, $description) {
        $query = "UPDATE photos SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description
        ]);
    }
}