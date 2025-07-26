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

        <!-- Search -->
        <form
            action="{{ route('posts') }}"
            method="GET"
            class="flex-grow w-full md:w-auto flex items-center border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden"
        >
            <input
                type="text"
                name="search"
                placeholder="Search by title/content"
                class="flex-grow py-2 px-4 focus:outline-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400"
                required
                value="{{ request('search') }}"
            />
            @if(request('search'))
            <a
                href="{{ route('posts') }}"
                title="Reset"
                class="bg-gray-100 dark:bg-gray-700 p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-300"
            >
                <i class="ri-close-line text-lg"></i>
            </a>
            @else
            <button
                type="submit"
                class="bg-gray-100 dark:bg-gray-700 p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-300"
            >
                <i class="ri-search-line text-lg"></i>
            </button>
            @endif
        </form>

        <div class="relative">
            <!-- Tombol Filter -->
            <button
                id="filterBtn"
                type="button"
                class="flex-shrink-0 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center space-x-2"
            >
                <i class="ri-equalizer-line text-lg"></i>
                <span>Filter</span>
            </button>

            <!-- Dropdown -->
            <div
                id="filterDropdown"
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg hidden z-50"
            >
                <ul
                    class="py-2 text-sm text-gray-700 dark:text-gray-200 space-y-1"
                >
                    <li class="px-4 py-2">
                        <form method="GET" action="{{ route('posts') }}">
                            <label
                                class="block mb-1 text-gray-700 dark:text-gray-300 text-sm"
                                >Filter by ID</label
                            >
                            <input
                                type="number"
                                name="search_id"
                                class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:text-white"
                                required
                                placeholder="Post ID..."
                            />
                            <button
                                type="submit"
                                class="mt-2 w-full bg-custom-red-600 text-white py-1 rounded hover:bg-custom-red-700"
                            >
                                Apply
                            </button>
                        </form>
                    </li>
                    <li
                        class="px-4 py-2 border-t border-gray-200 dark:border-gray-700"
                    >
                        <form method="GET" action="{{ route('posts') }}">
                            <label
                                class="block mb-1 text-gray-700 dark:text-gray-300 text-sm"
                                >Filter by Author</label
                            >
                            <input
                                type="text"
                                name="search_user"
                                class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:text-white"
                                required
                                placeholder="Author name..."
                            />
                            <button
                                type="submit"
                                class="mt-2 w-full bg-custom-red-600 text-white py-1 rounded hover:bg-custom-red-700"
                            >
                                Apply
                            </button>
                        </form>
                    </li>
                    <li
                        class="px-4 py-2 border-t border-gray-200 dark:border-gray-700"
                    >
                        <a
                            href="{{ route('posts') }}"
                            class="mt-2 block text-center bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 text-gray-800 dark:text-gray-200 py-1 rounded"
                        >
                            Reset
                        </a>
                    </li>
                </ul>
            </div>
        </div>
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
                            class="bookmark-toggle text-gray-600 hover:text-yellow-500 dark:text-gray-400 dark:hover:text-yellow-400 cursor-pointer"
                            data-id="{{ $post['id'] }}"
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
                                    <form
                                        id="delete-form-{{ $post['id'] }}"
                                        action="{{
                                            route('post.delete', $post['id'])
                                        }}"
                                        method="POST"
                                        class="inline"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="button"
                                            data-id="{{ $post['id'] }}"
                                            class="menu-delete text-gray-700 hover:text-custom-red-600 hover:dark:text-custom-red-400 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @php $current = $data->currentPage(); $last = $data->lastPage(); @endphp
    <div class="mt-6 flex flex-wrap justify-center gap-2">
        <!-- Tombol Prev -->
        @if ($data->onFirstPage() === false)
        <a
            href="{{ $data->previousPageUrl() }}"
            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
            >Prev</a
        >
        @endif

        <!-- Halaman Awal -->
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

        <!-- Halaman Tengah -->
        @for ($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
        <a
            href="{{ $data->url($i) }}"
            class="px-3 py-1 {{
                $i == $current ? 'bg-custom-red-600 text-white' : 'bg-gray-300'
            }} rounded"
            >{{ $i }}</a
        >
        @endfor

        <!-- Halaman Akhir -->
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

        <!-- Tombol Next -->
        @if ($data->hasMorePages())
        <a
            href="{{ $data->nextPageUrl() }}"
            class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400"
            >Next</a
        >
        @endif
    </div>

    <!-- Modal Delete -->
    <div
        id="deleteModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2
                class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4"
            >
                Delete Post
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to delete this post?
            </p>
            <p class="text-xs text-gray-600 dark:text-gray-300 mb-6">
                Important: resource will not be really updated on the server but
                it will be faked as if.
            </p>
            <div class="flex justify-end gap-2">
                <button
                    id="cancelDelete"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 rounded"
                >
                    Cancel
                </button>
                <button
                    id="confirmDelete"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded"
                >
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection @section('scripts')
<script>
    // Dropdown Edit & Delete
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

    // Drowpdown filter
    document.addEventListener("DOMContentLoaded", function () {
        const filterBtn = document.getElementById("filterBtn");
        const filterDropdown = document.getElementById("filterDropdown");

        // Toggle dropdown ketika tombol di klik
        filterBtn.addEventListener("click", function (e) {
            e.stopPropagation(); // mencegah event bubble
            filterDropdown.classList.toggle("hidden");
        });

        // Tutup dropdown jika klik di luar
        document.addEventListener("click", function (e) {
            if (
                !filterDropdown.classList.contains("hidden") &&
                !filterDropdown.contains(e.target)
            ) {
                filterDropdown.classList.add("hidden");
            }
        });
    });

    // Delete Post
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("deleteModal");
        const cancelBtn = document.getElementById("cancelDelete");
        const confirmBtn = document.getElementById("confirmDelete");

        let formToSubmit = null;

        // Buka modal & simpan form yang mau disubmit
        document.querySelectorAll(".menu-delete").forEach((button) => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                const id = button.getAttribute("data-id");
                formToSubmit = document.getElementById(`delete-form-${id}`);
                modal.classList.remove("hidden");
            });
        });

        // Batal
        cancelBtn.addEventListener("click", (e) => {
            e.preventDefault();
            modal.classList.add("hidden");
            formToSubmit = null;
        });

        // Konfirmasi
        confirmBtn.addEventListener("click", (e) => {
            e.preventDefault();
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
    });

    // Bookmark
    const bookmarksKey = "bookmarked_posts";
    const bookmarkButtons = document.querySelectorAll(".bookmark-toggle");
    let bookmarkedPosts = JSON.parse(localStorage.getItem(bookmarksKey)) || [];

    // Fungsi untuk update tampilan icon bookmark
    function updateBookmarkIcons() {
        bookmarkButtons.forEach((btn) => {
            const postId = btn.getAttribute("data-id");
            const icon = btn.querySelector("i");

            if (bookmarkedPosts.includes(postId)) {
                icon.classList.remove("ri-bookmark-line");
                icon.classList.add("ri-bookmark-fill", "text-yellow-500");
            } else {
                icon.classList.add("ri-bookmark-line");
                icon.classList.remove("ri-bookmark-fill", "text-yellow-500");
            }
        });
    }

    // Event toggle bookmark
    bookmarkButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const postId = btn.getAttribute("data-id");

            if (bookmarkedPosts.includes(postId)) {
                // Hapus bookmark
                bookmarkedPosts = bookmarkedPosts.filter((id) => id !== postId);
            } else {
                // Tambah bookmark
                bookmarkedPosts.push(postId);
            }

            // Simpan ke localStorage
            localStorage.setItem(bookmarksKey, JSON.stringify(bookmarkedPosts));

            // Update icon
            updateBookmarkIcons();
        });
    });

    // Set icon saat load
    updateBookmarkIcons();
</script>
@endsection
