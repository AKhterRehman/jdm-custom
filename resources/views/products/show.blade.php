<x-layouts.storefront :title="$product->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <nav class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-red-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('category.show', $product->category) }}" class="hover:text-red-600">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-600">{{ $product->name }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-16">
            <div>
                <div class="aspect-square overflow-hidden rounded-xl bg-gray-100 shadow-sm">
                    @if ($product->images->first())
                        <img src="{{ $product->images->first()->url() }}" alt="{{ $product->images->first()->alt_text }}" class="h-full w-full object-cover">
                    @endif
                </div>

                @if ($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($product->images->skip(1) as $image)
                            <img src="{{ $image->url() }}" alt="{{ $image->alt_text }}" class="aspect-square rounded-md object-cover bg-gray-100">
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-red-600 mb-2">{{ $product->category->name }}</p>
                <h1 class="font-heading text-3xl sm:text-4xl font-bold text-ink-900">{{ $product->name }}</h1>
                <p class="mt-3 text-gray-600 leading-relaxed">{{ $product->short_description }}</p>

                <div class="mt-6">
                    @if ($product->sale_price)
                        <span class="text-3xl font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="ml-2 text-lg text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="text-3xl font-bold text-ink-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <p class="mt-2 text-sm font-medium {{ $product->available_stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->available_stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </p>

                <div x-data="{ quantity: 1, available: {{ max(0, (int) $product->available_stock_quantity) }} }">
                @if (auth()->check() && auth()->user()->is_admin)
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Total Stock Quantity</p>
                            <p class="mt-1 text-lg font-bold text-ink-900">{{ $product->total_stock_quantity }}</p>
                        </div>
                        <div class="rounded-lg border border-green-100 bg-green-50 px-4 py-3">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-green-700">Available Stock Quantity</p>
                            <p class="mt-1 text-lg font-bold text-green-700" x-text="available">{{ $product->available_stock_quantity }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->has('quantity'))
                    <p class="mt-4 text-sm font-medium text-red-600">{{ $errors->first('quantity') }}</p>
                @endif

                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    @if ($product->variations->isNotEmpty())
                        <div class="mt-6 space-y-4">
                            @foreach ($product->variations->groupBy('attribute_name') as $attributeName => $options)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">{{ $attributeName }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($options as $option)
                                            <label class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium cursor-pointer transition has-[:checked]:border-red-600 has-[:checked]:bg-red-50 has-[:checked]:text-red-600">
                                                <input type="radio" name="product_variation_id" value="{{ $option->id }}" required class="sr-only"
                                                    x-on:change="available = Math.min({{ max(0, (int) $product->available_stock_quantity) }}, {{ max(0, (int) $option->stock_quantity) }}); if (quantity > available) quantity = available">
                                                {{ $option->attribute_value }}
                                                @if ($option->price_adjustment > 0)
                                                    <span class="text-gray-400">(+${{ number_format($option->price_adjustment, 2) }})</span>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <input type="number" name="quantity" min="1" :max="available" x-model.number="quantity"
                            @input="quantity = Math.min(Math.max(Number($event.target.value) || 1, 1), available)"
                            class="w-full sm:w-24 rounded-md border-gray-300">
                        <button type="submit" @disabled($product->available_stock_quantity <= 0) :disabled="available < 1"
                            class="flex-1 rounded-md border border-ink-900 bg-white px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-ink-900 hover:border-red-600 hover:text-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Add to Cart
                        </button>
                        <button type="submit" formaction="{{ route('cart.buy-now') }}" @disabled($product->available_stock_quantity <= 0) :disabled="available < 1"
                            class="flex-1 rounded-md bg-ink-900 px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-white hover:bg-red-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Buy Now
                        </button>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">You can add up to <span class="font-semibold text-ink-900" x-text="available"></span> item(s) to your cart.</p>
                </form>
                </div>

                <form action="{{ route('wishlist.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition">&hearts; Add to Wishlist</button>
                </form>

                @if ($product->description)
                    <div class="mt-10 border-t border-gray-100 pt-6">
                        <h2 class="font-heading font-semibold text-ink-900 mb-2">Description</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                @if ($product->specifications->isNotEmpty())
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <h2 class="font-heading font-semibold text-ink-900 mb-3">Specifications</h2>
                        <dl class="divide-y divide-gray-100 text-sm">
                            @foreach ($product->specifications as $spec)
                                <div class="flex justify-between py-2.5">
                                    <dt class="text-gray-500">{{ $spec->spec_key }}</dt>
                                    <dd class="text-ink-900 font-medium">{{ $spec->spec_value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>

        @php
            $initialsFor = function ($name) {
                return collect(explode(' ', trim($name)))
                    ->filter()
                    ->take(2)
                    ->map(fn ($part) => str($part)->substr(0, 1)->upper())
                    ->join('');
            };

            $renderStars = function (int $rating, int $max = 5, string $filledClass = 'text-amber-400', string $emptyClass = 'text-gray-300') {
                $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">';
                $output = '';

                for ($i = 1; $i <= $max; $i++) {
                    $output .= $svg . '<path class="' . ($i <= $rating ? $filledClass : $emptyClass) . '" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.195 3.674a1 1 0 0 0 .95.69h3.864c.969 0 1.371 1.24.588 1.81l-3.126 2.271a1 1 0 0 0-.364 1.118l1.194 3.674c.3.922-.755 1.688-1.538 1.118l-3.126-2.271a1 1 0 0 0-1.176 0l-3.126 2.271c-.783.57-1.838-.196-1.538-1.118l1.194-3.674a1 1 0 0 0-.364-1.118L2.452 9.101c-.783-.57-.38-1.81.588-1.81h3.864a1 1 0 0 0 .95-.69l1.195-3.674Z" />' . '</svg>';
                }

                return $output;
            };

            $videoMimeType = function (string $path): string {
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

                return match ($extension) {
                    'mp4' => 'video/mp4',
                    'webm' => 'video/webm',
                    'mov' => 'video/quicktime',
                    'm4v' => 'video/x-m4v',
                    'ogg' => 'video/ogg',
                    default => 'video/mp4',
                };
            };
        @endphp

        <section id="reviews" class="mt-20 rounded-xl border border-gray-200 bg-gray-50 p-6 sm:p-8 lg:p-10">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between mb-8">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">Product Reviews</p>
                    <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900">Reviews for {{ $product->name }}</h2>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="inline-flex items-center gap-3 rounded-full border border-red-100 bg-white px-4 py-2 shadow-sm w-fit">
                        <div class="flex" aria-label="{{ $averageRating }} out of 5 stars">
                            {!! $renderStars((int) round($averageRating), 5) !!}
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wide text-ink-900">{{ $reviewCount ? $averageRating.' / 5 from '.$reviewCount.' '.str('review')->plural($reviewCount) : 'No reviews yet' }}</span>
                    </div>
                    @auth
                        @if ($canReview)
                        <button type="button" data-open-review-modal class="inline-flex items-center justify-center rounded-md bg-red-600 px-5 py-2.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-red-500">
                            Write a Review
                        </button>
                        @elseif ($hasReviewed)
                            <span class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold uppercase tracking-wide text-gray-500">
                                Review Submitted
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold uppercase tracking-wide text-gray-500">
                                Available After Delivery
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-red-600 px-5 py-2.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-red-500">
                            Sign In to Review
                        </a>
                    @endauth
                </div>
            </div>

            <div class="space-y-4">
                    @forelse ($product->reviews as $review)
                        @php
                            $reviewMedia = collect($review->image_paths)
                                ->map(fn ($imagePath) => [
                                    'type' => 'image',
                                    'src' => asset('storage/'.$imagePath),
                                    'alt' => 'Customer uploaded product photo',
                                ])
                                ->merge(
                                    collect($review->video_paths)->map(fn ($videoPath) => [
                                        'type' => 'video',
                                        'src' => Storage::url($videoPath),
                                        'mime' => $videoMimeType($videoPath),
                                    ])
                                )
                                ->values();
                        @endphp
                        <article
                            x-data="{ selectedMedia: null }"
                            class="rounded-lg border border-gray-200 bg-white p-5 transition duration-300 ease-out hover:-translate-y-1 hover:border-red-200 hover:shadow-lg hover:shadow-red-950/10"
                        >
                            <div class="flex items-start gap-4">
                                @if ($review->user->profile_image_path)
                                    <img src="{{ asset('storage/'.$review->user->profile_image_path) }}" alt="{{ $review->user->name }}" class="h-11 w-11 rounded-full object-cover ring-2 ring-red-100">
                                @else
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-ink-900 font-heading text-sm font-bold uppercase text-white ring-2 ring-red-100">
                                        {{ $initialsFor($review->user->name) }}
                                    </span>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div>
                                            <p class="font-heading font-semibold text-ink-900">{{ $review->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $review->created_at->format('M j, Y') }}</p>
                                        </div>
                                        <div class="flex" aria-label="{{ $review->rating }} out of 5 stars">
                                            {!! $renderStars((int) $review->rating, 5) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-3 text-sm leading-relaxed text-gray-600">"{{ $review->review }}"</p>

                            @if ($reviewMedia->isNotEmpty())
                                <div class="mt-5 space-y-3">
                                    <div class="flex flex-wrap gap-3">
                                        @foreach ($reviewMedia as $media)
                                            <button
                                                type="button"
                                                @click="selectedMedia = @js($media)"
                                                :class="selectedMedia?.src === @js($media['src']) ? 'border-red-500 ring-2 ring-red-100' : 'border-gray-200'"
                                                class="h-24 w-24 overflow-hidden rounded-lg border bg-gray-100 text-left shadow-sm transition hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-100"
                                                aria-label="{{ $media['type'] === 'image' ? 'Show customer uploaded product photo' : 'Show customer uploaded product video' }}"
                                            >
                                                @if ($media['type'] === 'image')
                                                    <img src="{{ $media['src'] }}" alt="{{ $media['alt'] }}" class="h-full w-full object-cover">
                                                @else
                                                    <span class="relative block h-full w-full bg-black">
                                                        <video preload="metadata" muted playsinline class="h-full w-full object-cover">
                                                            <source src="{{ $media['src'] }}" type="{{ $media['mime'] }}">
                                                        </video>
                                                        <span class="absolute inset-0 flex items-center justify-center bg-black/35 text-white">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                                <path d="M8 5v14l11-7z" />
                                                            </svg>
                                                        </span>
                                                    </span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                    <div x-show="selectedMedia" x-cloak class="flex h-28  items-center overflow-hidden sm:h-40">
                                        <template x-if="selectedMedia?.type === 'image'">
                                            <img :src="selectedMedia.src" :alt="selectedMedia.alt" class="h-28 object-contain sm:h-40">
                                        </template>
                                        <template x-if="selectedMedia?.type === 'video'">
                                            <video :key="selectedMedia.src" controls preload="metadata" playsinline class=" bg-black object-contain" style="height: 180px;"> 
                                                <source :src="selectedMedia.src" :type="selectedMedia.mime">
                                            </video>
                                        </template>
                                    </div>
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-300 bg-white p-6 text-center">
                            <p class="font-heading font-semibold text-ink-900">No reviews yet</p>
                            <p class="mt-2 text-sm text-gray-500">Be the first to share how this piece worked for your space or gift.</p>
                        </div>
                    @endforelse
            </div>
        </section>

        <div id="review-modal" data-review-modal-open="{{ ($canReview && ($errors->review->any() || session('review_status'))) ? 'true' : 'false' }}" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/60 px-4 py-4 sm:items-center">
            <div class="my-auto max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-4 shadow-2xl sm:max-h-[88vh] sm:p-6">
                <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-3">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-red-600">Add Review</p>
                        <h3 class="font-heading text-lg font-bold text-ink-900">Share your thoughts</h3>
                    </div>
                    <button type="button" data-close-review-modal class="rounded-full border border-gray-200 p-1.5 text-gray-500 transition hover:border-red-200 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @auth
                    @if ($canReview)
                    <form action="{{ route('product.review', $product) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                        @csrf

                        @if (session('review_status'))
                            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                                {{ session('review_status') }}
                            </div>
                        @endif

                        <div>
                            <p class="mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Your Rating</p>
                            <div id="review-stars" class="flex flex-wrap gap-1.5" aria-label="Select review rating">
                                @for ($star = 1; $star <= 5; $star++)
                                    <button type="button" class="review-star-btn rounded-full border border-gray-200 bg-white p-1.5 text-gray-300 transition hover:border-red-200 hover:text-amber-400" data-value="{{ $star }}" aria-label="Rate {{ $star }} out of 5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.195 3.674a1 1 0 0 0 .95.69h3.864c.969 0 1.371 1.24.588 1.81l-3.126 2.271a1 1 0 0 0-.364 1.118l1.194 3.674c.3.922-.755 1.688-1.538 1.118l-3.126-2.271a1 1 0 0 0-1.176 0l-3.126 2.271c-.783.57-1.838-.196-1.538-1.118l1.194-3.674a1 1 0 0 0-.364-1.118L2.452 9.101c-.783-.57-.38-1.81.588-1.81h3.864a1 1 0 0 0 .95-.69l1.195-3.674Z" />
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="review-rating" value="{{ old('rating', 0) }}">
                            @error('rating', 'review')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="review" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Your Review</label>
                            <textarea id="review" name="review" rows="3" required class="mt-1.5 block w-full rounded-lg border-gray-200 text-sm shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Write your review here...">{{ old('review') }}</textarea>
                            @error('review', 'review')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="review-images" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Product Images</label>
                            <input id="review-images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple class="mt-1.5 block w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-ink-900 file:px-3 file:py-1.5 file:text-sm file:font-bold file:text-white hover:file:bg-red-600">
                            <p class="mt-1 text-xs text-gray-500">Optional. Up to 6 JPG, PNG, or WebP images, 4MB each.</p>
                            @error('images', 'review')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="review-videos" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Product Videos</label>
                            <input id="review-videos" name="videos[]" type="file" accept="video/mp4,video/webm,video/quicktime" multiple class="mt-1.5 block w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-ink-900 file:px-3 file:py-1.5 file:text-sm file:font-bold file:text-white hover:file:bg-red-600">
                            <p class="mt-1 text-xs text-gray-500">Optional. Up to 3 MP4, WebM, or MOV videos, 20MB each.</p>
                            @error('videos', 'review')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap justify-end gap-3 pt-1">
                            <button type="button" data-close-review-modal class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-red-300 hover:text-red-600">
                                Cancel
                            </button>
                            <button type="submit" class="shine-btn inline-flex items-center justify-center rounded-md bg-red-600 px-5 py-2 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-red-500">
                                Submit Review
                            </button>
                        </div>
                    </form>
                    @else
                        <div class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5">
                            <p class="text-sm leading-relaxed text-gray-600">
                                {{ $hasReviewed ? 'You have already reviewed this product.' : 'You can review this product after an order containing it is delivered.' }}
                            </p>
                        </div>
                    @endif
                @else
                    <div class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5">
                        <p class="text-sm leading-relaxed text-gray-600">Sign in to leave a verified review and upload a product photo.</p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('login') }}" class="rounded-md bg-ink-900 px-5 py-2.5 text-xs font-bold uppercase tracking-wide text-white transition hover:bg-red-600">Sign In</a>
                            <a href="{{ route('register') }}" class="rounded-md border border-gray-300 px-5 py-2.5 text-xs font-bold uppercase tracking-wide text-ink-900 transition hover:border-red-600 hover:text-red-600">Create Account</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('review-modal');
                const openButtons = Array.from(document.querySelectorAll('[data-open-review-modal]'));
                const closeButtons = Array.from(document.querySelectorAll('[data-close-review-modal]'));
                const ratingInput = document.getElementById('review-rating');
                const stars = Array.from(document.querySelectorAll('.review-star-btn'));

                if (modal) {
                    const openModal = () => {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.classList.add('overflow-hidden');
                    };
                    const closeModal = () => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.classList.remove('overflow-hidden');
                    };

                    openButtons.forEach((button) => button.addEventListener('click', openModal));
                    closeButtons.forEach((button) => button.addEventListener('click', closeModal));
                    modal.addEventListener('click', (event) => {
                        if (event.target === modal) {
                            closeModal();
                        }
                    });
                    document.addEventListener('keydown', (event) => {
                        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                            closeModal();
                        }
                    });
                    if (modal.dataset.reviewModalOpen === 'true') {
                        openModal();
                    }
                }

                if (!ratingInput || stars.length === 0) {
                    return;
                }

                const updateStars = (selectedValue) => {
                    stars.forEach((star) => {
                        const value = Number(star.dataset.value);
                        star.classList.toggle('text-amber-400', value <= selectedValue);
                        star.classList.toggle('text-gray-300', value > selectedValue);
                        star.classList.toggle('border-red-200', value <= selectedValue);
                        star.classList.toggle('bg-amber-50', value <= selectedValue);
                    });
                };

                const initialValue = Number(ratingInput.value || 0);
                if (initialValue > 0) {
                    updateStars(initialValue);
                }

                stars.forEach((star) => {
                    star.addEventListener('click', () => {
                        const selectedValue = Number(star.dataset.value);
                        ratingInput.value = selectedValue;
                        updateStars(selectedValue);
                    });
                });
            });
        </script>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-24 border-t border-gray-100 pt-16">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-600 mb-3">You Might Also Like</p>
                <h2 class="font-heading text-2xl sm:text-3xl font-bold text-ink-900 mb-10">Related Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                    @foreach ($relatedProducts as $related)
                        @include('partials.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.storefront>
