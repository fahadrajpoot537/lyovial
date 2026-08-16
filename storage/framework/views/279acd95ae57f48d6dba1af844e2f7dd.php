<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="<?php echo e(route('home')); ?>" class="d-inline-block mb-3">
                    <img
                        src="<?php echo e(asset('assets/front/images/lyovial-home/logo-white.png')); ?>"
                        alt="<?php echo e($siteName); ?>"
                        class="footer-logo"
                        style="filter:brightness(0) invert(1) opacity(.95);height:36px;width:auto"
                    >
                </a>
                <p class="footer-text mb-3">Pilot-scale vial lyophilization for diagnostics, reagents, and research across Canada.</p>
                <p class="footer-text mb-1"><i class="bi bi-geo-alt me-2"></i><?php echo nl2br(e($siteAddress)); ?></p>
                <?php if($sitePhone): ?><p class="footer-text mb-1"><i class="bi bi-telephone me-2"></i><a href="tel:<?php echo e(preg_replace('/\D+/', '', $sitePhone)); ?>"><?php echo e($sitePhone); ?></a></p><?php endif; ?>
                <?php if($siteEmail): ?><p class="footer-text mb-0"><i class="bi bi-envelope me-2"></i><a href="mailto:<?php echo e($siteEmail); ?>"><?php echo e($siteEmail); ?></a></p><?php endif; ?>
            </div>
            <div class="col-6 col-lg-2">
                <h4 class="h6 text-uppercase mb-3">Explore</h4>
                <ul class="list-unstyled footer-links">
                    <?php $__currentLoopData = $footerMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(str_contains(strtolower($item->title), 'capabilities') || str_contains(strtolower($item->title), 'services')) continue; ?>
                        <li><a href="<?php echo e($item->resolved_url); ?>"><?php echo e($item->title); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h4 class="h6 text-uppercase mb-3">Capabilities</h4>
                <ul class="list-unstyled footer-links">
                    <?php $__currentLoopData = $navServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(url('/capabilities/'.$service->slug)); ?>"><?php echo e($service->title); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="col-lg-3">
                <h4 class="h6 text-uppercase mb-3">Ready to talk?</h4>
                <p class="footer-text">Share your product goals and our Kanata team will help map the next step.</p>
                <a href="<?php echo e(route('contact')); ?>" class="btn btn-brand">Contact LyoVial</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container py-3 d-flex flex-column flex-md-row justify-content-between gap-2 small">
            <span><?php echo e($siteCopyright); ?></span>
        </div>
    </div>
</footer>
<?php /**PATH C:\xampp\htdocs\liovine\resources\views/front/partials/footer.blade.php ENDPATH**/ ?>