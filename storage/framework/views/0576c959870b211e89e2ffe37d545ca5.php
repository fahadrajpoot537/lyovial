<?php
    $bannerTitle = $bannerTitle ?? 'Page';
    $bannerSubtitle = $bannerSubtitle ?? null;
    $bannerImage = $bannerImage ?? \App\Support\SiteImages::get('home_hero');
?>
<section class="page-hero" style="--page-banner:url('<?php echo e($bannerImage); ?>')">
  <div class="container">
    <h1><?php echo e($bannerTitle); ?></h1>
    <?php if($bannerSubtitle): ?>
      <p><?php echo e($bannerSubtitle); ?></p>
    <?php endif; ?>
  </div>
</section>
<?php /**PATH C:\xampp\htdocs\liovine\resources\views/front/partials/page-banner.blade.php ENDPATH**/ ?>