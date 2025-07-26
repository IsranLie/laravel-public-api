{{-- resources/views/partials/posts_list.blade.php --}}

@foreach ($data as $post)
<div
    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 flex flex-col md:flex-row h-full"
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
                class="block text-decoration-none"
            >
                <h3
                    class="text-xl font-semibold text-custom-red-950 dark:text-custom-red-100 capitalize mb-2 line-clamp-2"
                >
                    {{ $post["id"] }}. {{ $post["title"] }}
                </h3>
                <p
                    class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3"
                >
                    {{ Str::limit($post['body'], 100, '... See more') }}
                </p>
            </a>
        </div>
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="ri-user-line text-gray-500 dark:text-gray-400"></i>
                <span
                    class="text-sm font-semibold text-custom-red-950 dark:text-custom-red-100 capitalize"
                >
                    {{ $post["author_name"] }}
                </span>
            </div>

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
                <span
                    class="text-gray-600 dark:text-gray-400 hover:text-green-500 hover:dark:text-green-500 cursor-pointer"
                >
                    <i class="ri-more-fill"></i>
                </span>
            </div>
        </div>
    </div>
</div>
@endforeach
