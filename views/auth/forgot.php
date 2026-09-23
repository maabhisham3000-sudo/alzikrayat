<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container my-5" style="max-width: 500px;">
    <div class="card shadow-sm p-4">
        <h3 class="text-center text-primary mb-4">استعادة كلمة المرور</h3>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="/alzikrayat/public/forgot/submit" method="POST">
            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني المسجل</label>
                <input type="email" name="email" class="form-control" required placeholder="أدخل بريدك الإلكتروني">
            </div>
            <button type="submit" class="btn btn-primary w-100">إرسال رابط الاستعادة</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="/alzikrayat/public/login" class="text-decoration-none">العودة لتسجيل الدخول</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>