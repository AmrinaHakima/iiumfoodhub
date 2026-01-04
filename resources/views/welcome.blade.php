<?php
// Mock Data



$cafes = [
    ['id' => 1, 'name' => 'Cafe Halimah', 'location' => 'Mahallah Halimatus Saadiah', 'time' => '8:00 AM - 10:00 PM', 'status' => 'Open'],
    ['id' => 2, 'name' => 'Faruk-Uthman Dine', 'location' => 'Mahallah Faruq', 'time' => '8:00 AM - 10:00 PM', 'status' => 'Open'],
    ['id' => 3, 'name' => 'Cafe Sumayyah', 'location' => 'Mahallah Sumayyah', 'time' => '8:00 AM - 10:00 PM', 'status' => 'Closed'],
];

$menu = [
    'Food' => [
        ['name' => 'Mee Tarik', 'price' => 8.00, 'desc' => 'Hand-pulled noodle top with celery leaves...', 'img' => 'https://via.placeholder.com/80'],
    ],
    'Drinks' => [
        ['name' => 'Teh Ais', 'price' => 2.00, 'desc' => 'Iced tea with condensed milk', 'img' => 'https://via.placeholder.com/80'],
        ['name' => 'Milo Ais', 'price' => 3.00, 'desc' => 'Iced chocolate', 'img' => 'https://via.placeholder.com/80'],
    ]
];

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$cart_count = ($page == 'menu_cart') ? 1 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIUMFoodHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #55b9c2; --bg: #f5f5f5; --text-dark: #333; --text-light: #777; }
        body { font-family: 'Segoe UI', sans-serif; background: #333; margin: 0; display: flex; justify-content: center; }
        
        /* Mobile Frame Container */
        .phone-screen { 
            width: 375px; height: 812px; background: white; 
            position: relative; overflow-y: auto; overflow-x: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin: 20px;
        }

        /* Header */
        header { background: var(--primary); color: white; padding: 20px; }
        .header-top { display: flex; justify-content: space-between; align-items: center; }
        .header-top h1 { margin: 0; font-size: 24px; font-weight: bold; }
        .cart-icon { position: relative; font-size: 20px; cursor: pointer; }
        .badge { 
            position: absolute; top: -8px; right: -10px; background: red; 
            color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; 
        }

        /* Cafe List Screen */
        .content { padding: 20px; }
        .title-sec h2 { margin-bottom: 5px; font-size: 18px; color: var(--text-dark); }
        .title-sec p { color: var(--text-light); font-size: 14px; margin-top: 0; }

        .card { 
            background: #fff; border-radius: 15px; padding: 20px; margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #eee;
            text-decoration: none; display: block; color: inherit;
        }
        .card-header { display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { margin: 0; font-size: 16px; }
        .status { font-weight: bold; font-size: 14px; }
        .status.Open { color: #4caf50; }
        .status.Closed { color: #f44336; }
        .info { font-size: 13px; color: var(--text-light); margin-top: 10px; }
        .info i { width: 20px; }

        /* Menu Screen */
        .back-nav { display: flex; align-items: center; padding: 15px 20px; border-bottom: 1px solid #eee; }
        .back-nav i { font-size: 18px; margin-right: 15px; cursor: pointer; }
        .back-nav h3 { margin: 0; font-size: 16px; }
        .back-nav p { margin: 0; font-size: 13px; color: var(--text-light); }

        .category-title { font-weight: bold; margin: 20px 0 10px; font-size: 16px; }
        .menu-item { 
            display: flex; background: white; border-radius: 15px; 
            padding: 10px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            align-items: center;
        }
        .menu-item img { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; }
        .menu-details { flex-grow: 1; padding: 0 10px; }
        .menu-details h4 { margin: 0; font-size: 14px; display: flex; justify-content: space-between; }
        .price { color: var(--primary); }
        .menu-details p { font-size: 11px; color: var(--text-light); margin: 5px 0; }
        .add-btn { 
            background: var(--primary); color: white; border: none; 
            border-radius: 8px; width: 100%; padding: 5px; font-size: 13px; cursor: pointer;
        }

        /* View Cart Bar */
        .cart-bar {
            position: absolute; bottom: 0; left: 0; right: 0; background: white;
            padding: 15px 20px; display: flex; justify-content: space-between;
            align-items: center; box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        }
        .view-cart-btn {
            background: var(--primary); color: white; padding: 10px 20px;
            border-radius: 10px; text-decoration: none; font-size: 14px;
            display: flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body>

<div class="phone-screen">
    <!-- Header Component -->
    <header>
        <div class="header-top">
            <h1>IIUMFoodHub</h1>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php if($cart_count > 0): ?><span class="badge"><?= $cart_count ?></span><?php endif; ?>
            </div>
        </div>
        <p style="margin: 5px 0 0; font-size: 14px; opacity: 0.9;">Place your order</p>
    </header>

    <?php if ($page == 'home'): ?>
        <!-- PAGE 4: Select a Cafe -->
        <div class="content">
            <div class="title-sec">
                <h2>Select a Cafe</h2>
                <p>Choose from available cafes in IIUM</p>
            </div>

            <?php foreach($cafes as $cafe): ?>
                <a href="?page=menu&cafe=<?= $cafe['id'] ?>" class="card">
                    <div class="card-header">
                        <h3><?= $cafe['name'] ?></h3>
                        <span class="status <?= $cafe['status'] ?>"><?= $cafe['status'] ?></span>
                    </div>
                    <div class="info">
                        <p><i class="fas fa-location-dot"></i> <?= $cafe['location'] ?></p>
                        <p><i class="far fa-clock"></i> <?= $cafe['time'] ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    <?php elseif ($page == 'menu' || $page == 'menu_cart'): ?>
        <!-- PAGE 5 & 6: Cafe Menu -->
        <div class="back-nav" onclick="window.location.href='?page=home'">
            <i class="fas fa-chevron-left"></i>
            <div>
                <h3>Faruk-Uthman Dine</h3>
                <p>Mahallah Faruq</p>
            </div>
        </div>

        <div class="content" style="padding-bottom: 80px;">
            <?php foreach($menu as $cat => $items): ?>
                <div class="category-title"><?= $cat ?></div>
                <?php foreach($items as $item): ?>
                    <div class="menu-item">
                        <img src="<?= $item['img'] ?>" alt="Food">
                        <div class="menu-details">
                            <h4>
                                <span><?= $item['name'] ?></span>
                                <span class="price">RM <?= number_format($item['price'], 2) ?></span>
                            </h4>
                            <p><?= $item['desc'] ?></p>
                            <button class="add-btn" onclick="window.location.href='?page=menu_cart'">+ Add</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>

        <?php if ($page == 'menu_cart'): ?>
            <!-- PAGE 6 Bottom Bar -->
            <div class="cart-bar">
                <span style="font-size: 14px;">1 item in cart</span>
                <a href="#" class="view-cart-btn">
                    <i class="fas fa-shopping-cart"></i> View cart
                </a>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

</body>
</html>