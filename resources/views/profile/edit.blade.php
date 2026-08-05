<x-layouts.account title="Profile & Password">
    <h1 class="text-2xl font-bold mb-8">Profile &amp; Password</h1>

    <div class="space-y-10">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="max-w-xl border-t border-gray-100 pt-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="max-w-xl border-t border-gray-100 pt-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-layouts.account>
