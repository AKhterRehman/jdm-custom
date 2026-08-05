@if ($errors->any())
    <div class="mb-6 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid sm:grid-cols-2 gap-4 max-w-xl">
    <div class="sm:col-span-2">
        <label class="text-sm font-medium text-gray-700">Code</label>
        <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 text-sm uppercase">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Type</label>
        <select name="type" class="mt-1 w-full rounded-md border-gray-300 text-sm">
            <option value="percentage" @selected(old('type', $coupon->type ?? '') === 'percentage')>Percentage</option>
            <option value="fixed" @selected(old('type', $coupon->type ?? '') === 'fixed')>Fixed Amount</option>
        </select>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Value</label>
        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value ?? '') }}" required class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Minimum Order Amount (optional)</label>
        <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Max Uses (optional)</label>
        <input type="number" name="max_uses" value="{{ old('max_uses', $coupon->max_uses ?? '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700">Expires At (optional)</label>
        <input type="date" name="expires_at" value="{{ old('expires_at', isset($coupon) ? $coupon->expires_at?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </div>

    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
        Active
    </label>
</div>

<button type="submit" class="mt-6 rounded-md bg-gray-900 px-6 py-3 font-semibold text-white hover:bg-red-600 transition">
    Save Coupon
</button>
