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
                    href="{{ route('posts') }}"
                    class="hover:text-custom-red-500"
                >
                    Posts
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <span class="text-gray-400 dark:text-gray-500">
                    Post Create
                </span>
            </div>
        </li>
    </ol>
</nav>

<div
    class="mx-auto rounded-xl bg-white p-8 text-left shadow-lg dark:bg-gray-900"
>
    <h1>?</h1>
</div>
@endsection
