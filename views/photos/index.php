<?php require_once __DIR__ . '/../layout/header.php'; ?>

<!-- القسم الترحيبي البسيط والفاخر -->
<div class="bg-white p-5 mb-5 rounded-4 shadow-sm border border-light text-center">
    <div class="container" style="max-width: 700px;">
        <h1 class="fw-bold text-dark mb-3">مرحباً بك في الذكريات 📸</h1>
        <p class="text-muted fs-5 mb-4" style="font-weight: 300;">
            مساحتك الهادئة لحفظ صورك الشخصية، توثيق أجمل لحظاتك، ومشاركتها بكل سلاسة وأمان.
        </p>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="d-flex justify-content-center gap-2">
                <a href="/alzikrayat/public/login" class="btn btn-dark px-4 fw-semibold">تسجيل الدخول</a>
                <a href="/alzikrayat/public/register" class="btn btn-outline-dark px-4 fw-semibold">حساب جديد</a>
            </div>
        <?php else: ?>
            <div>
                <a href="/alzikrayat/public/photo/upload" class="btn btn-primary px-4 fw-semibold">➕ رفع ذكرى جديدة</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- عنوان المعرض -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark mb-0">أحدث الذكريات</h4>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/alzikrayat/public/photo/upload" class="btn btn-outline-dark btn-sm fw-semibold">إضافة صورة</a>
    <?php endif; ?>
</div>

<!-- شبكة عرض الصور -->
<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    <?php if (!empty($photos)): ?>
        <?php foreach ($photos as $photo): ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="/alzikrayat/public/images/uploads/<?php echo htmlspecialchars($photo['file_name']); ?>" class="card-img-top" alt="صورة ذكرى" style="height: 240px; object-fit: cover;">
                    <div class="card-body p-4 bg-white">
                        <h5 class="card-title fw-bold text-dark mb-2"><?php echo htmlspecialchars($photo['title']); ?></h5>
                        <p class="card-text text-muted small mb-3"><?php echo mb_substr(htmlspecialchars($photo['description']), 0, 80); ?>...</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">بواسطة: <?php echo htmlspecialchars($photo['first_name'] ?? 'مستخدم'); ?></small>
                            <a href="/alzikrayat/public/photo/show?id=<?php echo $photo['id']; ?>" class="btn btn-sm btn-dark rounded-pill px-3">التفاصيل</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm border border-light">
            <p class="text-muted mb-0">لا توجد صور متاحة حالياً. كن أول من يشارك لحظاته!</p>
        </div>
    <?php endif; ?>
</div>

<!-- قسم "من نحن" المبسط والراقي -->
<section id="about-us" class="bg-white p-5 rounded-4 shadow-sm border border-light mb-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            <h4 class="fw-bold text-dark mb-3">عن منصة الذكريات</h4>
            <p class="text-secondary lh-lg mb-0" style="font-weight: 300;">
                منصة رقمية مصممة بعناية فائقة لتوفير بيئة نظيفة وآمنة للاحتفاظ بالصور والذكريات الشخصية. نؤمن بأن البساطة والأمان هما اساس التجربة الممتعة، لذا حرصنا على تقديم تصميم سلس وخالٍ من التعقيد.
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>