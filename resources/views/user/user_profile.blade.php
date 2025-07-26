@extends('app') @section('content')
<!-- Breadcrumb -->
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
                <a
                    href="{{ route('users') }}"
                    class="hover:text-custom-red-500"
                >
                    Users
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <span class="text-gray-400 dark:text-gray-500">
                    User Profile
                </span>
            </div>
        </li>
    </ol>
</nav>

<div class="mx-auto rounded-2xl bg-white p-8 shadow-xl dark:bg-gray-900">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-10">
        <!-- Foto Profil -->
        <div class="flex-shrink-0 text-center">
            <img
                src="{{ $user['image_url'] }}"
                alt="Profile Photo"
                class="h-40 w-full rounded-full border-4 border-custom-red-500 object-cover shadow-lg"
            />
        </div>

        <!-- Info Detail -->
        <div class="flex-1 text-left">
            <!-- Name -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $user["name"] }}
            </h1>
            <!-- Username -->
            <p class="mb-4 text-gray-500 dark:text-gray-400">
                <i class="ri-at-line"></i>{{ $user["username"] }}
            </p>
            <!-- Email, Telepon, Website -->
            <div
                class="flex flex-wrap items-center gap-6 text-gray-700 dark:text-gray-300"
            >
                <p class="flex items-center">
                    <i class="ri-mail-line mr-2 text-blue-500"></i>
                    {{ $user["email"] }}
                </p>
                <p class="flex items-center">
                    <i class="ri-phone-line mr-2 text-green-500"></i>
                    {{ $user["phone"] }}
                </p>
                <p class="flex items-center">
                    <i class="ri-global-line mr-2 text-purple-500"></i>
                    <a
                        href="http://{{ $user['website'] }}"
                        target="_blank"
                        class="text-blue-600 hover:underline"
                    >
                        {{ $user["website"] }}
                    </a>
                </p>
            </div>
            <!-- Alamat & Perusahaan dalam satu baris -->
            <div
                class="mt-4 flex flex-col md:flex-row md:items-center md:gap-6 text-gray-700 dark:text-gray-300"
            >
                <div class="flex items-center">
                    <i class="ri-map-pin-line mr-2 text-red-500"></i>
                    {{ $user["address"]["street"] }},
                    {{ $user["address"]["suite"] }},
                    {{ $user["address"]["city"] }},
                    {{ $user["address"]["zipcode"] }}
                </div>

                <div class="flex items-center">
                    <i class="ri-building-4-line mr-2 text-yellow-500"></i>
                    {{ $user["company"]["name"] }}
                    <p class="ml-2 text-sm italic text-gray-500">
                        "{{ $user["company"]["catchPhrase"] }}"
                    </p>
                </div>
            </div>

            <div
                class="mt-4 flex flex-col md:flex-row md:items-center md:gap-6 text-gray-700 dark:text-gray-300"
            >
                <h3
                    class="text-lg font-semibold text-gray-800 dark:text-white line-clamp-2"
                >
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Minus, similique.
                </h3>
            </div>
        </div>
    </div>

    <hr class="my-6" />

    <h3
        class="text-xl font-extrabold text-custom-red-950 dark:text-custom-red-300 capitalize mb-2 line-clamp-2"
    >
        From {{ $user["name"] }}
    </h3>

    <div class="mt-4 grid gap-6 md:grid-cols-1 lg:grid-cols-2">
        @foreach ($posts as $post)
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
                        <i
                            class="ri-user-line text-gray-500 dark:text-gray-400"
                        ></i>
                        <span
                            class="text-sm font-semibold text-custom-red-950 dark:text-custom-red-100 capitalize"
                        >
                            {{ $user["name"] }}
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
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="flex justify-center">
        <a
            href="{{ route('posts') }}"
            class="inline-block text-center w-[200px] my-6 border border-custom-red-300 hover:border-custom-red-950 hover:dark:border-custom-red-950 dark:border-custom-red-200 text-custom-red-950 dark:text-custom-red-300 rounded-full p-2 hover:text-custom-red-50 hover:dark:text-custom-red-100 hover:bg-custom-red-950 transition-colors duration-200"
        >
            See more posts
        </a>
    </div>
</div>
@endsection
