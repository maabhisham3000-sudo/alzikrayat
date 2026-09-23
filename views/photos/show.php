<?php 
require_once __DIR__ . '/../layout/header.php'; 
?>

<div class="container my-5" style="max-width: 800px;">
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <h2 class="text-primary mb-3"><?php echo htmlspecialchars($photo['title'] ?? 'تفاصيل الصورة'); ?></h2>
            
            <!-- عرض الصورة المرفوعة -->
            <?php if (!empty($photo['file_name'])): ?>
                <img src="/alzikrayat/public/images/uploads/<?php echo htmlspecialchars($photo['file_name']); ?>" class="img-fluid rounded mb-3 shadow" style="max-height: 450px;" alt="صورة الذكرى">
            <?php endif; ?>

            <p class="text-muted fs-5"><?php echo htmlspecialchars($photo['description'] ?? 'لا يوجد وصف لهذه الذكرى.'); ?></p>
            
            <div class="text-muted small mb-4">
                تاريخ النشر: <?php echo htmlspecialchars($photo['date_time'] ?? ''); ?>
                <?php if (!empty($photo['first_name'])): ?>
                    <br>بواسطة: <strong><?php echo htmlspecialchars($photo['first_name'] . ' ' . ($photo['last_name'] ?? '')); ?></strong>
                <?php endif; ?>
            </div>

            <!-- أزرار التحكم (تظهر لصاحب الصورة فقط) -->
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $photo['user_id']): ?>
                <div class="mb-4 p-3 border rounded bg-light d-flex justify-content-center gap-2">
                    <a href="/alzikrayat/public/photo/delete?id=<?php echo $photo['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه الذكرى؟');">
                       🗑️ حذف الذكرى
                    </a>
                </div>
            <?php endif; ?>

            <div>
                <a href="/alzikrayat/public/" class="btn btn-outline-primary">العودة إلى المعرض الرئيسي</a>
            </div>
        </div>
    </div>

    <!-- قسم التعليقات -->
    <div class="card shadow-sm p-4">
        <h4 class="mb-3 text-secondary">التعليقات (<?php echo count($comments ?? []); ?>)</h4>

        <!-- نموذج إضافة تعليق جديد (متاح للمستخدمين المسجلين) -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="/alzikrayat/public/comment/store" method="POST" class="mb-4">
                <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                <div class="mb-3">
                    <textarea name="comment" class="form-control" rows="3" placeholder="اكتب تعليقاً على هذه الذكرى..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">إرسال التعليق</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                يرجى <a href="/alzikrayat/public/login">تسجيل الدخول</a> لتمكنك من كتابة تعليق.
            </div>
        <?php endif; ?>

        <!-- قائمة عرض التعليقات -->
        <hr>
        <div class="comments-list">
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $com): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong><?php echo htmlspecialchars($com['first_name'] . ' ' . $com['last_name']); ?></strong>
                            <small class="text-muted"><?php echo htmlspecialchars($com['date_time']); ?></small>
                        </div>
                        <p class="mt-2 mb-0 text-dark"><?php echo nl2br(htmlspecialchars($com['comment'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-center">لا توجد تعليقات حتى الآن. كن أول من يعلق!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
require_once __DIR__ . '/../layout/footer.php'; 
?>