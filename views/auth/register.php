<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - الذكريات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4">
            <h2 class="text-center mb-4 text-primary">إنشاء حساب جديد</h2>
            <form action="/alzikrayat/public/register/store" method="POST">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">الاسم الأول</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col">
                        <label class="form-label">اسم العائلة</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">المدينة / الموقع (اختياري)</label>
                    <input type="text" name="location" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">المهنة (اختياري)</label>
                    <input type="text" name="occupation" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">تسجيل الحساب</button>
            </form>
            <div class="text-center mt-3">
                <a href="/alzikrayat/public/login">لديك حساب بالفعل؟ تسجيل الدخول</a>
            </div>
        </div>
    </div>
</body>
</html>