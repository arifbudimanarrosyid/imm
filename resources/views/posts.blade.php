<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="w-full sm:py-12">
        <x-section>
            <div class="gap-5 lg:flex">
                {{-- Posts List --}}
                <div class="lg:w-2/3">
                    <div class="mb-5">
                        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            All Posts
                            @if (request('category'))
                            {{ __('in ') }} {{ $categoryTitle }}
                            @endif
                        </h2>
                        @if(request('search'))
                        <h2 class="text-lg font-medium leading-tight text-gray-800 dark:text-gray-200">
                            {{ __('Search results for: ') }} {{ request('search') }}
                        </h2>
                        @endif
                    </div>
                    {{-- Search --}}
                    <div class="mb-5">
                        <form class="flex items-center gap-2">
                            @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <x-text-input id="search" name="search" type="text" class="w-full"
                                placeholder="Search by title, excerpt or body ..." value="{{ request('search') }}" />
                            <x-primary-button type="submit">
                                {{ __('Search') }}
                            </x-primary-button>
                        </form>
                    </div>
                    {{-- Categories Small Screen --}}
                    <div class="lg:hidden">
                        <div class="flex gap-5 pb-2.5 mt-5 mb-2.5 overflow-y-auto">
                            <a href="{{ route('posts') }}"
                                class="px-5 py-2  rounded-lg  shrink-0 hover:bg-gray-100 hover:dark:bg-gray-600
                            {{ request('category') ? 'bg-gray-50 dark:bg-gray-700' : 'bg-gray-200 dark:bg-gray-500' }}">
                                All {{ $countPosts }}
                            </a>
                            @foreach ($postsCategories as $postsCategory)
                            <a href="/posts?category={{ $postsCategory->slug }}"
                                class="px-5 py-2 rounded-lg shrink-0 hover:bg-gray-100 hover:dark:bg-gray-600
                                {{ request('category') == $postsCategory->slug ? 'bg-gray-200 dark:bg-gray-500' : 'bg-gray-50 dark:bg-gray-700' }}">
                                {{ $postsCategory->title }}
                                {{ $postsCategory->posts->where('is_published', true)
                                ->where('is_approved', true)
                                ->where('is_rejected', false)->count() }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-1">
                        @forelse ($posts as $post)
                        <x-card.post-public>
                            <a href="{{ route('post', $post->slug) }}">
                                <div class="flex flex-col justify-between h-full">
                                    <div class="flex flex-col">
                                        @if ($post->post_category_id != 1 || $post->is_featured == false)
                                        <div class="flex justify-between">
                                            <div>
                                                @if ($post->post_category_id != 1)
                                                <div
                                                    class="font-medium text-indigo-600 uppercase text-md dark:text-indigo-400">
                                                    {{ $post->post_category->title }}
                                                </div>
                                                @endif
                                            </div>
                                            @if ($post->is_featured)
                                            <x-badge.post-featured>
                                                Featured
                                            </x-badge.post-featured>
                                            @endif
                                        </div>
                                        @endif
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            {{ $post->title }}
                                        </p>
                                        @if ($post->excerpt)
                                        <p class="mt-1 text-gray-500 text-md dark:text-gray-400">
                                            {{ $post->excerpt }}
                                        </p>
                                        @else
                                        <p class="mt-1 text-gray-500 text-md dark:text-gray-400">
                                            {{ Str::limit(strip_tags($post->body), 100) }}
                                        </p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex flex-col justify-between sm:flex-row md:flex-col lg:flex-row">
                                            <div class="flex items-center gap-1 mt-1">
                                                <p class="text-gray-900 text-md dark:text-gray-100">
                                                    {{ $post->user->name }}
                                                </p>
                                                @if ($post->user->is_verified)
                                                <x-badge.verified />
                                                @endif
                                            </div>
                                            <div class="flex gap-2 place-items-end shrink-0">
                                                <p class="mt-1 text-xs text-gray-900 dark:text-gray-100">
                                                    {{ $post->published_at->diffForHumans() }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-900 dark:text-gray-100">
                                                    {{ $post->views }}
                                                    {{ Str::plural('view', $post->views) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </x-card.post-public>
                        @empty
                        <div class="p-5 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-500">
                            <p class="text-gray-500 text-md dark:text-gray-400">
                                {{ __('No post found!') }}
                            </p>
                        </div>
                        @endforelse
                    </div>
                </div>
                {{-- Categories 2xl Screen --}}
                <div class="space-y-5 lg:w-1/3 lg:mt-0">
                    <div class="hidden mb-5 lg:block">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Categories
                        </h2>
                        <div class="gap-5 pb-5 mt-5 space-y-5 overflow-x-auto lg:overflow-hidden lg:block">
                            <div
                                class="overflow-hidden rounded-lg bg-gray-50 hover:bg-gray-100 hover:dark:bg-gray-600 dark:bg-gray-700 dark:border-gray-500">
                                <a href="{{ route('posts') }}">
                                    <div
                                        class="flex flex-row justify-between h-full px-5 py-2 lg:flex-row @unless (request('category')) bg-gray-200 dark:bg-gray-500 @endunless">
                                        <div>
                                            All
                                        </div>
                                        <div>
                                            {{ $countPosts }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @foreach ($postsCategories as $post_category)
                            <div
                                class="overflow-hidden rounded-lg bg-gray-50 hover:bg-gray-100 hover:dark:bg-gray-600 dark:bg-gray-700 dark:border-gray-500">
                                <a href="/posts?category={{ $post_category->slug }}">
                                    <div class="flex flex-row justify-between h-full px-5 py-2 @if (request('category') == $post_category->slug)
                                        bg-gray-200 dark:bg-gray-500
                                    @endif  lg:flex-row">
                                        <h1 class="mr-2 shrink-0">
                                            {{ $post_category->title }}
                                        </h1>
                                        <div>
                                            {{ $post_category->posts->where('is_published', true)
                                            ->where('is_approved', true)
                                            ->where('is_rejected', false)->count() }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </x-section>
        @if ($posts->hasPages())
        <div class="mx-auto sm:mb-5 max-w-7xl">
            <div class="w-full lg:w-2/3">
                <x-section>
                    {{ $posts->links() }}
                </x-section>
            </div>
        </div>
        @endif

    </div>
</x-guest-layout>
