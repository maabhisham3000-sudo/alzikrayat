<?php
/**
 * Base Controller Class
 * Handles rendering views and passing data to them.
 */
class Controller {

    // دالة استدعاء واجهات العرض (Views)
    public function view($view, $data = []) {
        // استخراج البيانات لتحويلها إلى متغيرات داخل الـ View
        if (!empty($data)) {
            extract($data);
        }

        // تحديد مسار ملف العرض
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View not found: $view");
        }
    }
}