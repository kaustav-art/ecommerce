        <?php
        $status = strtolower($order['order_status']);
        $is_delivered = in_array($status, ['delivered', 'completed']);
        $is_shipped   = in_array($status, ['shipped', 'delivered', 'completed']);
        $is_confirmed = in_array($status, ['processing', 'shipped', 'delivered', 'completed']);
        $is_cancelled = ($status === 'cancelled');

        $items = $order['items'] ?? [];
        if (empty($items)) {
            $items = [[
                'product_id'    => 0,
                'product_title' => 'Order #' . $order['order_number'],
                'product_image' => 'products/womens/women-1.jpg',
                'variant_title' => '',
                'price'         => $order['total_amount'],
                'quantity'      => 1,
                'total'         => $order['total_amount']
            ]];
        }

        $seller_name = !empty($store_settings['site_name']) ? html_escape($store_settings['site_name']) : 'LifewayHygiene';

        // Courier & AWB Details (Third-Party Courier: DTDC, Xpressbees, etc.)
        $courier_name    = !empty($order['courier_name']) ? trim($order['courier_name']) : '';
        $tracking_number = !empty($order['tracking_number']) ? trim($order['tracking_number']) : '';
        $tracking_url    = !empty($order['tracking_url']) ? trim($order['tracking_url']) : '';

        // Auto-generate standard tracking URL if courier and AWB are provided but URL is empty
        if (empty($tracking_url) && !empty($tracking_number)) {
            $c = strtolower($courier_name);
            if (strpos($c, 'xpress') !== false) {
                $tracking_url = 'https://www.xpressbees.com/shipment/tracking?awbNo=' . urlencode($tracking_number);
            } elseif (strpos($c, 'delhivery') !== false) {
                $tracking_url = 'https://www.delhivery.com/track/package/' . urlencode($tracking_number);
            } elseif (strpos($c, 'dtdc') !== false) {
                $tracking_url = 'https://www.dtdc.in/tracking.asp';
            } elseif (strpos($c, 'blue') !== false) {
                $tracking_url = 'https://www.bluedart.com/tracking';
            } elseif (strpos($c, 'ekart') !== false) {
                $tracking_url = 'https://ekartlogistics.com/shipmenttrack/' . urlencode($tracking_number);
            } elseif (strpos($c, 'shadowfax') !== false) {
                $tracking_url = 'https://tracker.shadowfax.in/#/track?awb=' . urlencode($tracking_number);
            } elseif (strpos($c, 'speed') !== false || strpos($c, 'post') !== false) {
                $tracking_url = 'https://www.indiapost.gov.in/_layouts/15/dpt.cept.tracking/trackconsignment.aspx';
            } else {
                $tracking_url = 'https://www.dtdc.in/tracking.asp';
            }
        }

        // Dates
        $date_confirmed = date('M d', strtotime($order['created_at']));
        $time_confirmed = date('h:i A', strtotime($order['created_at']));
        $date_shipped   = !empty($order['shipped_at']) ? date('M d', strtotime($order['shipped_at'])) : date('M d', strtotime($order['created_at'] . ' + 1 day'));
        $date_delivered = !empty($order['delivered_at']) ? date('M d', strtotime($order['delivered_at'])) : date('M d', strtotime($order['updated_at'] ?? ($order['created_at'] . ' + 4 days')));
        $date_expected  = date('M d', strtotime($order['created_at'] . ' + 4 days'));
        $return_end_date = date('M d', strtotime(($order['updated_at'] ?? $order['created_at']) . ' + 7 days'));

        // Pricing calculations
        $subtotal = (float) ($order['subtotal'] ?? $order['total_amount']);
        $discount = (float) ($order['discount_amount'] ?? 0);
        $shipping = (float) ($order['shipping_amount'] ?? 0);
        $total    = (float) $order['total_amount'];
        $listing_price = $subtotal + ($discount > 0 ? $discount : 150);

        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();

        // Address & Address Type Resolution (Home vs Work)
        $addr_type = 'HOME';
        if (!empty($order['address_type'])) {
            $raw_type = strtoupper(trim($order['address_type']));
            if (in_array($raw_type, ['WORK', 'HOME'])) {
                $addr_type = $raw_type;
            }
        }

        // Fallback: Check if (WORK) or WORK exists in shipping_address
        if ($addr_type === 'HOME' && !empty($order['shipping_address'])) {
            if (preg_match('/\b(work|office|commercial)\b/i', $order['shipping_address'])) {
                $addr_type = 'WORK';
            }
        }

        // Fallback: Check user's saved addresses in user_addresses
        if ($addr_type === 'HOME' && !empty($order['user_id'])) {
            $db_inst = isset($this->db) ? $this->db : (function_exists('get_instance') ? get_instance()->db : null);
            if ($db_inst) {
                $saved_work = $db_inst->where('user_id', (int)$order['user_id'])
                                      ->where('company', 'WORK')
                                      ->get('user_addresses')
                                      ->row_array();
                if ($saved_work) {
                    $addr_type = 'WORK';
                }
            }
        }

        // Clean & Format Address
        $raw_address = trim($order['shipping_address'] ?? '');
        $lines = array_filter(array_map('trim', preg_split('/[\r\n]+/', $raw_address)));

        $clean_lines = [];
        $recipient_name = !empty($order['customer_name']) ? trim($order['customer_name']) : '';
        $recipient_phone = !empty($order['customer_phone']) ? trim($order['customer_phone']) : '';

        foreach ($lines as $line) {
            // If line has (WORK) or (HOME), extract address type if not already set
            if (preg_match('/\((WORK|HOME)\)/i', $line, $m)) {
                $addr_type = strtoupper($m[1]);
                $line = trim(preg_replace('/\((WORK|HOME)\)/i', '', $line));
            }

            // Skip if line is just the customer name
            if (!empty($recipient_name) && strcasecmp($line, $recipient_name) === 0) {
                continue;
            }

            // Skip if line is just "Phone: ..." or "Mobile: ..."
            if (preg_match('/^(phone|mobile):\s*(.*)$/i', $line, $pm)) {
                if (empty($recipient_phone) && !empty($pm[2])) {
                    $recipient_phone = trim($pm[2]);
                }
                continue;
            }

            if (!empty($line)) {
                $clean_lines[] = $line;
            }
        }

        $display_address = !empty($clean_lines) ? implode(', ', $clean_lines) : $raw_address;

        // Visual Icon and Label for Address Type
        $is_work = ($addr_type === 'WORK');
        $addr_type_label = $is_work ? 'Work' : 'Home';
        $addr_icon = $is_work ? 'fa-solid fa-briefcase' : 'fa-solid fa-house';
        ?>

        <!-- breadcrumb -->
        <div class="py-2 border-bottom" style="background-color: #f1f3f6;">
            <div class="fk-orders-container px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 12px;">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('account/profile'); ?>" class="text-muted text-decoration-none">My Account</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('account/orders'); ?>" class="text-muted text-decoration-none">My Orders</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?= html_escape($order['order_number']); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- order-details-section (Single-Vendor 3rd-Party Courier Tracking) -->
        <section class="py-3" style="background-color: #f1f3f6; min-height: 85vh;">
            <div class="fk-orders-container px-3">

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-1 py-2 px-3 small mb-3" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i><?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-1 py-2 px-3 small mb-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i><?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-3">
                    <!-- Left Column: Shipment Details, Courier AWB Card, Items, Rating (Col 8) -->
                    <div class="col-lg-8 col-md-8 col-12">

                        <!-- 1. Third-Party Courier & AWB Live Tracking Card -->
                        <?php if ($is_shipped || !empty($tracking_number)): ?>
                            <div class="card border rounded-1 p-3 mb-3 bg-white shadow-none" style="border-color: #b8daff !important; background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center bg-primary text-white" style="width: 34px; height: 34px; font-size: 15px;">
                                            <i class="fa-solid fa-truck-fast"></i>
                                        </span>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                                                Courier Partner: <span class="text-primary"><?= !empty($courier_name) ? html_escape($courier_name) : 'DTDC / Third-Party Courier'; ?></span>
                                            </h6>
                                            <div class="text-muted small" style="font-size: 11px;">Dispatched by store owner via third-party courier service</div>
                                        </div>
                                    </div>

                                    <?php if (!empty($tracking_url)): ?>
                                        <a href="<?= html_escape($tracking_url); ?>" target="_blank" class="btn btn-primary btn-sm px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 rounded-1" style="background-color: #2874f0; border-color: #2874f0; font-size: 12px;">
                                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px;"></i> Track on <?= !empty($courier_name) ? html_escape($courier_name) : 'Courier'; ?> Website
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- AWB Box -->
                                <div class="p-3 border rounded-1 bg-white d-flex justify-content-between align-items-center flex-wrap gap-3" style="border-color: #e0e0e0 !important;">
                                    <div>
                                        <div class="text-muted small fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">AWB / Tracking Number</div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <span class="fw-bold text-dark font-monospace fs-6" id="awb-code-text"><?= !empty($tracking_number) ? html_escape($tracking_number) : 'Assigned upon courier pickup'; ?></span>
                                            <?php if (!empty($tracking_number)): ?>
                                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-1" onclick="copyAwbCode('<?= html_escape($tracking_number); ?>')" title="Copy AWB Number" style="font-size: 11px;">
                                                    <i class="fa-regular fa-copy me-1"></i> Copy AWB
                                                </button>
                                                <span id="awb-copy-alert" class="text-success small fw-semibold d-none" style="font-size: 11px;">Copied!</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($tracking_url)): ?>
                                        <div>
                                            <a href="<?= html_escape($tracking_url); ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-1 fw-semibold" style="color: #2874f0; border-color: #2874f0; font-size: 12px;">
                                                Open <?= !empty($courier_name) ? html_escape($courier_name) : 'Courier'; ?> Tracking Portal <i class="fa-solid fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="text-secondary small mt-2" style="font-size: 12px; line-height: 1.5;">
                                    <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                    As a store owner, products are dispatched via trusted third-party courier services (e.g. DTDC, Xpressbees). You can copy your AWB number and use the courier website link above to view live transit checkpoints.
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Preparation Notice (Before Dispatch) -->
                            <div class="card border rounded-1 p-3 mb-3 bg-white shadow-none" style="border-color: #e0e0e0 !important;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light text-primary flex-shrink-0" style="width: 40px; height: 40px; font-size: 18px;">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">
                                            <?= ($status === 'pending') ? 'Order Placed - Awaiting Confirmation' : 'Order Confirmed - Packaging in Progress'; ?>
                                        </h6>
                                        <div class="text-secondary small" style="font-size: 12px; line-height: 1.4;">
                                            <?= ($status === 'pending') ? 'Your order has been placed. Waiting for confirmation by the store owner.' : 'Your order is confirmed by the store owner and is being packed.'; ?>
                                            Once handed over to our third-party courier (such as DTDC or Xpressbees), your <strong>AWB Tracking Number</strong> and official tracking portal link will appear here.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- 2. Shipment Progress Stepper Card -->
                        <div class="card border rounded-1 bg-white shadow-none mb-3" style="border-color: #e0e0e0 !important;">
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #fafafa;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-route text-primary fs-5"></i>
                                    <span class="fw-bold text-dark" style="font-size: 14px;">Shipment Progress</span>
                                    <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">
                                        <?= count($items); ?> <?= count($items) === 1 ? 'item' : 'items'; ?> shipped together
                                    </span>
                                </div>
                                <div class="text-secondary small">
                                    Store: <strong class="text-dark"><?= $seller_name; ?></strong>
                                </div>
                            </div>

                            <!-- Fulfillment Lifecycle Stepper -->
                            <div class="p-4">
                                <?php if ($is_cancelled): ?>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 22px; height: 22px; background-color: #e53935; font-size: 11px;">
                                            <i class="fa-solid fa-xmark"></i>
                                        </span>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">Cancelled, <?= date('M d', strtotime($order['updated_at'] ?? $order['created_at'])); ?></div>
                                            <div class="text-muted small">Your order has been cancelled.</div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- Step 1: Order Placed -->
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0 mt-1" style="width: 22px; height: 22px; background-color: #26a541; font-size: 11px;">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">Order Placed, <?= $date_confirmed; ?></div>
                                            <div class="text-muted small" style="font-size: 12px;">Order received at <?= $time_confirmed; ?></div>
                                        </div>
                                    </div>

                                    <!-- Connector 1 -->
                                    <div style="width: 2px; height: 28px; background-color: <?= $is_confirmed ? '#26a541' : '#d1d5db'; ?>; margin-left: 10px;"></div>

                                    <!-- Step 2: Order Confirmed by Store Owner -->
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0 mt-1" style="width: 22px; height: 22px; background-color: <?= $is_confirmed ? '#26a541' : '#9ca3af'; ?>; font-size: 11px;">
                                            <i class="fa-solid <?= $is_confirmed ? 'fa-check' : 'fa-clock'; ?>"></i>
                                        </span>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">
                                                <?= $is_confirmed ? 'Order Confirmed by Store Owner' : 'Confirmation Pending'; ?>
                                            </div>
                                            <div class="text-muted small" style="font-size: 12px;">
                                                <?= $is_confirmed ? 'Order verified and accepted for packing' : 'Awaiting store owner confirmation'; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Connector 2 -->
                                    <div style="width: 2px; height: 28px; background-color: <?= $is_shipped ? '#26a541' : '#d1d5db'; ?>; margin-left: 10px;"></div>

                                    <!-- Step 3: Shipped via 3rd-Party Courier (DTDC / Xpressbees) -->
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0 mt-1" style="width: 22px; height: 22px; background-color: <?= $is_shipped ? '#26a541' : '#9ca3af'; ?>; font-size: 11px;">
                                            <i class="fa-solid <?= $is_shipped ? 'fa-check' : 'fa-truck-fast'; ?>"></i>
                                        </span>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">
                                                <?php if ($is_shipped): ?>
                                                    Shipped via <?= !empty($courier_name) ? html_escape($courier_name) : 'Courier'; ?>, <?= $date_shipped; ?>
                                                <?php else: ?>
                                                    Packaging & Courier Dispatch
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-muted small" style="font-size: 12px;">
                                                <?php if (!empty($tracking_number)): ?>
                                                    Dispatched with AWB #<?= html_escape($tracking_number); ?>
                                                <?php else: ?>
                                                    Items will be packed together and handed over to courier
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Connector 3 -->
                                    <div style="width: 2px; height: 28px; background-color: <?= $is_delivered ? '#26a541' : '#d1d5db'; ?>; margin-left: 10px;"></div>

                                    <!-- Step 4: Delivered -->
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0 mt-1" style="width: 22px; height: 22px; background-color: <?= $is_delivered ? '#26a541' : '#9ca3af'; ?>; font-size: 11px;">
                                            <i class="fa-solid <?= $is_delivered ? 'fa-check' : 'fa-house-circle-check'; ?>"></i>
                                        </span>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">
                                                <?= $is_delivered ? 'Delivered, ' . $date_delivered : 'Delivery expected by ' . $date_expected; ?>
                                            </div>
                                            <div class="text-muted small" style="font-size: 12px;">
                                                <?= $is_delivered ? 'Your package has been delivered by courier agent' : 'Package in transit to customer address'; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- See All Updates Link -->
                                    <div class="mt-3 ps-1">
                                        <a href="javascript:void(0);" onclick="toggleTrackingUpdates()" class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1" style="color: #2874f0 !important; font-size: 13px;">
                                            See All Updates <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                                        </a>
                                    </div>

                                    <!-- Expandable Detailed Tracking Updates -->
                                    <div id="tracking-updates-box" class="mt-3 p-3 bg-light border rounded-1 d-none" style="font-size: 13px;">
                                        <?php if ($is_delivered): ?>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><strong>Package Delivered</strong> by courier associate</span>
                                                <span class="text-muted"><?= $date_delivered; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($is_shipped): ?>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><strong>Handed over to <?= !empty($courier_name) ? html_escape($courier_name) : 'Courier'; ?></strong> (AWB: <?= !empty($tracking_number) ? html_escape($tracking_number) : 'Assigned'; ?>)</span>
                                                <span class="text-muted"><?= $date_shipped; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($is_confirmed): ?>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span><strong>Order Confirmed</strong> & packed together by store owner</span>
                                                <span class="text-muted"><?= $date_confirmed; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex justify-content-between">
                                            <span><strong>Order Placed</strong> by customer</span>
                                            <span class="text-muted"><?= $date_confirmed; ?>, <?= $time_confirmed; ?></span>
                                        </div>
                                    </div>

                                    <?php if ($is_delivered): ?>
                                        <!-- Return Policy Note -->
                                        <div class="text-muted small mt-3" style="font-size: 12px; color: #878787 !important;">
                                            Return policy ended on <?= $return_end_date; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <hr class="m-0" style="border-color: #f0f0f0;">

                            <!-- Card Footer: Chat with us -->
                            <div class="py-3 text-center">
                                <a href="javascript:void(0);" class="text-decoration-none text-dark fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#chatSupportModal">
                                    <i class="fa-regular fa-comment-dots text-primary fs-5" style="color: #2874f0 !important;"></i>
                                    <span>Chat with us</span>
                                </a>
                            </div>
                        </div>

                        <!-- 3. Items in this Shipment Card (Shipped Together) -->
                        <div class="card border rounded-1 bg-white shadow-none mb-3 p-4" style="border-color: #e0e0e0 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">
                                    <i class="fa-solid fa-boxes-packing text-primary me-2"></i> Items in this Shipment (<?= count($items); ?>)
                                </h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-semibold" style="font-size: 11px;">
                                    Shipped Together in 1 Package
                                </span>
                            </div>

                            <?php foreach ($items as $idx => $it): ?>
                                <?php
                                $it_img = !empty($it['product_image']) ? base_url('assets/images/' . $it['product_image']) : base_url('assets/images/products/womens/women-1.jpg');
                                $it_pid = (int) ($it['product_id'] ?? 0);

                                $it_variant = '';
                                if (!empty($it['variant_title'])) {
                                    $vt = trim($it['variant_title']);
                                    if (stripos($vt, 'color') === false && stripos($vt, 'size') === false && strpos($vt, '/') !== false) {
                                        $parts = explode('/', $vt);
                                        $it_variant = 'Color: ' . trim($parts[0]) . '  Size: ' . trim($parts[1] ?? '');
                                    } else {
                                        $it_variant = $vt;
                                    }
                                }
                                ?>
                                <?php if ($idx > 0): ?>
                                    <hr class="my-3" style="border-color: #f0f0f0;">
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div class="d-flex gap-3">
                                        <img src="<?= $it_img; ?>" alt="<?= html_escape($it['product_title']); ?>" class="border rounded-1 flex-shrink-0" style="width: 80px; height: 80px; object-fit: contain; background-color: #fafafa;" onerror="this.src='<?= base_url('assets/images/products/womens/women-1.jpg'); ?>'">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1" style="font-size: 15px; line-height: 1.4;">
                                                <?= html_escape($it['product_title']); ?>
                                            </h6>
                                            <?php if (!empty($it_variant)): ?>
                                                <div class="text-secondary small mb-1"><?= html_escape($it_variant); ?></div>
                                            <?php endif; ?>
                                            <div class="text-muted small mb-1" style="font-size: 12px; color: #878787 !important;">
                                                Seller: <?= $seller_name; ?>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold text-dark" style="font-size: 16px;">
                                                    <?= $currency_symbol . number_format($it['price'], 0); ?>
                                                </span>
                                                <?php if ((int)($it['quantity'] ?? 1) > 1): ?>
                                                    <span class="text-muted small">(Qty: <?= (int)$it['quantity']; ?>)</span>
                                                <?php endif; ?>
                                                <span class="fw-semibold text-success ms-2" style="font-size: 12px; color: #388e3c !important;">
                                                    Special Price
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($is_delivered): ?>
                                        <div class="flex-shrink-0">
                                            <a href="<?= site_url('account/rate_review/' . $order['order_number'] . '/' . $it_pid); ?>" class="btn btn-outline-primary btn-sm rounded-1 fw-semibold py-1 px-3 d-inline-flex align-items-center gap-1" style="color: #2874f0; border-color: #2874f0; font-size: 12px;">
                                                <i class="fa-solid fa-star" style="font-size: 11px;"></i> Rate & Review
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- 4. "Rate your experience" Card (Shown ONLY when delivered, for all items in the order) -->
                        <?php if ($is_delivered): ?>
                            <!-- Rate your experience Card (Shown ONLY when delivered) -->
                            <div class="card border rounded-1 p-4 mb-3 bg-white shadow-none" style="border-color: #e0e0e0 !important;">
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 15px;">Rate your experience</h6>

                                <?php foreach ($items as $idx => $ritem): ?>
                                    <?php
                                    $r_pid = (int) ($ritem['product_id'] ?? 0);
                                    $r_img = !empty($ritem['product_image']) ? base_url('assets/images/' . $ritem['product_image']) : base_url('assets/images/products/womens/women-1.jpg');
                                    $r_existing = $user_reviews[$r_pid] ?? null;
                                    $r_rating = !empty($r_existing['rating']) ? (int)$r_existing['rating'] : 0;
                                    ?>
                                    <div class="card border rounded-2 p-3 bg-light mb-2 d-flex flex-row align-items-center justify-content-between flex-wrap gap-2" style="border-color: #e0e0e0 !important; background-color: #fafafa !important;">
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?= $r_img; ?>" class="border rounded-1 flex-shrink-0" style="width: 36px; height: 36px; object-fit: contain; background: #fff;">
                                            <div>
                                                <div class="fw-semibold text-dark text-truncate" style="font-size: 13px; max-width: 300px;" title="<?= html_escape($ritem['product_title']); ?>">
                                                    <?= html_escape($ritem['product_title']); ?>
                                                </div>
                                                <div class="text-muted" style="font-size: 11px;">Rate the product</div>
                                            </div>
                                        </div>

                                        <!-- 5 Interactive Stars -->
                                        <div class="fk-order-stars d-inline-flex align-items-center gap-2">
                                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                                <i class="<?= ($r_rating >= $s) ? 'fa-solid text-warning' : 'fa-regular text-secondary'; ?> fa-star order-star-btn" 
                                                   style="cursor: pointer; font-size: 20px; color: <?= ($r_rating >= $s) ? '#ff9f00' : '#878787'; ?>;"
                                                   onclick="handleStarClick(<?= $s; ?>, <?= $r_pid; ?>)"></i>
                                            <?php endfor; ?>

                                            <?php if ($r_rating > 0): ?>
                                                <a href="<?= site_url('account/rate_review/' . $order['order_number'] . '/' . $r_pid); ?>" class="fw-semibold small ms-2 text-decoration-none" style="color: #2874f0 !important; font-size: 12px;">
                                                    Edit Review
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Order ID Footer Bar with Copy Button -->
                        <div class="d-flex align-items-center gap-2 text-muted small ps-1 pt-1">
                            <span>Order #<?= html_escape($order['order_number']); ?></span>
                            <button type="button" class="btn btn-sm btn-link p-0 text-muted text-decoration-none" onclick="copyOrderNumber('<?= html_escape($order['order_number']); ?>')" title="Copy Order ID">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                            <span id="copy-success-msg" class="text-success small fw-semibold d-none">Copied!</span>
                        </div>
                    </div>

                    <!-- Right Column: Delivery Details & Price Details (Col 4) -->
                    <div class="col-lg-4 col-md-4 col-12">

                        <!-- Delivery details Card (Matching new_order_details.PNG) -->
                        <div class="card border rounded-1 p-3 mb-3 bg-white shadow-none" style="border-color: #e0e0e0 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">Delivery details</h6>
                                <button class="btn btn-sm p-0 d-inline-flex align-items-center justify-content-center border-0 rounded bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#deliveryDetailsBody" aria-expanded="true" style="width: 26px; height: 26px;">
                                    <i class="fa-solid fa-chevron-up text-muted" style="font-size: 11px;"></i>
                                </button>
                            </div>

                            <div class="collapse show" id="deliveryDetailsBody">
                                <div class="p-3 rounded-2" style="background-color: #f8f9fa; border: 1px solid #f0f0f0;">
                                    <!-- Address Line with Icon and Type (Home/Work) -->
                                    <div class="d-flex align-items-start gap-2 mb-2" style="font-size: 13px; line-height: 1.45;">
                                        <i class="<?= $addr_icon; ?> text-secondary mt-1 flex-shrink-0" style="font-size: 13px;"></i>
                                        <div>
                                            <strong class="text-dark me-1"><?= $addr_type_label; ?></strong>
                                            <span class="text-secondary"><?= html_escape($display_address); ?></span>
                                        </div>
                                    </div>

                                    <!-- Recipient Name and Phone -->
                                    <div class="d-flex align-items-center gap-2" style="font-size: 13px;">
                                        <i class="fa-regular fa-user text-secondary flex-shrink-0" style="font-size: 13px;"></i>
                                        <div>
                                            <strong class="text-dark me-2"><?= html_escape($recipient_name); ?></strong>
                                            <span class="text-secondary"><?= html_escape($recipient_phone); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price details Card (Collapsible) -->
                        <div class="card border rounded-1 p-3 mb-3 bg-white shadow-none" style="border-color: #e0e0e0 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">Price details</h6>
                                <button class="btn btn-sm p-0 d-inline-flex align-items-center justify-content-center border-0 rounded bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#priceDetailsBody" aria-expanded="true" style="width: 26px; height: 26px;">
                                    <i class="fa-solid fa-chevron-up text-muted" style="font-size: 11px;"></i>
                                </button>
                            </div>

                            <div class="collapse show" id="priceDetailsBody">
                                <!-- Listing price -->
                                <div class="d-flex justify-content-between text-secondary mb-2" style="font-size: 13px;">
                                    <span>Listing price</span>
                                    <span><?= $currency_symbol . number_format($listing_price, 0); ?></span>
                                </div>

                                <!-- Selling price -->
                                <div class="d-flex justify-content-between text-secondary mb-2" style="font-size: 13px;">
                                    <span>Selling price <i class="fa-regular fa-circle-question text-muted" style="font-size: 11px;"></i></span>
                                    <span><?= $currency_symbol . number_format($subtotal, 0); ?></span>
                                </div>

                                <!-- Other discount -->
                                <?php if ($discount > 0): ?>
                                    <div class="d-flex justify-content-between text-success mb-2" style="font-size: 13px;">
                                        <span>Other discount <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></span>
                                        <span>-<?= $currency_symbol . number_format($discount, 0); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Dotted Divider -->
                                <div class="my-2" style="border-top: 1px dashed #e0e0e0;"></div>

                                <!-- Total amount -->
                                <div class="d-flex justify-content-between fw-bold text-dark mb-3" style="font-size: 14px;">
                                    <span>Total amount</span>
                                    <span><?= $currency_symbol . number_format($total, 0); ?></span>
                                </div>

                                <!-- Paid By -->
                                <div class="d-flex justify-content-between align-items-center text-secondary <?= $is_delivered ? 'mb-3' : 'mb-0'; ?>" style="font-size: 13px;">
                                    <span>Paid By</span>
                                    <span class="badge bg-light text-dark border px-2 py-1 fw-bold">
                                        <i class="fa-solid fa-wallet text-primary me-1"></i> <?= strtoupper($order['payment_method'] ?? 'UPI'); ?>
                                    </span>
                                </div>

                                <?php // Download Invoice Button (Only shown after order is delivered) ?>
                                <?php if ($is_delivered): ?>
                                    <a href="<?= site_url('account/invoice/' . $order['order_number']); ?>" target="_blank" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 fw-semibold rounded-1 mt-3" style="border-color: #d1d5db; color: #212121; font-size: 14px;">
                                        <i class="fa-solid fa-download"></i>
                                        <span>Download Invoice</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Offers earned Card (Collapsible) -->
                        <div class="card border rounded-1 p-3 bg-white shadow-none" style="border-color: #e0e0e0 !important;">
                            <div class="d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#offersList">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-award text-success fs-5"></i>
                                    <span class="fw-semibold text-dark" style="font-size: 13px;">Offers earned</span>
                                </div>
                                <i class="fa-solid fa-chevron-down text-muted" style="font-size: 12px;"></i>
                            </div>
                            <div class="collapse mt-2 pt-2 border-top" id="offersList">
                                <div class="small text-muted"><i class="fa-solid fa-check text-success me-1"></i> Special platform discount applied</div>
                                <div class="small text-muted mt-1"><i class="fa-solid fa-check text-success me-1"></i> Free delivery on this order</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- /order-details-section -->

        <!-- Chat Support Modal -->
        <div class="modal fade" id="chatSupportModal" tabindex="-1" aria-labelledby="chatSupportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-1 border-0 shadow">
                    <div class="modal-header border-bottom py-3">
                        <h6 class="modal-title fw-bold text-dark" id="chatSupportModalLabel"><i class="fa-regular fa-comment-dots text-primary me-2"></i>Customer Support</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-headset text-primary" style="font-size: 44px;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Need help with Order #<?= html_escape($order['order_number']); ?>?</h6>
                        <p class="text-secondary small mb-3">Our dedicated customer assistance team is here to assist with tracking, returns, and refunds.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="mailto:support@ecommerce.com?subject=Help with Order <?= html_escape($order['order_number']); ?>" class="btn btn-outline-primary btn-sm rounded-1 px-3">
                                <i class="fa-regular fa-envelope me-1"></i> Email Us
                            </a>
                            <a href="https://wa.me/?text=Hi%2C%20I%20need%20help%20with%20Order%20<?= html_escape($order['order_number']); ?>" target="_blank" class="btn btn-success btn-sm rounded-1 px-3">
                                <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .fk-orders-container {
            max-width: 1680px;
            min-width: 978px;
            margin: 0 auto;
        }
        @media (max-width: 991px) {
            .fk-orders-container {
                min-width: 100% !important;
                max-width: 100% !important;
            }
        }
        .order-star-btn:hover {
            transform: scale(1.15);
        }
        </style>

        <script>
        function toggleTrackingUpdates() {
            var box = document.getElementById('tracking-updates-box');
            if (box) {
                box.classList.toggle('d-none');
            }
        }

        function copyOrderNumber(num) {
            navigator.clipboard.writeText(num).then(function() {
                var msg = document.getElementById('copy-success-msg');
                if (msg) {
                    msg.classList.remove('d-none');
                    setTimeout(function() {
                        msg.classList.add('d-none');
                    }, 2000);
                }
            });
        }

        function copyAwbCode(awb) {
            navigator.clipboard.writeText(awb).then(function() {
                var el = document.getElementById('awb-copy-alert');
                if (el) {
                    el.classList.remove('d-none');
                    setTimeout(function() {
                        el.classList.add('d-none');
                    }, 2000);
                }
            });
        }

        function handleStarClick(rating, productId) {
            var orderNumber = '<?= html_escape($order['order_number']); ?>';
            var csrfName = '<?= $csrf_name; ?>';
            var csrfHash = '<?= $csrf_hash; ?>';

            // Send rating via quick AJAX
            var fd = new FormData();
            fd.append('order_number', orderNumber);
            fd.append('product_id', productId);
            fd.append('rating', rating);
            fd.append(csrfName, csrfHash);

            fetch('<?= site_url('account/quick_rate'); ?>', {
                method: 'POST',
                body: fd
            }).then(function(res) {
                return res.json();
            }).then(function(data) {
                // Navigate to rate and review form with selected rating
                window.location.href = '<?= site_url('account/rate_review/' . $order['order_number']); ?>/' + productId + '?rating=' + rating;
            }).catch(function(err) {
                window.location.href = '<?= site_url('account/rate_review/' . $order['order_number']); ?>/' + productId + '?rating=' + rating;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            ['deliveryDetailsBody', 'priceDetailsBody'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) {
                    el.addEventListener('show.bs.collapse', function() {
                        var icon = document.querySelector('[data-bs-target="#' + id + '"] i');
                        if (icon) {
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-up');
                        }
                    });
                    el.addEventListener('hide.bs.collapse', function() {
                        var icon = document.querySelector('[data-bs-target="#' + id + '"] i');
                        if (icon) {
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        }
                    });
                }
            });
        });
        </script>
