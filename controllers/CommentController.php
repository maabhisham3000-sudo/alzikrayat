<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController extends Controller {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    /**
     * معالجة وحفظ تعليق جديد
     */
    public function store() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $photoId = $_POST['photo_id'] ?? null;
            $commentText = trim($_POST['comment'] ?? '');
            $userId = $_SESSION['user_id'];

            if ($photoId && !empty($commentText)) {
                $this->commentModel->addComment($photoId, $userId, $commentText);
            }

            // العودة إلى صفحة تفاصيل الصورة نفسها بعد إضافة التعليق
            header("Location: /alzikrayat/public/photo/show?id=" . $photoId);
            exit;
        }
    }
}