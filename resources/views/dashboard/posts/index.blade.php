<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="w-full sm:py-12">
        <x-section>
            <div class="mb-5">
                <x-button.create href="">
                    {{ __('Create') }}
                </x-button.create>
            </div>
            <div class="mb-5">
                @if (request('search'))
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Search results for: ') }} {{ request('search') }}
                </h2>
                @else
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    All Posts
                </h2>
                @endif
            </div>
            <div class="mb-5 md:w-1/2 2xl:w-1/3">
                <form class="flex items-center gap-2">
                    <x-text-input id="search" name="search" type="text" class="w-full" placeholder="Search ..."
                        value="{{ request('search') }}" />
                    <x-button.search type="submit">
                        {{ __('Search') }}
                    </x-button.search>
                </form>
            </div>
            {{-- <div class="grid grid-cols-1 gap-5 md:grid-cols-2 2xl:grid-cols-3"> --}}
                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    @forelse ($allUserPosts as $post)
                    <x-card.post-dashboard>
                        <div class="flex flex-col justify-between h-full">
                            <div class="flex flex-col">
                                <div class="flex justify-between gap-1 mb-2">
                                    <div class="flex gap-1">
                                        @if ($post->is_published)
                                        <x-badge.post-published />
                                        @else
                                        <x-badge.post-drafted />
                                        @endif
                                        @if ($post->is_featured)
                                        <x-badge.post-featured />
                                        @endif
                                    </div>
                                    <div class="flex gap-1">
                                        @if ($post->is_requested)
                                        <x-badge.post-requested />
                                        @endif
                                        @if ($post->is_approved)
                                        <x-badge.post-approved />
                                        @endif
                                        @if ($post->is_rejected)
                                        <x-badge.post-rejected />
                                        @endif
                                    </div>
                                </div>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $post->title }}
                                </p>
                                @if ($post->post_category_id != 1 || $post->is_featured == false)
                                <div class="flex justify-between">
                                    <div>
                                        @if ($post->post_category_id != 1)
                                        <div class="font-medium text-indigo-600 uppercase text-md dark:text-indigo-400">
                                            {{ $post->post_category->title }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
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
                                <div class="flex flex-col justify-between sm:flex-row 2xl:flex-col">
                                    <div class="flex gap-2 place-items-end shrink-0">
                                        <p class="mt-1 text-xs text-gray-900 dark:text-gray-100">
                                            Created {{ $post->created_at->diffForHumans() }}
                                        </p>
                                        @if ($post->is_published)
                                        <p class="mt-1 text-xs text-gray-900 dark:text-gray-100">
                                            Published {{ $post->published_at->diffForHumans() }}
                                        </p>
                                        @endif
                                    </div>
                                    <div class="flex gap-2 place-items-end shrink-0">
                                        <p class="mt-1 text-xs text-gray-900 dark:text-gray-100">
                                            {{ $post->views }}
                                            {{ Str::plural('view', $post->views) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card.post-dashboard>
                    @empty
                    <div class="p-5 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-500">
                        <p class="text-gray-500 text-md dark:text-gray-400">
                            {{ __('No post found!') }}
                        </p>
                    </div>
                    @endforelse
                </div>
        </x-section>
        @if ($allUserPosts->hasPages())
        <x-section>
            {{ $allUserPosts->links() }}
        </x-section>
        @endif
    </div>
</x-app-layout>
