<?php
/**
 * Front Controller for Alzikrayat Application
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();

// مسارات المعرض الرئيسي
$router->add('GET', '/alzikrayat/public/', ['PhotoController', 'index']);

// مسارات رفع الصور والذكريات وتفاصيلها وحذفها
$router->add('GET', '/alzikrayat/public/photo/upload', ['PhotoController', 'showUpload']);
$router->add('POST', '/alzikrayat/public/photo/store', ['PhotoController', 'store']);
$router->add('GET', '/alzikrayat/public/photo/show', ['PhotoController', 'show']);
$router->add('GET', '/alzikrayat/public/photo/delete', ['PhotoController', 'delete']);

// مسار حفظ تعليق جديد
$router->add('POST', '/alzikrayat/public/comment/store', ['CommentController', 'store']);

// مسارات المصادقة
$router->add('GET', '/alzikrayat/public/register', ['AuthController', 'showRegister']);
$router->add('POST', '/alzikrayat/public/register/store', ['AuthController', 'register']);

$router->add('GET', '/alzikrayat/public/login', ['AuthController', 'showLogin']);
$router->add('POST', '/alzikrayat/public/login/submit', ['AuthController', 'login']);

$router->add('GET', '/alzikrayat/public/logout', ['AuthController', 'logout']);

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->add('GET', '/alzikrayat/public/forgot', ['AuthController', 'showForgot']);
$router->add('POST', '/alzikrayat/public/forgot/submit', ['AuthController', 'handleForgot']);
$router->add('GET', '/alzikrayat/public/reset', ['AuthController', 'showReset']);
$router->add('POST', '/alzikrayat/public/reset/submit', ['AuthController', 'handleReset']);
// تشغيل الراوتر (يجب أن يكون دائماً في آخر الملف بعد تعريف جميع المسارات بدون استثناء)
$router->dispatch($uri, $method);