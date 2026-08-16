<?php
    $hero = $sections['hero'] ?? null;
    $about = $sections['about'] ?? null;
    $stats = $sections['stats'] ?? null;
    $servicesIntro = $sections['services'] ?? null;
    $industriesIntro = $sections['industries'] ?? null;
    $whyIntro = $sections['why_choose'] ?? null;
    $partner = $sections['partner'] ?? null;
    $testimonialsIntro = $sections['testimonials'] ?? null;
    $process = $sections['process'] ?? null;
    $faqIntro = $sections['faq'] ?? null;
    $articlesIntro = $sections['articles'] ?? null;

    $resolveImg = function (?string $path, string $fallback) {
        return \App\Support\SiteImages::resolve($path, $fallback);
    };

    $themeTestimonialAvatars = [
        'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&auto=format&fit=crop&q=80',
    ];
    $themeArticleThumbs = [
        \App\Support\SiteImages::url('process.jpg'),
        \App\Support\SiteImages::url('svc-1.jpg'),
        \App\Support\SiteImages::url('why-lg.jpg'),
    ];
    $themeArticleAvatars = [
        'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?w=200&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200&auto=format&fit=crop&q=80',
    ];

    $usableImg = function (?string $path) {
        if (! filled($path)) {
            return null;
        }
        // Dead / expired Unsplash theme URLs → use local fallback instead
        if (str_contains($path, 'images.unsplash.com')) {
            return null;
        }

        return $path;
    };

    $heroBg = \App\Support\SiteImages::resolve($usableImg($hero?->image), \App\Support\SiteImages::get('home_hero'));
    $aboutImg = \App\Support\SiteImages::resolve($usableImg($about?->image), \App\Support\SiteImages::get('home_about'));
    $whyImg = \App\Support\SiteImages::resolve($usableImg($whyIntro?->image), \App\Support\SiteImages::get('home_why'));
    $whyImgSm = \App\Support\SiteImages::get('home_why_sm');
    $partnerBg = \App\Support\SiteImages::resolve($usableImg($partner?->image), \App\Support\SiteImages::get('home_partner'));
    $processImg = \App\Support\SiteImages::resolve($usableImg($process?->image), \App\Support\SiteImages::get('home_process'));

    $themeServiceImgs = [
        \App\Support\SiteImages::url('svc-1.jpg'),
        \App\Support\SiteImages::url('svc-2.jpg'),
        \App\Support\SiteImages::url('svc-3.jpg'),
    ];
    $themeIndustryImgs = [
        \App\Support\SiteImages::url('ind-1.jpg'),
        \App\Support\SiteImages::url('ind-2.jpg'),
        \App\Support\SiteImages::url('ind-3.jpg'),
        \App\Support\SiteImages::url('ind-4.jpg'),
        \App\Support\SiteImages::url('ind-5.jpg'),
        \App\Support\SiteImages::url('ind-6.jpg'),
    ];

    $statItems = $stats?->extra['items'] ?? [
        ['num' => '250+', 'label' => 'Lyo Cycles<br/>Completed', 'icon' => 'flask'],
        ['num' => '40+', 'label' => 'Client<br/>Programs', 'icon' => 'doc'],
        ['num' => '12+', 'label' => 'Vial Formats<br/>Supported', 'icon' => 'vial'],
        ['num' => '100%', 'label' => 'Documented<br/>Cycles', 'icon' => 'check'],
    ];
    $partnerCards = $partner?->extra['cards'] ?? [];
    $processSteps = $process?->extra['steps'] ?? [];

    $statIcons = [
        'flask' => '<path d="M10 2v7.31M14 9.3V2M8.5 2h7M14 9.3a6.5 6.5 0 1 1-4 0"/>',
        'doc' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/><line x1="9" y1="11" x2="15" y2="11"/>',
        'vial' => '<rect x="4" y="6" width="16" height="14" rx="1"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M9 12h6M9 16h6"/>',
        'check' => '<polyline points="20 6 9 17 4 12"/>',
    ];
    $serviceIcons = [
        '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        '<path d="M4 4h6l2 3h8v13H4z"/>',
        '<path d="M12 2v6M9 5h6M6 8h12l-2 12H8z"/>',
    ];
    $whyIcons = [
        '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
        '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>',
    ];
    $partnerIcons = [
        'target' => '<path d="M12 2v20M2 12h20"/><circle cx="12" cy="12" r="9"/>',
        'flask-beaker' => '<path d="M9 11H5a2 2 0 0 0-2 2v7h18v-7a2 2 0 0 0-2-2h-4M9 11V4a3 3 0 0 1 6 0v7M9 11h6"/>',
    ];

    $heroHeading = $hero?->heading ?? 'Contract Lyophilization Services — Pilot-Scale Vial Freeze-Drying';

    $phoneDisplay = $sitePhone ?: '+1 613 800 8060';
