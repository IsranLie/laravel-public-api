@extends('app')
@section('content')

<!-- Breadcrumb -->
<nav class="flex items-center text-md text-gray-600 dark:text-gray-300 mb-2 ml-2 md:ml-0" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ url('/') }}" class="inline-flex items-center hover:text-custom-red-500">Home</a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <a href="{{ route('posts') }}" class="hover:text-custom-red-500">Posts</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <span class="text-gray-400 dark:text-gray-500">
                    {{ isset($post) ? 'Post Update' : 'Post Create' }}
                </span>
            </div>
        </li>
    </ol>
</nav>

<div class="mx-auto rounded-xl bg-white p-8 text-left shadow-lg dark:bg-gray-900">
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
        {{ isset($post) ? 'Update Post' : 'Write Post' }}
    </h3>
    <p class="text-xs text-gray-800 dark:text-white">Important: resource will not be really updated on the server but it will be faked as if.</p>
    <div class="mb-8">
        <form
            action="{{ isset($post) ? route('post.update', $post['id']) : route('post.store') }}"
            method="POST"
            class="space-y-4"
        >
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <!-- User -->
            <div>
                <label for="user" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    User<span class="text-custom-red-500">*</span>
                </label>
                <select
                    name="user"
                    id="user"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                    required
                >
                    <option value="">--Select User--</option>
                    @foreach ($users as $u)
                        <option value="{{ $u['id'] }}"
                            @selected(old('user', $post['userId'] ?? '') == $u['id'])>
                            {{ $u['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Title<span class="text-custom-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $post['title'] ?? '') }}"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                    placeholder="Write title"
                    required
                />
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Content<span class="text-custom-red-500">*</span>
                </label>
                <textarea
                    name="content"
                    id="content"
                    rows="3"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                    placeholder="Write something..."
                    required
                >{{ old('content', $post['body'] ?? '') }}</textarea>
            </div>

            <div>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-custom-red-600 hover:bg-custom-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red-500 dark:bg-custom-red-700 dark:hover:bg-custom-red-800"
                >
                    {{ isset($post) ? 'Update' : 'Submit' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
