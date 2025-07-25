@extends('app') @section('content')
<nav
    class="flex items-center text-md text-gray-600 dark:text-gray-300 mb-2 ml-2 md:ml-0"
    aria-label="Breadcrumb"
>
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center hover:text-custom-red-500"
            >
                Home
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <a href="{{ route('posts') }}" class="hover:text-custom-red-500"
                    >Posts</a
                >
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <span class="text-gray-400 dark:text-gray-500"
                    >Post Detail</span
                >
            </div>
        </li>
    </ol>
</nav>

<div
    class="mx-auto rounded-xl bg-white p-8 text-left shadow-lg dark:bg-gray-900"
>
    @if (isset($postData) && !empty($postData))
    <h2
        class="text-4xl font-extrabold text-custom-red-800 dark:text-custom-red-300 mb-4 capitalize"
    >
        {{ $postData["title"] ?? "Unknown" }}
    </h2>
    <div
        class="prose prose-lg dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 leading-relaxed mb-5"
    >
        <p>{{ $postData["body"] ?? "Unknown" }}</p>
    </div>

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('user.profile', ['id'=> $postData['userId']]) }}">
            <div class="flex items-center space-x-3">
                <img
                    src="https://picsum.photos/id/{{
                        $postData['userId'] ?? '100'
                    }}/50/50"
                    alt="{{ $postData['author_name'] }}"
                    class="w-12 h-12 rounded-full object-cover border-2 border-custom-red-500"
                />
                <div>
                    <p
                        class="text-lg font-semibold text-gray-900 dark:text-white"
                    >
                        {{ $postData["author_name"] }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <i class="ri-at-line w-6 h-6"></i
                        >{{ $postData["author_username"] }}
                    </p>
                </div>
            </div>
        </a>

        <div class="flex items-center space-x-4">
            <button
                class="flex items-center space-x-1 text-gray-600 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-200"
            >
                <i class="ri-chat-1-line ri-xl"></i>
                <span class="text-sm">{{ count($comments) }}</span>
            </button>
            <button
                class="text-gray-600 hover:text-yellow-500 dark:text-gray-400 dark:hover:text-yellow-400 transition-colors duration-200"
            >
                <i class="ri-bookmark-line ri-xl"></i>
            </button>
            <button
                class="text-gray-600 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400 transition-colors duration-200"
            >
                <i class="ri-share-line ri-xl"></i>
            </button>
        </div>
    </div>

    <div class="mb-8">
        <span class="overflow-hidden shadow-md">
            <img
                src="{{ $postData['image_url'] }}"
                alt="Img {{ $postData['id'] ?? 'Unknown' }}"
                class="w-full h-[300px] object-cover rounded-lg"
                onerror="this.onerror=null;this.src='https://placehold.co/800x600/E0E0E0/333333?text=Image+Not+Found';"
            />
        </span>
        <p
            class="text-sm text-gray-500 dark:text-gray-500 text-center italic mt-2"
        >
            Source:
            <a
                href="https://picsum.photos/"
                target="_blank"
                class="text-blue-500 dark:text-blue-800"
                >Lorem Picsum</a
            >
        </p>
    </div>

    <div
        class="prose prose-lg dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 leading-relaxed mb-12 text-justify"
    >
        <p>
            {{ $postData["body"] ?? "Unknown" }}
        </p>
        <p class="mt-2">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod
            deleniti harum quo atque non officia molestiae neque quia molestias!
            Reprehenderit possimus voluptas ad fugit dolores minus laudantium
            tenetur fuga quasi pariatur autem ullam mollitia modi cum
            asperiores, molestiae distinctio aspernatur, corrupti inventore ea
            voluptate ipsum delectus quas voluptatibus. Aliquid, aliquam.
        </p>
    </div>

    <div class="flex justify-center">
        <a
            href="{{ route('posts') }}"
            class="inline-block text-center w-[200px] my-6 border border-custom-red-300 hover:border-custom-red-950 hover:dark:border-custom-red-950 dark:border-custom-red-200 text-custom-red-950 dark:text-custom-red-300 rounded-full p-2 hover:text-custom-red-50 hover:dark:text-custom-red-100 hover:bg-custom-red-950 transition-colors duration-200"
        >
            See more posts
        </a>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 pt-8 mt-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
            Responses ({{ count($comments) }})
        </h3>
        <div class="mb-8">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Name<span class="text-custom-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-custom-red-500 focus:ring-custom-red-500 bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                        placeholder="Your name"
                        required
                    />
                </div>
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Email<span class="text-custom-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-custom-red-500 focus:ring-custom-red-500 bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                        placeholder="Your email"
                        required
                    />
                </div>
                <div>
                    <label
                        for="comment_body"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                    >
                        Comment Text<span class="text-custom-red-500">*</span>
                    </label>
                    <textarea
                        name="comment_body"
                        id="comment_body"
                        rows="2"
                        class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-custom-red-500 focus:ring-custom-red-500 bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                        placeholder="Say something..."
                        required
                    ></textarea>
                </div>
                <div>
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-custom-red-600 hover:bg-custom-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red-500 dark:bg-custom-red-700 dark:hover:bg-custom-red-800"
                    >
                        Send
                    </button>
                </div>
            </form>
        </div>

        <div
            class="space-y-6 border-t border-gray-200 dark:border-gray-700 pt-8 mt-8"
        >
            @php $timeStrings = [ '1 minute ago', '5 minutes ago', '15 minutes
            ago', '30 minutes ago', '45 minutes ago', '1 hour ago', '2 hours
            ago', '3 hours ago', 'yesterday', '2 days ago', '3 days ago', '1
            week ago', ]; @endphp @forelse ($comments as $comment)
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                <div class="flex mb-2">
                    <i
                        class="ri-user-line text-lg inline-flex items-center justify-center w-12 h-12 bg-gray-200 dark:bg-gray-700 text-custom-red-950 dark:text-custom-red-100 rounded-full mr-2 flex-shrink-0"
                    ></i>
                    <div
                        class="text-gray-900 dark:text-white flex-grow min-w-0"
                    >
                        <span
                            class="text-md font-semibold text-custom-red-950 dark:text-custom-red-100 capitalize block truncate"
                            >{{ $comment["name"] ?? "Unknown" }}</span
                        >
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span
                                class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full px-2 py-1 text-xs"
                            >
                                {{ $timeStrings[array_rand($timeStrings)] }}
                            </span>
                        </p>
                    </div>
                </div>

                <p class="text-gray-700 dark:text-gray-300 px-14">
                    {{ $comment["body"] }}
                </p>
            </div>
            @empty
            <p
                class="text-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full px-2 py-1"
            >
                No comments yet.
            </p>
            @endforelse
        </div>
    </div>
    @else
    <p class="text-center text-gray-600 dark:text-gray-400 text-xl py-10">
        Not content.
    </p>
    @endif
</div>
@endsection