?>

<?php $__env->startPush('styles'); ?>
<style>
.hero {
  --hero-bg-img: url('<?php echo e($heroBg); ?>');
  background:
    linear-gradient(90deg, rgba(14,124,134,.92) 0%, rgba(14,124,134,.75) 30%, rgba(14,124,134,.15) 60%, rgba(14,124,134,0) 100%),
    url('<?php echo e($heroBg); ?>') center right / cover no-repeat !important;
}
.about-img-inner { background-image: url('<?php echo e($aboutImg); ?>') !important; background-size: cover; background-position: center; }
.why-visual-hex-lg { background-image: url('<?php echo e($whyImg); ?>') !important; background-size: cover; background-position: center; }
.why-visual-hex-sm { background-image: url('<?php echo e($whyImgSm); ?>') !important; background-size: cover; background-position: center; }
.partner {
    background:
      linear-gradient(180deg, rgba(14,124,134,.92) 0%, rgba(14,124,134,.92) 100%),
      url('<?php echo e($partnerBg); ?>') center/cover no-repeat !important;
}
.coverage-image { background-image: url('<?php echo e($processImg); ?>') !important; background-size: cover; background-position: center; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.partials.lyovial-navbar', ['transparent' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(!$hero || $hero->is_active): ?>
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <h1><?php echo e($heroHeading); ?></h1>
      <p><?php echo e(strip_tags($hero?->description ?? '')); ?></p>
      <?php if($hero?->button_primary_text): ?>
        <a href="<?php echo e(url($hero->button_primary_link ?: '/contact')); ?>" class="btn btn-primary"><?php echo e($hero->button_primary_text); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if($about?->is_active): ?>
<section class="about" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img">
        <div class="about-img-inner" style="background-image:url('<?php echo e($aboutImg); ?>');">
          <img src="<?php echo e($aboutImg); ?>" alt="<?php echo e($about->image_alt ?: ($about->heading ?: 'About LyoVial')); ?>" class="about-img-fallback" loading="lazy" decoding="async">
        </div>
      </div>
      <div>
        <?php if($about->small_title): ?><div class="eyebrow"><?php echo e($about->small_title); ?></div><?php endif; ?>
        <h2><?php echo e($about->heading); ?></h2>
        <?php echo $about->description; ?>

        <?php if($about->button_primary_text): ?>
          <a href="<?php echo e(url($about->button_primary_link ?: '#')); ?>" class="btn btn-primary" style="margin-top:20px"><?php echo e($about->button_primary_text); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if(!$stats || $stats->is_active): ?>
<section class="stats">
  <div class="container">
    <div class="stats-grid">
      <?php $__currentLoopData = $statItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $iconKey = $stat['icon'] ?? 'flask'; ?>
        <div class="stat">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?php echo $statIcons[$iconKey] ?? $statIcons['flask']; ?></svg>
          </div>
          <div class="stat-num"><?php echo e($stat['num'] ?? ''); ?></div>
          <div class="stat-label"><?php echo $stat['label'] ?? ''; ?></div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<section class="section services">
  <div class="container">
    <div class="section-head">
      <?php if($servicesIntro?->small_title): ?><div class="eyebrow"><?php echo e($servicesIntro->small_title); ?></div><?php endif; ?>
      <h2><?php echo e($servicesIntro?->heading ?? 'Three services covering the full lyophilization workflow'); ?></h2>
      <p><?php echo e(strip_tags($servicesIntro?->description ?? '')); ?></p>
    </div>
    <div class="service-grid">
      <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $svcImg = $resolveImg($usableImg($service->featured_image), $themeServiceImgs[$i % count($themeServiceImgs)]);
        ?>
        <a href="<?php echo e(url('/capabilities/'.$service->slug)); ?>" class="service-card" style="display:block;color:inherit">
          <div class="service-img" style="background-image:url('<?php echo e($svcImg); ?>')"></div>
          <div class="service-body">
            <div class="service-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?php echo $serviceIcons[$i % count($serviceIcons)]; ?></svg>
            </div>
            <h3><?php echo e($service->title); ?></h3>
            <p><?php echo e($service->short_description); ?></p>
          </div>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section class="section serve" id="industries">
  <div class="container">
    <div class="section-head">
      <?php if($industriesIntro?->small_title): ?><div class="eyebrow"><?php echo e($industriesIntro->small_title); ?></div><?php endif; ?>
      <h2><?php echo e($industriesIntro?->heading ?? 'Teams that turn to LyoVial for contract freeze-drying'); ?></h2>
      <p><?php echo e(strip_tags($industriesIntro?->description ?? '')); ?></p>
    </div>
    <div class="serve-grid">
      <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $indImg = $resolveImg($usableImg($industry->image), $themeIndustryImgs[$i % count($themeIndustryImgs)]);
        ?>
        <div class="serve-card">
          <div class="serve-card-thumb">
            <img src="<?php echo e($indImg); ?>" alt="<?php echo e($industry->title); ?>" loading="lazy">
          </div>
          <div class="serve-card-hover">
            <h3 class="serve-card-title"><?php echo e($industry->title); ?></h3>
            <?php if($industry->short_description): ?>
              <p class="serve-card-text"><?php echo e($industry->short_description); ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<?php if(!$whyIntro || $whyIntro->is_active): ?>
<section class="why">
  <div class="container">
    <div class="why-grid">
      <div class="why-content">
        <?php if($whyIntro?->small_title): ?><div class="eyebrow"><?php echo e($whyIntro->small_title); ?></div><?php endif; ?>
        <h2><?php echo e($whyIntro?->heading ?? 'Why teams choose LyoVial for contract lyophilization services'); ?></h2>
        <p><?php echo e(strip_tags($whyIntro?->description ?? '')); ?></p>
        <div class="why-features">
          <?php $__currentLoopData = $whyChoose; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="why-feature">
              <div class="why-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?php echo $whyIcons[$i % count($whyIcons)]; ?></svg>
              </div>
              <h3><?php echo e($item->title); ?></h3>
              <p><?php echo e($item->description); ?></p>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($whyIntro?->button_primary_text): ?>
          <a href="<?php echo e(url($whyIntro->button_primary_link ?: '#')); ?>" class="btn btn-primary"><?php echo e($whyIntro->button_primary_text); ?></a>
        <?php endif; ?>
      </div>
      <div class="why-visual">
        <div class="why-visual-hex-lg" style="background-image:url('<?php echo e($whyImg); ?>');background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
        <div class="why-visual-hex-sm" style="background-image:url('<?php echo e($whyImgSm); ?>');background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if(!$partner || $partner->is_active): ?>
<section class="partner">
  <div class="container">
    <div class="partner-head">
      <div>
        <?php if($partner?->small_title): ?><div class="eyebrow"><?php echo e($partner->small_title); ?></div><?php endif; ?>
        <h2><?php echo e($partner?->heading ?? 'Your Canadian partner for pilot-scale contract lyophilization'); ?></h2>
      </div>
      <?php if($partner?->button_primary_text): ?>
        <a href="<?php echo e(url($partner->button_primary_link ?: '/contact')); ?>" class="btn btn-primary"><?php echo e($partner->button_primary_text); ?></a>
      <?php endif; ?>
    </div>
    <div class="partner-cards">
      <?php $__currentLoopData = $partnerCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $pIcon = $card['icon'] ?? 'target'; ?>
        <div class="partner-card">
          <div class="partner-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?php echo $partnerIcons[$pIcon] ?? $partnerIcons['target']; ?></svg>
          </div>
          <h3><?php echo e($card['title'] ?? ''); ?></h3>
          <p><?php echo e($card['description'] ?? ''); ?></p>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<div class="partner-spacer"></div>
<?php endif; ?>


<?php if((!$testimonialsIntro || $testimonialsIntro->is_active) && $testimonials->count()): ?>
<section class="testimonials">
  <div class="container testimonials-inner">
    <div class="section-head">
      <?php if($testimonialsIntro?->small_title): ?><div class="eyebrow"><?php echo e($testimonialsIntro->small_title); ?></div><?php endif; ?>
      <h2><?php echo e($testimonialsIntro?->heading ?? 'What our contract lyophilization clients say'); ?></h2>
    </div>
    <div class="testimonial-grid">
      <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="testimonial">
          <div class="testimonial-header">
            <div class="testimonial-name">
              <strong><?php echo e($testimonial->name); ?></strong>
              <?php if($testimonial->role): ?>
                <span><?php echo e($testimonial->role); ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="testimonial-body">
            <p>"<?php echo e($testimonial->quote); ?>"</p>
            <div class="stars">
              <?php for($s = 0; $s < max(1, min(5, (int) $testimonial->rating)); $s++): ?>
                <svg viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568L24 9.75l-6 5.847 1.416 8.253L12 19.771l-7.416 4.079L6 15.597 0 9.75l8.332-1.595z"/></svg>
              <?php endfor; ?>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>


<?php if(!$process || $process->is_active): ?>
<section class="coverage">
  <div class="container">
    <div class="coverage-head">
      <?php if($process?->small_title): ?>
        <div class="eyebrow" style="justify-content:center;display:inline-flex"><?php echo e($process->small_title); ?></div>
      <?php endif; ?>
      <h2><?php echo e($process?->heading ?? 'How our contract lyophilization services work'); ?></h2>
      <p><?php echo e(strip_tags($process?->description ?? '')); ?></p>
    </div>
    <?php
      $leftSteps = array_slice($processSteps, 0, 2);
      $rightSteps = array_slice($processSteps, 2, 2);
    ?>
    <div class="coverage-grid">
      <div class="coverage-list">
        <?php $__currentLoopData = $leftSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="coverage-item">
            <div class="coverage-num"><?php echo e($step['num'] ?? ''); ?></div>
            <strong><?php echo nl2br(e($step['title'] ?? '')); ?></strong>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="coverage-image" style="background-image:url('<?php echo e($processImg); ?>');background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
      <div class="coverage-list">
        <?php $__currentLoopData = $rightSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="coverage-item">
            <div class="coverage-num"><?php echo e($step['num'] ?? ''); ?></div>
            <strong><?php echo nl2br(e($step['title'] ?? '')); ?></strong>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>


<section class="lyovial-faq" id="faq">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="text-center mb-4">
          <?php if($faqIntro?->small_title): ?><div class="eyebrow" style="justify-content:center;display:inline-flex;margin:0 auto 12px"><?php echo e($faqIntro->small_title); ?></div><?php endif; ?>
          <h2 class="section-title"><?php echo e($faqIntro?->heading ?? 'FAQ'); ?></h2>
          <p class="mx-auto" style="max-width:640px;color:#000"><?php echo e(strip_tags($faqIntro?->description ?? '')); ?></p>
        </div>
        <div class="accordion" id="faqAccordion">
          <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="accordion-item mb-2 border rounded-3 overflow-hidden">
              <h3 class="accordion-header">
                <button class="accordion-button <?php echo e($i ? 'collapsed' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo e($faq->id); ?>">
                  <?php echo e($faq->question); ?>

                </button>
              </h3>
              <div id="faq<?php echo e($faq->id); ?>" class="accordion-collapse collapse <?php echo e($i ? '' : 'show'); ?>" data-bs-parent="#faqAccordion">
                <div class="accordion-body"><?php echo e($faq->answer); ?></div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
  </div>
</section>


<?php if((!$articlesIntro || $articlesIntro->is_active) && $articles->count()): ?>
<section class="blog" id="articles">
  <div class="container">
    <div class="section-head blog-head">
      <div>
        <?php if($articlesIntro?->small_title): ?><div class="eyebrow"><?php echo e($articlesIntro->small_title); ?></div><?php endif; ?>
        <h2><?php echo e($articlesIntro?->heading ?? 'Latest lyophilization insights & case notes'); ?></h2>
      </div>
      <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-primary">View All →</a>
    </div>
    <div class="blog-grid">
      <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $thumb = $resolveImg($article->featured_image, $themeArticleThumbs[$i % count($themeArticleThumbs)]);
          $avatar = $resolveImg($article->author_avatar, $themeArticleAvatars[$i % count($themeArticleAvatars)]);
          $day = $article->published_at?->format('d') ?? '01';
          $month = $article->published_at?->format('M') ?? 'Jan';
        ?>
        <div class="blog-card">
          <div class="blog-thumb" style="background-image:url('<?php echo e($thumb); ?>')">
            <div class="blog-date">
              <strong><?php echo e($day); ?></strong><span><?php echo e($month); ?></span>
            </div>
          </div>
          <div class="blog-body">
            <div class="blog-author">
              <div class="blog-author-avatar" style="background-image:url('<?php echo e($avatar); ?>')"></div>
              <div>
                <strong><?php echo e($article->author_name); ?></strong>
                <span><?php echo e($article->author_role); ?></span>
              </div>
            </div>
            <h3><?php echo e($article->title); ?></h3>
            <a href="<?php echo e(route('articles.show', $article)); ?>" class="read-more">Read More <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.lyovial-home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\liovine\resources\views/front/home.blade.php ENDPATH**/ ?>