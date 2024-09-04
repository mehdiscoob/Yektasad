<!DOCTYPE html>
<html>
<head>
    <title>New Product Created</title>
</head>
<body>
<h1>New Product Created</h1>
<p><strong>Name:</strong> {{ $product->name }}</p>
<p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
<p><strong>Stock:</strong> {{ $product->stock }}</p>
</body>
</html>
