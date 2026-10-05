<?php
require_once __DIR__ . '/includes/functions.php';
$page = get_page($pdo, 'products');
$page_title = $page ? $page['title'] : 'Our Products';
$page_meta = $page ? $page['meta_description'] : '';
$products = get_active_products($pdo);
include __DIR__ . '/includes/header.php';
?>

<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our <span>Products</span></h2>
            <?php if ($page): ?>
            <div class="page-content section-subtitle">
                <?php echo $page['content']; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php if (empty($products)): ?>
        <div class="text-center py-5">
            <i class="material-icons" style="font-size:64px;color:#ccc;">inventory_2</i>
            <h4 class="text-muted mt-3">Products coming soon!</h4>
            <p class="text-muted">We are working on exciting new products. Check back later or contact us for custom solutions.</p>
            <a href="<?php echo base_url('contact.php'); ?>" class="btn btn-livepro mt-2">Contact Us</a>
        </div>
        <?php else: ?>
        <!-- Category filter -->
        <?php
            $categories = array_unique(array_map(function($p) { return $p['category']; }, $products));
            $categories = array_filter($categories);
            sort($categories);
        ?>
        <?php if (count($categories) > 1): ?>
        <div class="text-center mb-4">
            <button class="btn btn-sm btn-livepro product-filter-btn active" data-category="all">All</button>
            <?php foreach ($categories as $cat): ?>
            <button class="btn btn-sm btn-outline-livepro product-filter-btn" data-category="<?php echo sanitize($cat); ?>"><?php echo sanitize($cat); ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row g-4" id="productsGrid">
            <?php foreach ($products as $product): ?>
            <div class="col-md-6 col-lg-4 product-item" data-category="<?php echo sanitize($product['category']); ?>">
                <div class="service-card h-100">
                    <?php if (!empty($product['image'])): ?>
                    <div class="mb-3 rounded overflow-hidden" style="height:180px;">
                        <img src="<?php echo (strpos($product['image'], 'http') === 0) ? $product['image'] : assets_url($product['image']); ?>" alt="<?php echo sanitize($product['title']); ?>" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <?php if (!empty($product['category'])): ?>
                        <span class="badge bg-primary"><?php echo sanitize($product['category']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($product['price'])): ?>
                        <span class="fw-bold text-primary"><?php echo sanitize($product['price']); ?></span>
                        <?php endif; ?>
                    </div>
                    <h4><?php echo sanitize($product['title']); ?></h4>
                    <p class="text-muted"><?php echo sanitize($product['short_description']); ?></p>
                    <?php if (!empty($product['features'])): ?>
                    <ul class="feature-list mt-3 mb-3">
                        <?php 
                        $features = array_filter(array_map('trim', explode("\n", $product['features'])));
                        $show_features = array_slice($features, 0, 4);
                        foreach ($show_features as $feat): ?>
                        <li><i class="material-icons" style="font-size:16px;">check_circle</i> <span style="font-size:0.9rem;"><?php echo sanitize($feat); ?></span></li>
                        <?php endforeach; ?>
                        <?php if (count($features) > 4): ?>
                        <li><i class="material-icons" style="font-size:16px;color:var(--livepro-blue);">more_horiz</i> <span style="font-size:0.9rem;color:var(--livepro-blue);">+<?php echo count($features) - 4; ?> more features</span></li>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>
                    <div class="mt-auto">
                        <button class="btn btn-sm btn-livepro w-100" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $product['id']; ?>">View Details</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Product Modals -->
        <?php foreach ($products as $product): ?>
        <div class="modal fade" id="productModal<?php echo $product['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><?php echo sanitize($product['title']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo (strpos($product['image'], 'http') === 0) ? $product['image'] : assets_url($product['image']); ?>" alt="<?php echo sanitize($product['title']); ?>" class="img-fluid rounded mb-3" style="max-height:250px;width:100%;object-fit:cover;">
                        <?php endif; ?>
                        <div class="d-flex gap-3 mb-3">
                            <?php if (!empty($product['category'])): ?>
                            <span class="badge bg-primary fs-6"><?php echo sanitize($product['category']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($product['price'])): ?>
                            <span class="fw-bold text-primary fs-6"><?php echo sanitize($product['price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="page-content">
                            <?php echo $product['description']; ?>
                        </div>
                        <?php if (!empty($product['features'])): ?>
                        <h5 class="fw-bold mt-4 mb-3">Key Features</h5>
                        <div class="row g-2">
                            <?php 
                            $features = array_filter(array_map('trim', explode("\n", $product['features'])));
                            foreach ($features as $feat): ?>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="material-icons text-success me-2" style="font-size:18px;">check_circle</i>
                                    <span><?php echo sanitize($feat); ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <?php if (!empty($product['button_link'])): ?>
                        <a href="<?php echo sanitize($product['button_link']); ?>" class="btn btn-livepro"><?php echo sanitize($product['button_text']); ?></a>
                        <?php else: ?>
                        <a href="<?php echo base_url('contact.php'); ?>" class="btn btn-livepro">Contact Us</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="section-padding cta-section">
    <div class="container">
        <h2>Need a Custom Product?</h2>
        <p>We build tailor-made software products to match your unique business requirements.</p>
        <a href="<?php echo base_url('contact.php'); ?>" class="btn btn-light btn-lg">Get a Quote</a>
    </div>
</section>

<script>
// Product category filter
document.querySelectorAll('.product-filter-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.product-filter-btn').forEach(function(b) {
            b.classList.remove('active', 'btn-livepro');
            b.classList.add('btn-outline-livepro');
        });
        this.classList.add('active', 'btn-livepro');
        this.classList.remove('btn-outline-livepro');
        var cat = this.getAttribute('data-category');
        document.querySelectorAll('.product-item').forEach(function(item) {
            if (cat === 'all' || item.getAttribute('data-category') === cat) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
