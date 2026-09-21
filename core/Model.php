<?php
/**
 * Base Model Class
 * Handles database connection using PDO for all models.
 */
class Model {
    protected $db;

    public function __construct() {
        // استخدام اتصال قاعدة البيانات المعرف مسبقاً في مشروعنا
        global $pdo;
        if (isset($pdo)) {
            $this->db = $pdo;
        } else {
            // اتصال احتياطي في حال لم يتم استدعاء ملف الـ database مسبقاً
            try {
                $this->db = new PDO("mysql:host=localhost;port=3307;dbname=alzikrayat_db;charset=utf8mb4", "root", "");
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
            }
        }
    }
}