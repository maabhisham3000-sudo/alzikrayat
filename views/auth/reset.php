<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container my-5" style="max-width: 500px;">
    <div class="card shadow-sm p-4">
        <h3 class="text-center text-primary mb-4">تعيين كلمة مرور جديدة</h3>
        
        <form action="/alzikrayat/public/reset/submit" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label class="form-label">كلمة المرور الجديدة</label>
                <input type="password" name="password" class="form-control" required placeholder="أدخل كلمة المرور الجديدة">
            </div>
            <button type="submit" class="btn btn-success w-100">حفظ كلمة المرور</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>