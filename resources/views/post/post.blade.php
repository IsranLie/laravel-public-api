@extends('app') @section('content')

<div class="mx-auto rounded-xl bg-white p-8 text-left dark:bg-gray-900">
    <!-- Write , Search, Filter -->
    <div
        class="flex flex-col md:flex-row items-center justify-between mb-10 space-y-4 md:space-y-0 md:space-x-4"
    >
        <a
            href="{{ route('post.create') }}"
            class="flex-shrink-0 bg-custom-red-600 hover:bg-custom-red-700 text-white py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center space-x-2"
        >
            <!-- <i class="ri-edit-box-line text-lg"></i> -->
            <i class="ri-edit-line text-lg"></i>
            <span>Write</span>
        </a>

        <!-- action="" -->
        <form
            method="POST"
            class="flex-grow w-full md:w-auto flex items-center border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden"
        >
            @csrf
            <input
                type="text"
                name="search"
                placeholder="Search posts..."
                class="flex-grow py-2 px-4 focus:outline-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400"
                value="{{ request('search') }}"
                required
            />
            <button
                type="submit"
                class="bg-gray-100 dark:bg-gray-700 p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-300"
            >
                <i class="ri-search-line text-lg"></i>
            </button>
        </form>

        <button
            class="flex-shrink-0 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center space-x-2"
        >
            <i class="ri-equalizer-line text-lg"></i>
            <span>Filter</span>
        </button>
    </div>

    <div class="mt-4 grid gap-6 md:grid-cols-1 lg:grid-cols-2">
        @foreach ($data as $post)
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col md:flex-row h-full"
        >
            <div class="md:w-1/3 flex-shrink-0">
                <img
                    class="w-full h-full object-cover aspect-square"
                    src="{{ $post['image_url'] }}"
                    alt="Image {{ $post['id'] }}"
                    onerror="this.onerror=null;this.src='https://placehold.co/300x300/E0E0E0/333333?text=Image+Not+Found';"
                />
            </div>
            <div class="p-4 flex flex-col flex-grow md:w-2/3">
                <div class="flex-grow">
                    <a
                        href="{{ route('post.detail', ['id' => $post['id']]) }}"
                        class="block"
                    >
                        <h3
                            class="text-xl font-extrabold text-custom-red-950 dark:text-custom-red-300 capitalize mb-2 line-clamp-2"
                        >
                            {{ $post["title"] }}
                        </h3>
                        <p
                            class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3"
                        >
                            {{ Str::limit($post['body'], 100, '... See more') }}
                        </p>
                    </a>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <a
                        href="{{ route('user.profile', ['id'=> $post['author_id']]) }}"
                    >
                        <div class="flex items-center space-x-2">
                            <i
                                class="ri-user-line text-gray-500 dark:text-gray-400"
                            ></i>
                            <span
                                class="text-sm font-semibold text-custom-red-950 dark:text-custom-red-100 capitalize"
                            >
                                {{ $post["author_name"] }}
                            </span>
                        </div>
                    </a>

                    <div class="flex items-center space-x-3">
                        <span
                            class="text-gray-600 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 cursor-pointer"
                        >
                            <i class="ri-chat-1-line"></i>
                            {{ $post["comment_count"] }}
                        </span>
                        <span
                            class="text-gray-600 hover:text-yellow-500 dark:text-gray-400 dark:hover:text-yellow-400 cursor-pointer"
                        >
                            <i class="ri-bookmark-line"></i>
                        </span>
                        <span
                            class="text-gray-600 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-300 cursor-pointer"
                        >
                            <i class="ri-share-line"></i>
                        </span>
                        <div class="relative inline-block text-left">
                            <button
                                type="button"
                                class="text-gray-600 dark:text-gray-400 hover:text-green-500 hover:dark:text-green-500 cursor-pointer focus:outline-none"
                                id="menu-button-{{ $post['id'] }}"
                                aria-haspopup="true"
                            >
                                <i class="ri-more-fill"></i>
                            </button>

                            <div
                                class="z-10 origin-top-right absolute right-0 mt-2 w-[100px] rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="menu-button-{{ $post['id'] }}"
                                tabindex="-1"
                            >
                                <div class="py-1" role="none">
                                    <a
                                        href="{{
                                            route('post.edit', $post['id'])
                                        }}"
                                        class="text-gray-700 hover:text-yellow-600 hover:dark:text-yellow-400 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="menu-item-edit-{{ $post['id'] }}"
                                    >
                                        Edit
                                    </a>
                                    <a
                                        href="#"
                                        class="text-gray-700 hover:text-custom-red-600 hover:dark:text-custom-red-400 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="menu-item-delete-{{ $post['id'] }}"
                                    >
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @php $current = $data->currentPage(); $last = $data->lastPage(); @endphp

    <div class="mt-6 flex flex-wrap justify-center gap-2">
        {{-- Tombol Prev --}}
        @if ($data->onFirstPage() === false)
        <a
            href="{{ $data->previousPageUrl() }}"
            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
            >Prev</a
        >
        @endif

        {{-- Halaman Awal --}}
        @if ($current > 2)
        <a
            href="{{ $data->url(1) }}"
            class="px-3 py-1 {{
                $current == 1 ? 'bg-custom-red-600 text-white' : 'bg-gray-300'
            }} rounded"
            >1</a
        >
        @if ($current > 3)
        <span class="px-2 text-custom-red-600">...</span>
        @endif @endif

        {{-- Halaman Tengah --}}
        @for ($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
        <a
            href="{{ $data->url($i) }}"
            class="px-3 py-1 {{
                $i == $current ? 'bg-custom-red-600 text-white' : 'bg-gray-300'
            }} rounded"
            >{{ $i }}</a
        >
        @endfor

        {{-- Halaman Akhir --}}
        @if ($current < $last - 1) @if ($current < $last - 2)
        <span class="px-2 text-custom-red-600">...</span>
        @endif
        <a
            href="{{ $data->url($last) }}"
            class="px-3 py-1 {{
                $current == $last
                    ? 'bg-custom-red-600 text-white'
                    : 'bg-gray-300'
            }} rounded"
            >{{ $last }}</a
        >
        @endif

        {{-- Tombol Next --}}
        @if ($data->hasMorePages())
        <a
            href="{{ $data->nextPageUrl() }}"
            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
            >Next</a
        >
        @endif
    </div>
