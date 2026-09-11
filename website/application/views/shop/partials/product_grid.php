<?php if (!empty($products)): ?>
    <?php foreach ($products as $p): ?>
        <?php $this->load->view('home/_product_card', ['p' => $p, 'currency_symbol' => $currency_symbol ?? '$']); ?>
    <?php endforeach; ?>
<?php elseif (empty($is_append)): ?>
    <div class="col-12 text-center py-5">
        <div class="mb-3">
            <i class="fa-solid fa-magnifying-glass fs-1 text-muted"></i>
        </div>
        <h5 class="fw-bold">No products found</h5>
        <p class="text-muted">We couldn't find any products matching your selected filters.</p>
        <button type="button" class="btn btn-outline-primary btn-sm btn-clear-all-ajax">Clear Filters & Browse All</button>
    </div>
<?php endif; ?>