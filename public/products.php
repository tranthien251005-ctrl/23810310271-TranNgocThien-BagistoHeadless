<?php
// C:\xampp\htdocs\bagisto-store\public\products.php

$graphql_url = 'http://localhost:8888/bagisto-store/public/graphql';

// ✅ QUERY ĐÚNG - Bỏ url_key vì schema không hỗ trợ
$query = '
{
    products(first: 5) {
        data {
            id
            name
            price
            description
        }
    }
}
';

// Gọi API bằng cURL
$ch = curl_init($graphql_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// Xử lý lỗi cURL
if ($error) {
    die('cURL Error: ' . $error);
}

// Parse response
$data = json_decode($response, true);

// Kiểm tra lỗi GraphQL
if (isset($data['errors'])) {
    echo '<h3>❌ Lỗi GraphQL:</h3>';
    echo '<pre>';
    print_r($data['errors']);
    echo '</pre>';
    die();
}

// Lấy danh sách sản phẩm
$products = $data['data']['products']['data'] ?? [];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm - Trần Ngọc Thiện</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .student-info {
            font-size: 1.2rem;
            background: rgba(0, 0, 0, 0.2);
            display: inline-block;
            padding: 10px 25px;
            border-radius: 50px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 20px;
        }

        .product-id {
            color: #999;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e74c3c;
            margin: 15px 0;
        }

        .product-desc {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .btn-detail {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        .btn-detail:hover {
            opacity: 0.85;
        }

        .no-products {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛍️ Cửa hàng của Trần Ngọc Thiện</h1>
            <div class="student-info">📚 Trần Ngọc Thiện - MSSV: [NHẬP MSSV]</div>
        </div>

        <div class="products-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="card-body">
                            <div class="product-id">🆔 ID: <?php echo htmlspecialchars($product['id'] ?? 'N/A'); ?></div>
                            <div class="product-name">📝 <?php echo htmlspecialchars($product['name'] ?? 'Không có tên'); ?></div>
                            <div class="product-price"><?php echo number_format($product['price'] ?? 0, 0, ',', '.') . ' ₫'; ?></div>
                            <div class="product-desc">
                                <?php
                                $desc = $product['description'] ?? 'Không có mô tả';
                                echo htmlspecialchars(strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc);
                                ?>
                            </div>
                            <button class="btn-detail" onclick="alert('📦 Sản phẩm: <?php echo htmlspecialchars($product['name'] ?? ''); ?>')">
                                🔍 Xem chi tiết
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <p>⚠️ Không có sản phẩm nào.</p>
                    <p>Vui lòng tạo sản phẩm trong Admin Panel</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="footer">© 2025 - Dữ liệu từ Bagisto GraphQL API</div>
    </div>
</body>

</html>