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
    <input type="text" name="label" value="{{ old('label', $address->label ?? 'Home') }}" placeholder="Label (e.g. Home, Office)" class="rounded-md border-gray-300 text-sm sm:col-span-2">
    <input type="text" name="full_name" value="{{ old('full_name', $address->full_name ?? '') }}" placeholder="Full name" required class="rounded-md border-gray-300 text-sm">
    <input type="text" name="phone" value="{{ old('phone', $address->phone ?? '') }}" placeholder="Phone" required class="rounded-md border-gray-300 text-sm">
    <input type="text" name="address_line1" value="{{ old('address_line1', $address->address_line1 ?? '') }}" placeholder="Address line 1" required class="rounded-md border-gray-300 text-sm sm:col-span-2">
    <input type="text" name="address_line2" value="{{ old('address_line2', $address->address_line2 ?? '') }}" placeholder="Address line 2 (optional)" class="rounded-md border-gray-300 text-sm sm:col-span-2">
    <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" placeholder="City" required class="rounded-md border-gray-300 text-sm">
    <input type="text" name="state" value="{{ old('state', $address->state ?? '') }}" placeholder="State / Province" class="rounded-md border-gray-300 text-sm">
    <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" placeholder="Postal code" class="rounded-md border-gray-300 text-sm">
    <input type="text" name="country" value="{{ old('country', $address->country ?? '') }}" placeholder="Country" required class="rounded-md border-gray-300 text-sm">

    <label class="flex items-center gap-2 text-sm sm:col-span-2">
        <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>
        Set as default address
    </label>
</div>

<button type="submit" class="mt-6 rounded-md bg-gray-900 px-6 py-3 font-semibold text-white hover:bg-red-600 transition">
    Save Address
</button>
