<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

/**
 * AuthController
 * Handles user registration, login authentication, sessions, and cookies.
 */
class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * عرض صفحة التسجيل
     */
    public function showRegister() {
        $this->view('auth/register');
    }

    /**
     * معالجة بيانات التسجيل المرسلة من النموذج
     */
   public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // 1. التحقق من جهة الخادم (Server-side Validation)
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                echo "<script>alert('جميع الحقول إجبارية!'); window.history.back();</script>";
                return;
            }

            // التحقق من صحة البريد الإلكتروني عبر فلتر PHP المعتمد
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('صيغة البريد الإلكتروني غير صحيحة!'); window.history.back();</script>";
                return;
            }

            // التحقق من طول كلمة المرور (أقل شيء 6 أحرف)
            if (strlen($password) < 6) {
                echo "<script>alert('كلمة المرور يجب أن تكون 6 أحرف على الأقل!'); window.history.back();</script>";
                return;
            }

            try {
                $userModel = new User();
                $userModel->register([
                    'first_name' => htmlspecialchars($firstName),
                    'last_name' => htmlspecialchars($lastName),
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT)
                ]);
                
                header('Location: /alzikrayat/public/login');
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    echo "<script>alert('هذا البريد الإلكتروني مستخدم مسبقاً، يرجى استخدام بريد آخر.'); window.history.back();</script>";
                } else {
                    echo "حدث خطأ في النظام: " . $e->getMessage();
                }
            }
        }
    }
    /**
     * عرض صفحة تسجيل الدخول مع جلب الكوكي الخاص بآخر تسجيل دخول
     */
    public function showLogin() {
        $lastLogin = $_COOKIE['last_login'] ?? 'لا يوجد تسجيل دخول سابق من هذا المتصفح';
        $this->view('auth/login', ['lastLogin' => $lastLogin]);
    }

    /**
     * معالجة تسجيل الدخول والتحقق من كلمة المرور وإنشاء الجلسة والكوكي
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // التصحيح هنا: استخدام getUserByEmail بدلاً من findByEmail لتجنب الأخطاء
            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // بدء الجلسة وحفظ بيانات المستخدم
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];

                // إنشاء كوكي لآخر تسجيل دخول لمدة 7 أيام حسب متطلبات المشروع
                setcookie('last_login', date('Y-m-d H:i:s'), time() + (86400 * 7), "/");

                header('Location: /alzikrayat/public/');
                exit;
            } else {
                echo "<script>alert('البريد الإلكتروني أو كلمة المرور غير صحيحة!'); window.history.back();</script>";
            }
        }
    }

    /**
     * تسجيل الخروج وإنهاء الجلسة
     */
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /alzikrayat/public/login');
        exit;
    }

    /**
     * عرض صفحة إدخال البريد لنسيان كلمة المرور
     */
    public function showForgot() {
        $this->view('auth/forgot');
    }

    /**
     * توليد رمز استعادة كلمة المرور وعرض الرابط على الشاشة للاختبار المحلي
     */
    public function handleForgot() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $userModel = new User();
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                $token = bin2hex(random_bytes(32)); 
                $expiresAt = date('Y-m-d H:i:s', strtotime('+2 hours')); 
                
                $userModel->setPasswordResetToken($email, $token, $expiresAt);

                $resetLink = "http://localhost/alzikrayat/public/reset?token=" . $token;
                $message = "تم إنشاء رابط الاستعادة بنجاح: <br><a href='$resetLink' class='btn btn-sm btn-success mt-2'>اضغط هنا لإعادة تعيين كلمة المرور</a>";
                
                $this->view('auth/forgot', ['message' => $message]);
            } else {
                $this->view('auth/forgot', ['message' => 'البريد الإلكتروني غير مسجل لدينا.']);
            }
        }
    }

    /**
     * عرض صفحة إدخال كلمة المرور الجديدة
     */
    public function showReset() {
        $token = $_GET['token'] ?? '';
        $userModel = new User();
        $user = $userModel->getUserByResetToken($token);

        if (!$user) {
            echo "<div class='container mt-5 text-center text-danger'><h4>رابط الاستعادة غير صالح أو انتهت صلاحيته.</h4><a href='/alzikrayat/public/login'>العودة لتسجيل الدخول</a></div>";
            return;
        }

        $this->view('auth/reset', ['token' => $token]);
    }

    /**
     * تنفيذ تغيير كلمة المرور وحفظها في قاعدة البيانات
     */
    public function handleReset() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getUserByResetToken($token);

            if ($user) {
                $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
                $userModel->updatePasswordAndClearToken($user['id'], $newHash);
                
                header('Location: /alzikrayat/public/login?success=1');
                exit;
            } else {
                echo "حدث خطأ ما أو انتهت صلاحية الرابط.";
            }
        }
    }
}