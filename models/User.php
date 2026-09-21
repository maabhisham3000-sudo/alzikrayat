<?php
require_once __DIR__ . '/../core/Model.php';

class User extends Model {
    
    /**
     * تسجيل مستخدم جديد في قاعدة البيانات
     * @param array $data
     * @return bool
     */
    public function register($data) {
        $query = "INSERT INTO users (first_name, last_name, email, password) 
                  VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    /**
     * البحث عن المستخدم بواسطة البريد الإلكتروني لتسجيل الدخول أو الاستعادة
     * @param string $email
     * @return array|false
     */
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * حفظ رمز استعادة كلمة المرور ووقت انتهائه
     * @param string $email
     * @param string $token
     * @param string $expiresAt
     * @return bool
     */
    public function setPasswordResetToken($email, $token, $expiresAt) {
        $query = "UPDATE users SET reset_token = :token, reset_expires_at = :expires WHERE email = :email";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'token' => $token,
            'expires' => $expiresAt,
            'email' => $email
        ]);
    }

    /**
     * التحقق من صلاحية رمز الاستعادة
     * @param string $token
     * @return array|false
     */
    public function getUserByResetToken($token) {
        $query = "SELECT * FROM users WHERE reset_token = :token AND reset_expires_at > NOW()";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * تحديث كلمة المرور وحذف رمز الاستعادة بعد إتمامها
     * @param int $userId
     * @param string $newPasswordHash
     * @return bool
     */
    public function updatePasswordAndClearToken($userId, $newPasswordHash) {
        $query = "UPDATE users SET password = :password, reset_token = NULL, reset_expires_at = NULL WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'password' => $newPasswordHash,
            'id' => $userId
        ]);
    }
}