<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body style="margin: 0; padding: 24px; font-family: 'Segoe UI', system-ui, sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%); min-height: 100vh; box-sizing: border-box;">
    <div style="max-width: 480px; margin: 0 auto;">
        <h1 style="margin: 0 0 24px 0; font-size: 1.75rem; font-weight: 700; color: #1a1a2e;">Edit Product</h1>

        <form action="{{ route('products.update', $product) }}" method="POST" style="background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.06);">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 20px;">
                <label for="name" style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a1a2e;">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    style="width: 100%; padding: 10px 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                @error('name')
                    <p style="margin: 6px 0 0 0; font-size: 0.875rem; color: #c00;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 24px;">
                <label for="price" style="display: block; margin-bottom: 6px; font-weight: 600; color: #1a1a2e;">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="1" required
                    style="width: 100%; padding: 10px 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
                @error('price')
                    <p style="margin: 6px 0 0 0; font-size: 0.875rem; color: #c00;">{{ $message }}</p>
                @enderror
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="submit" style="padding: 10px 20px; font-size: 1rem; font-weight: 600; color: #fff; background: #1a1a2e; border: none; border-radius: 8px; cursor: pointer;">Update</button>
                <a href="{{ route('products.index') }}" style="padding: 10px 20px; font-size: 1rem; color: #1a1a2e; background: #eee; border-radius: 8px; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
