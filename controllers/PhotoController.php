<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';

class PhotoController extends Controller {

    private $photoModel;

    public function __construct() {
        $this->photoModel = new Photo();
    }

    // عرض الصور والإحصائيات في الصفحة الرئيسية
    public function index() {
        $photos = $this->photoModel->getAllPhotos();

        // جلب الأعداد الحقيقية بأمان من الـ Model
        $photosCount = $this->photoModel->getPhotosCount();
        $usersCount = $this->photoModel->getUsersCount();
        $commentsCount = $this->photoModel->getCommentsCount();

        $this->view('photos/index', [
            'photos' => $photos,
            'photosCount' => $photosCount,
            'usersCount' => $usersCount,
            'commentsCount' => $commentsCount
        ]);
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

    // معالجة عملية رفع الصورة
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

    // عرض تفاصيل صورة واحدة مع التعليقات
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

        require_once __DIR__ . '/../models/Comment.php';
        $commentModel = new Comment();
        $comments = $commentModel->getCommentsByPhotoId($id);

        $this->view('photos/show', ['photo' => $photo, 'comments' => $comments]);
    }

    // حذف الصورة
    public function delete() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /alzikrayat/public/login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $photo = $this->photoModel->getPhotoById($id);
            if ($photo) {
                $filePath = __DIR__ . '/../public/images/uploads/' . $photo['file_name'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $this->photoModel->deletePhoto($id);
            }
        }
        header('Location: /alzikrayat/public/');
        exit;
    }
}