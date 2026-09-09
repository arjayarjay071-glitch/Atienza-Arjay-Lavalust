<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>

    <h1>Product Management</h1>

    <p>
        <a href="<?= site_url('products/create') ?>">Add Product</a>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </p>

    <?php if (!empty($products)): ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['quantity']) ?></td>
                        <td><?= htmlspecialchars($product['created_at']) ?></td>
                        <td>
                            <a href="<?= site_url('products/edit/' . $product['id']) ?>">
                                Edit
                            </a>

                            |

                            <a href="<?= site_url('products/delete/' . $product['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete this product?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <p>No products found.</p>

    <?php endif; ?>

</body>
</html>