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
                >Home</a
            >
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <a href="{{ route('users') }}" class="hover:text-custom-red-500"
                    >User</a
                >
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line mx-1 text-gray-400"></i>
                <span class="text-gray-400 dark:text-gray-500">
                    {{ isset($user) ? "User Update" : "User Create" }}
                </span>
            </div>
        </li>
    </ol>
</nav>

<div
    class="mx-auto rounded-xl bg-white p-8 text-left shadow-lg dark:bg-gray-900"
>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
        {{ isset($user) ? "Update User" : "Add User" }}
    </h3>
    <p class="text-xs text-gray-800 dark:text-white">
        Important: resource will not be really updated on the server but it will
        be faked as if.
    </p>
    <div class="mb-8">
        <form
            action="{{
                isset($user)
                    ? route('user.update', $user['id'])
                    : route('user.store')
            }}"
            method="POST"
            class="space-y-4"
        >
            @csrf @if(isset($user)) @method('PUT') @endif

            <!-- User -->
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
                    value="{{ old('name', $user['name'] ?? '') }}"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                    placeholder="Your Name"
                    required
                />
            </div>

            <!-- Title -->
            <div>
                <label
                    for="username"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Username<span class="text-custom-red-500">*</span>
                </label>
                <input
                    type="username"
                    name="username"
                    id="username"
                    value="{{ old('username', $user['username'] ?? '') }}"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                    placeholder="Your Username"
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
                    value="{{ old('email', $user['email'] ?? '') }}"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-3"
                    placeholder="yourid@gmail.com"
                    required
                />
            </div>

            <div>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-custom-red-600 hover:bg-custom-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-red-500 dark:bg-custom-red-700 dark:hover:bg-custom-red-800"
                >
                    {{ isset($user) ? "Update" : "Submit" }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
