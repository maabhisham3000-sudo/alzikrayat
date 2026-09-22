<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';

class PhotoController extends Controller {

    private $photoModel;

    public function __construct() {
        $this->photoModel = new Photo();
    }

    // عرض الصور في الصفحة الرئيسية (المعرض)
    public function index() {
        $photos = $this->photoModel->getAllPhotos();
        $this->view('photos/index', ['photos' => $photos]);
    }

    // عرض نموذج رفع صورة جديدة
    public function showUpload() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit;
        }
        $this->view('photos/create');
    }

    // معالجة عملية رفع الصورة وحفظها
    public function store() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $userId = $_SESSION['user_id'];

            $file = $_FILES['image'];
            $fileName = time() . '_' . basename($file['name']);
            
            // تم تعديل مسار الحفظ ليتطابق مع مجلد public/images/uploads/ لديك
            $targetDir = __DIR__ . '/../public/images/uploads/' . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetDir)) {
                $this->photoModel->uploadPhoto($userId, $title, $description, $fileName);
                header('Location: /alzikrayat/public/');
                exit;
            } else {
                echo "فشل في رفع الصورة، حاول مرة أخرى.";
            }
        }
    }

    // عرض تفاصيل صورة واحدة بناءً على الـ ID
    // عرض تفاصيل صورة واحدة مع التعليقات الخاصة بها
    public function show() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /alzikrayat/public/');
            exit;
        }

        $photo = $this->photoModel->getPhotoById($id);

        if (!$photo) {
            echo "الصورة غير موجودة.";
            return;
        }

        // جلب التعليقات الخاصة بهذه الصورة
        require_once __DIR__ . '/../models/Comment.php';
        $commentModel = new Comment();
        $comments = $commentModel->getCommentsByPhotoId($id);

        // تمرير الصورة والتعليقات لعرضها في الـ View
        $this->view('photos/show', ['photo' => $photo, 'comments' => $comments]);
    }
    // حذف الصورة (يُفضل التأكد أن صاحب الصورة هو من يحذفها)
    public function delete() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            // جلب اسم الملف لحذفه من المجلد أيضاً (اختياري واحترافي)
            $photo = $this->photoModel->getPhotoById($id);
            if ($photo) {
                $filePath = __DIR__ . '/../public/images/uploads/' . $photo['file_name'];
                if (file_exists($filePath)) {
                    unlink($filePath); // حذف الملف من الفولدر
                }
                $this->photoModel->deletePhoto($id); // حذف السجل من القاعدة
            }
        }
        header('Location: /alzikrayat/public/');
        exit;
    }
}