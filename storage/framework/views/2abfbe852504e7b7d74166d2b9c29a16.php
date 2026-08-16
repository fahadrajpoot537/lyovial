

<?php
    use App\Support\ThemePageDefaults;
    use App\Support\SiteImages;
    $seo = $page->seo ?? null;
    $x = ThemePageDefaults::mergePage($page->extra ?? null, \App\Models\Page::TYPE_SPECIMEN_LIBRARY);
    $heading = $page->heading ?: $page->title;
    $bannerImage = SiteImages::resolve($page->banner_image, SiteImages::get('banner_specimen'));
?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.partials.lyovial-navbar', ['transparent' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('front.partials.page-banner', [
    'bannerTitle' => $page->title ?: 'Specimen Library Preservation',
    'bannerSubtitle' => $x['hero_eyebrow'] ?? null,
    'bannerImage' => $bannerImage,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/lyovial-theme-pages.css')); ?>">

<div class="lv-theme">
  <?php if(!empty($x['hero_sub'])): ?>
  <section class="approach" style="padding:50px 0 20px">
    <div class="container" style="text-align:center;max-width:720px">
      <h2 style="font-size:28px;color:var(--navy-900);margin-bottom:14px"><?php echo e($heading); ?></h2>
      <p style="color:var(--text-muted)"><?php echo e($x['hero_sub']); ?></p>
      <a href="<?php echo e(route('contact')); ?>" class="btn" style="margin-top:18px"><?php echo e($x['hero_button'] ?: 'Talk to Us About Your Collection'); ?></a>
    </div>
  </section>
  <?php endif; ?>

  <?php if(!empty($x['benefits'])): ?>
  <div class="benefit-strip">
    <div class="container">
      <?php
        $benefitIcons = ['bi-truck', 'bi-piggy-bank', 'bi-shield-check', 'bi-clock-history'];
      ?>
      <?php $__currentLoopData = $x['benefits']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(empty($benefit['title'])) continue; ?>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="bi <?php echo e($benefitIcons[$loop->index] ?? 'bi-check-circle'); ?>"></i>
          </div>
          <h4><?php echo e($benefit['title']); ?></h4>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
  <?php endif; ?>

  <section class="challenge">
    <div class="container">
      <div>
        <div class="eyebrow"><?php echo e($x['challenge_eyebrow'] ?? ''); ?></div>
        <h2><?php echo e($x['challenge_heading'] ?? ''); ?></h2>
        <p><?php echo e($x['challenge_body'] ?? ''); ?></p>
      </div>
      <div class="challenge-visual" style="background:url('<?php echo e(SiteImages::get('home_facility')); ?>') center/cover no-repeat">
        <div class="pulse-dot"></div>
      </div>
    </div>
  </section>

  <section class="solution">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow" style="justify-content:center;"><?php echo e($x['solution_eyebrow'] ?? ''); ?></div>
        <h2><?php echo e($x['solution_heading'] ?? ''); ?></h2>
      </div>
      <?php $__currentLoopData = ($x['solution_steps'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(empty($step['title'])) continue; ?>
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['zig', 'reverse' => $loop->iteration % 2 === 0]); ?>">
          <div class="zig-text">
            <div class="zig-num"><?php echo e($step['label'] ?? ('Step '.$loop->iteration)); ?></div>
            <h3><?php echo e($step['title']); ?></h3>
            <p><?php echo e($step['body'] ?? ''); ?></p>
          </div>
          <div class="zig-visual" style="background:url('<?php echo e(SiteImages::industryImage($loop->index)); ?>') center/cover no-repeat"></div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>

  <?php if(!empty($x['stats'])): ?>
  <div class="statband">
    <div class="container">
      <?php
        $statIcons = ['bi-box-seam', 'bi-thermometer-half', 'bi-clipboard-data', 'bi-hdd-rack'];
      ?>
      <?php $__currentLoopData = $x['stats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!filled($stat)) continue; ?>
        <div class="statband-item">
          <div class="statband-icon">
            <i class="bi <?php echo e($statIcons[$loop->index] ?? 'bi-check2-circle'); ?>"></i>
          </div>
          <h4><?php echo e($stat); ?></h4>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
  <?php endif; ?>

  <?php if(!empty($x['faqs'])): ?>
  <section class="faq">
    <div class="section-head" style="margin-bottom:36px;">
      <div class="eyebrow" style="justify-content:center;"><?php echo e($x['faq_eyebrow'] ?? ''); ?></div>
      <h2><?php echo e($x['faq_heading'] ?? ''); ?></h2>
    </div>
    <?php $__currentLoopData = $x['faqs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(empty($faq['question'])) continue; ?>
      <details <?php if($loop->first): ?> open <?php endif; ?>>
        <summary><?php echo e($faq['question']); ?></summary>
        <p><?php echo e($faq['answer'] ?? ''); ?></p>
      </details>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>
  <?php endif; ?>

  <div class="cta-banner" id="contact" style="background:linear-gradient(180deg,rgba(14,124,134,.9),rgba(14,124,134,.86)),url('<?php echo e(SiteImages::get('home_process')); ?>') center/cover no-repeat">
    <h3 class="heading-bold"><?php echo e($x['cta_heading'] ?? ''); ?></h3>
    <p><?php echo e($x['cta_body'] ?? ''); ?></p>
    <a href="<?php echo e(route('contact')); ?>" class="btn"><?php echo e($x['cta_button'] ?: 'Request a Consultation'); ?></a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.lyovial-home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\liovine\resources\views/front/pages/specimen.blade.php ENDPATH**/ ?>