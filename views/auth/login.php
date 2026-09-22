<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - الذكريات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 450px;">
        <div class="card shadow-sm p-4">
            <h2 class="text-center mb-4 text-primary">تسجيل الدخول</h2>
            
            <!-- عرض كوكي آخر تسجيل دخول حسب متطلبات المشروع -->
            <?php if (!empty($lastLogin)): ?>
                <div class="alert alert-info text-center py-2" style="font-size: 0.9rem;">
                    آخر دخول من هذا الجهاز: <br><strong><?php echo htmlspecialchars($lastLogin); ?></strong>
                </div>
            <?php endif; ?>

            <form action="/alzikrayat/public/login/submit" method="POST">
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">دخول</button>
            </form>

            <!-- روابط إضافية (إنشاء حساب + نسيت كلمة المرور) -->
            <div class="text-center mt-3">
                <a href="/alzikrayat/public/register" class="d-block mb-2 text-decoration-none">ليس لديك حساب؟ إنشاء حساب جديد</a>
                <a href="/alzikrayat/public/forgot" class="text-muted small text-decoration-none">هل نسيت كلمة المرور؟</a>
            </div>
        </div>
    </div>
</body>
</html>