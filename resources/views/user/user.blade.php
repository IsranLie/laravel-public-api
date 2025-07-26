@extends('app') @section('content')
<div class="mx-auto rounded-xl bg-white p-8 text-left dark:bg-gray-900">
    <!-- Create , Search, Filter -->
    <div
        class="flex flex-col md:flex-row items-center justify-between mb-10 space-y-4 md:space-y-0 md:space-x-4"
    >
        <a
            href="{{ route('user.create') }}"
            class="flex-shrink-0 bg-custom-red-600 hover:bg-custom-red-700 text-white py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center space-x-2"
        >
            <i class="ri-add-line text-lg"></i>
            <span>Add User</span>
        </a>

        <!-- Search -->
        <form
            action="{{ route('users') }}"
            method="GET"
            class="flex-grow w-full md:w-auto flex items-center border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden"
        >
            <input
                type="text"
                name="search"
                placeholder="Search by name/username/email/company"
                class="flex-grow py-2 px-4 focus:outline-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400"
                value="{{ request('search') }}"
            />
            <input
                type="hidden"
                name="sort"
                value="{{ request('sort', 'name_asc') }}"
            />

            @if(request('search'))
            <a
                href="{{ route('users', ['sort' => request('sort', 'name_asc')]) }}"
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

        <!-- Tombol Filter -->
        <div class="relative">
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
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                    <li>
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc', 'page' => 1]) }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 {{
                                request('sort') === 'name_asc'
                                    ? 'font-semibold text-yellow-600'
                                    : ''
                            }}"
                        >
                            Sort Name A-Z
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc', 'page' => 1]) }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 {{
                                request('sort') === 'name_desc'
                                    ? 'font-semibold text-yellow-600'
                                    : ''
                            }}"
                        >
                            Sort Name Z-A
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-4 grid gap-6 md:grid-cols-1 lg:grid-cols-2">
        @foreach ($data as $user)
        <div
            class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-lg flex flex-col"
        >
            <div class="flex items-start mb-4 relative">
                <img
                    class="w-12 h-12 rounded-full mr-3 object-cover"
                    src="{{ $user['image_url'] }}"
                    alt="Img {{ $user['id'] }}"
                />

                <div class="text-gray-900 dark:text-white flex-grow min-w-0">
                    <a href="{{ route('user.profile',['id' => $user['id']]) }}">
                        <span
                            class="text-md font-semibold text-custom-red-950 dark:text-custom-red-300 capitalize block truncate"
                            >{{ $user["name"] }}</span
                        >

                        <p
                            class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                        >
                            Join since:
                            <span class="font-medium">Jan 2023</span>
                        </p>
                    </a>
                </div>

                <div class="relative inline-block text-left">
                    <button
                        type="button"
                        class="text-gray-600 dark:text-gray-400 hover:text-green-500 hover:dark:text-green-500 cursor-pointer focus:outline-none"
                        id="menu-button-{{ $user['id'] }}"
                        aria-haspopup="true"
                    >
                        <i class="ri-more-fill"></i>
                    </button>

                    <div
                        class="z-10 origin-top-right absolute right-0 mt-2 w-[100px] rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="menu-button-{{ $user['id'] }}"
                        tabindex="-1"
                    >
                        <div class="py-1" role="none">
                            <a
                                href="{{ route('user.edit', $user['id']) }}"
                                class="text-gray-700 hover:text-yellow-600 hover:dark:text-yellow-400 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                role="menuitem"
                                tabindex="-1"
                                id="menu-item-edit-{{ $user['id'] }}"
                            >
                                Edit
                            </a>
                            <form
                                id="delete-form-{{ $user['id'] }}"
                                action="{{ route('user.delete', $user['id']) }}"
                                method="POST"
                                class="w-full"
                            >
                                @csrf @method('DELETE')
                                <button
                                    type="button"
                                    data-id="{{ $user['id'] }}"
                                    class="menu-delete text-gray-700 hover:text-custom-red-600 hover:dark:text-custom-red-400 dark:text-gray-200 block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <p
                class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-2"
            >
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt,
                sit.
            </p>

            <div class="flex flex-wrap gap-2 text-sm mt-auto">
                <span
                    class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full px-3 py-1 text-xs font-semibold"
                >
                    {{ $user["post_count"] }} Posts
                </span>
            </div>
        </div>
        @endforeach
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
                Delete User
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to delete this user?
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
    // Dropdown edit & delete
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

    // Dropdown filter
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
</script>
@endsection
