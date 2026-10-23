<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Unavailable — <?= htmlspecialchars($tenant['business_name'] ?? 'Online Store') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .box {
            max-width: 540px;
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 42px 36px;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(239,68,68,0.2);
            color: #fca5a5;
            font-weight: 700;
            font-size: 0.82rem;
            margin-bottom: 16px;
        }
        h1 { margin: 0 0 12px; font-size: 1.75rem; }
        p { color: #94a3b8; line-height: 1.6; margin-bottom: 26px; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 10px;
            background: #6366f1;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
        }
    </style>
</head>
<body>
    <div class="box">
        <span class="badge"><?= htmlspecialchars(strtoupper($reason ?? 'Store Unavailable')) ?></span>
        <h1><?= htmlspecialchars($tenant['business_name'] ?? 'This Store') ?> Is Currently Unavailable</h1>
        <p><?= htmlspecialchars($message ?? 'This tenant store is currently suspended or its subscription has expired. If you are the store owner, please log in to your dashboard to renew or reactivate your subscription.') ?></p>
        <a href="<?= base_url('../admin/auth/login') ?>" class="btn">Store Owner Login</a>
    </div>
</body>
</html>
