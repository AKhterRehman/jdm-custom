<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = User::withCount('orders')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        $customer->load(['orders' => fn ($q) => $q->latest(), 'addresses']);

        return view('admin.customers.show', compact('customer'));
    }

    public function toggleAdmin(Request $request, User $customer): RedirectResponse
    {
        abort_if($customer->id === $request->user()->id, 403, "You can't change your own admin status.");

        $customer->update(['is_admin' => ! $customer->is_admin]);

        return back()->with('status', 'Customer updated.');
    }
}
