<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body style="margin: 0; padding: 24px; font-family: 'Segoe UI', system-ui, sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%); min-height: 100vh; box-sizing: border-box;">
    <div style="max-width: 640px; margin: 0 auto;">
        <h1 style="margin: 0 0 24px 0; font-size: 1.75rem; font-weight: 700; color: #1a1a2e; letter-spacing: -0.02em;">Products</h1>
        <a href="{{ route('products.create') }}" style="display: inline-block; margin-bottom: 24px; padding: 10px 20px; font-size: 0.9375rem; font-weight: 600; color: #fff; background: #1a1a2e; border-radius: 8px; text-decoration: none;">Add Product</a>

        @if(session('success'))
            <p style="margin: 0 0 24px 0; padding: 14px 18px; background: #d4edda; color: #155724; border-radius: 8px; border: 1px solid #c3e6cb;">{{ session('success') }}</p>
        @endif
        @if(isset($products))
            @forelse($products as $product)
                <div class="product" style="background: #fff; border-radius: 12px; padding: 20px 24px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.06);">
                    <p style="margin: 0 0 8px 0; font-size: 1rem; color: #333;"><strong style="color: #1a1a2e;">Name:</strong> {{ $product->name }}</p>
                    <p style="margin: 0; font-size: 1.125rem; font-weight: 600; color: #2d5a27;"><strong style="color: #1a1a2e;">Price:</strong> {{ number_format($product->price, 2) }}</p>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('products.edit', $product) }}" style="display: inline-block; padding: 8px 16px; font-size: 0.875rem; font-weight: 600; color: #1a1a2e; background: #eee; border-radius: 8px; text-decoration: none;">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="margin: 0; display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 8px 16px; font-size: 0.875rem; font-weight: 600; color: #fff; background: #c00; border: none; border-radius: 8px; cursor: pointer;">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p style="margin: 0; padding: 24px; background: #fff; border-radius: 12px; color: #666; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">No products yet.</p>
            @endforelse
        @else
            <p style="margin: 0; padding: 24px; background: #fff; border-radius: 12px; color: #666; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">No products data.</p>
        @endisset
    </div>
</body>
</html>