</div>
@endsection @section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('[id^="menu-button-"]').forEach((button) => {
            const dropdownMenu = button.nextElementSibling;

            button.addEventListener("click", (event) => {
                event.stopPropagation();

                document
                    .querySelectorAll('[id^="menu-button-"]')
                    .forEach((otherButton) => {
                        if (otherButton !== button) {
                            const otherDropdown =
                                otherButton.nextElementSibling;
                            if (!otherDropdown.classList.contains("hidden")) {
                                otherDropdown.classList.add("hidden");
                                otherButton.setAttribute(
                                    "aria-expanded",
                                    "false"
                                );
                            }
                        }
                    });

                dropdownMenu.classList.toggle("hidden");
                button.setAttribute(
                    "aria-expanded",
                    dropdownMenu.classList.contains("hidden") ? "false" : "true"
                );
            });
        });

        document.addEventListener("click", (event) => {
            document
                .querySelectorAll('[id^="menu-button-"]')
                .forEach((button) => {
                    const dropdownMenu = button.nextElementSibling;

                    if (
                        !button.contains(event.target) &&
                        !dropdownMenu.contains(event.target)
                    ) {
                        if (!dropdownMenu.classList.contains("hidden")) {
                            dropdownMenu.classList.add("hidden");
                            button.setAttribute("aria-expanded", "false");
                        }
                    }
                });
        });
    });
</script>
@endsection
