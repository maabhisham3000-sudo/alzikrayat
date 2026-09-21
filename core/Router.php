<?php
/**
 * Router Class
 * Handles mapping URL requests to appropriate controllers and actions.
 */
class Router {
    private $routes = [];

    // إضافة مسار جديد للجدول
    public function add($method, $path, $handler) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => rtrim($path, '/'),
            'handler' => $handler
        ];
    }

    // استقبال الـ URL وتوجيهه للكونترولر المناسب
    public function dispatch($uri, $method) {
        // تنظيف الـ URI وإزالة العلامات الزائدة
        $currentUri = rtrim(parse_url($uri, PHP_URL_PATH), '/');
        $currentMethod = strtoupper($method);

        foreach ($this->routes as $route) {
            // مطابقة المسار ونوع الطلب (GET أو POST)
            if ($route['path'] === $currentUri && $route['method'] === $currentMethod) {
                [$controllerName, $actionName] = $route['handler'];

                // التأكد من وجود ملف الكونترولر واستدعائه
                $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    if (class_exists($controllerName)) {
                        $controller = new $controllerName();
                        if (method_exists($controller, $actionName)) {
                            return $controller->$actionName();
                        }
                    }
                }
                echo "Controller or Method not found: $controllerName->$actionName";
                return;
            }
        }

        // إذا لم يتم العثور على المسار
        http_response_code(404);
        echo "<h2 style='text-align:center; margin-top:50px; font-family:Tahoma;'>404 - الصفحة غير موجودة</h2>";
    }
}