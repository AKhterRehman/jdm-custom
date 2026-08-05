<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = $request->user()->addresses()->orderByDesc('is_default')->latest()->get();

        return view('addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $request->user()->addresses()->create($validated);

        return redirect()->route('addresses.index')->with('status', 'Address added.');
    }

    public function edit(Request $request, Address $address): View
    {
        $this->authorizeOwnership($request, $address);

        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        $this->authorizeOwnership($request, $address);

        $validated = $this->validated($request);
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')->with('status', 'Address updated.');
    }

    public function destroy(Request $request, Address $address): RedirectResponse
    {
        $this->authorizeOwnership($request, $address);

        $address->delete();

        return redirect()->route('addresses.index')->with('status', 'Address removed.');
    }

    private function authorizeOwnership(Request $request, Address $address): void
    {
        abort_unless($address->user_id === $request->user()->id, 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:255'],
            'is_default' => ['sometimes', 'boolean'],
        ]);
    }
}
