<?php
    $phoneDisplay = $sitePhone ?: '(613) 614-8733';
    $navLogo = $siteLogo ? storage_url($siteLogo) : asset('assets/front/images/lyovial-home/logo-white.png');
    $transparent = $transparent ?? true;
?>
<header class="header lyovial-nav<?php echo e($transparent ? ' is-transparent' : ''); ?>" id="lyovialNav">
  <div class="container header-inner">
    <a href="<?php echo e(route('home')); ?>" class="logo">
      <img src="<?php echo e($navLogo); ?>" alt="<?php echo e($siteName); ?>" class="nav-logo-img" />
    </a>
    <nav class="header-nav" id="lyovialHeaderNav" aria-label="Main">
      <a href="<?php echo e(route('home')); ?>">Home</a>

      <div class="nav-dropdown">
        <button type="button" class="nav-drop-toggle" aria-expanded="false" data-nav-toggle>Capabilities</button>
        <div class="nav-drop-menu">
          <?php $__currentLoopData = $navServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(url('/capabilities/'.$service->slug)); ?>"><?php echo e($service->title); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <a href="<?php echo e(url('/industries')); ?>">Industries</a>
      <a href="<?php echo e(url('/quality-compliance')); ?>">Compliance</a>

      <div class="nav-dropdown">
        <button type="button" class="nav-drop-toggle" aria-expanded="false" data-nav-toggle>Media</button>
        <div class="nav-drop-menu">
          <a href="<?php echo e(url('/specimen-library-preservation')); ?>">Specimen Library Preservation</a>
        </div>
      </div>

      <a href="<?php echo e(url('/about')); ?>">About</a>
      <a href="<?php echo e(url('/partnerships')); ?>">Partner</a>
      <a href="<?php echo e(url('/contact')); ?>">Contact</a>
    </nav>
    <div class="header-cta">
      <button class="hamburger" type="button" aria-label="Menu" aria-expanded="false" aria-controls="lyovialHeaderNav"><span></span><span></span><span></span></button>
      <div class="phone-icon d-none d-xl-grid">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </div>
      <div class="phone-txt d-none d-xl-block">
        <small>Partner with us</small>
        <strong><a href="tel:<?php echo e(preg_replace('/\D+/', '', $phoneDisplay)); ?>"><?php echo e($phoneDisplay); ?></a></strong>
      </div>
    </div>
  </div>
</header>
<?php /**PATH C:\xampp\htdocs\liovine\resources\views/front/partials/lyovial-navbar.blade.php ENDPATH**/ ?>