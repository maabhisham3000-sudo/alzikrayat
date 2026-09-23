<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفع ذكرى جديدة - تطبيق الذكريات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4">
            <h2 class="text-center mb-4 text-primary">رفع صورة جديدة لمعرض الذكريات</h2>
            
            <!-- توجيه الفورم إلى مسار الـ store الخاص بالصور -->
            <form action="/alzikrayat/public/photo/store" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">عنوان الصورة</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">وصف الذكرى (اختياري)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">اختر الصورة</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">نشر الصورة في المعرض</button>
            </form>

            <div class="text-center mt-3">
                <a href="/alzikrayat/public/" class="text-decoration-none">العودة إلى المعرض الرئيسي</a>
            </div>
        </div>
    </div>
</body>
</html>