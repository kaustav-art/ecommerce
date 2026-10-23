<?php
$curr_tpl = $active_template ?? 'fashion';
$saas_root = rtrim( str_replace('/website', '', rtrim(base_url(), '/')), '/' ) . '/';
?>
<div id="saas-demo-preview-bar" style="position:fixed;bottom:18px;left:50%;transform:translateX(-50%);z-index:99999;background:rgba(15,23,42,0.95);backdrop-filter:blur(12px);border:1px solid rgba(99,102,241,0.5);border-radius:999px;padding:10px 18px;display:flex;align-items:center;gap:12px;box-shadow:0 20px 40px rgba(0,0,0,0.45);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;flex-wrap:wrap;max-width:95vw;">
    <span style="background:linear-gradient(135deg,#6366f1,#ec4899);padding:4px 11px;border-radius:999px;font-weight:700;font-size:11px;letter-spacing:0.04em;text-transform:uppercase;">
        Live Template Demo
    </span>
    <div style="display:flex;align-items:center;gap:6px;">
        <a href="<?= base_url('home?preview_tpl=fashion') ?>" style="padding:5px 12px;border-radius:999px;text-decoration:none;font-weight:600;color:<?= $curr_tpl === 'fashion' ? '#fff' : '#94a3b8' ?>;background:<?= $curr_tpl === 'fashion' ? 'rgba(99,102,241,0.35)' : 'transparent' ?>;">1. Fashion</a>
        <a href="<?= base_url('home?preview_tpl=electronics') ?>" style="padding:5px 12px;border-radius:999px;text-decoration:none;font-weight:600;color:<?= $curr_tpl === 'electronics' ? '#fff' : '#94a3b8' ?>;background:<?= $curr_tpl === 'electronics' ? 'rgba(99,102,241,0.35)' : 'transparent' ?>;">2. Electronics</a>
        <a href="<?= base_url('home?preview_tpl=grocery') ?>" style="padding:5px 12px;border-radius:999px;text-decoration:none;font-weight:600;color:<?= $curr_tpl === 'grocery' ? '#fff' : '#94a3b8' ?>;background:<?= $curr_tpl === 'grocery' ? 'rgba(99,102,241,0.35)' : 'transparent' ?>;">3. Grocery</a>
    </div>
    <a href="<?= $saas_root ?>subscribe.php?tpl=<?= urlencode($curr_tpl) ?>" style="background:#10b981;color:#fff;padding:6px 14px;border-radius:999px;text-decoration:none;font-weight:700;">
        Use This Template →
    </a>
    <a href="<?= $saas_root ?>" style="color:#cbd5e1;text-decoration:none;font-size:12px;padding:0 6px;" title="Back to SaaS Landing Page">✕ Exit Demo</a>
</div>
