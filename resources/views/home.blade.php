@extends('app') @section('content')
<div class="mx-auto rounded-xl bg-white p-8 text-left dark:bg-gray-900">
    <h1 class="text-2xl text-custom-red-950 dark:text-custom-red-100">Home</h1>

    <!-- <div class="mt-4 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach (range(1,10) as $i)
        <div
            class="max-w-sm bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-lg transition flex flex-col"
        >
            <img
                class="w-full h-48 object-cover"
                src="https://picsum.photos/seed/{{ $i }}/400/300"
                alt="img {{ $i }}"
            />

            <div class="p-4 flex flex-col flex-grow">
                <h3
                    class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2"
                >
                    Lorem ipsum {{ $i }}
                </h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm flex-grow">
                    {{ Str::limit('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident molestias modi sint debitis numquam incidunt. Ipsam, labore. Explicabo, iure ab.', 100, '...') }}
                </p>
                <a
                    href="#"
                    class="mt-4 inline-flex items-center gap-1 bg-custom-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-custom-red-500 transition justify-center"
                >
                    Read More <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div> -->

    <div class="mt-4 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($data as $post)
        <div
            class="max-w-sm bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-lg transition flex flex-col"
        >
            <img
                class="w-full h-48 object-cover"
                src="{{ $post['image_url'] }}"
                alt="img {{ $post['id'] }}"
            />

            <div class="p-4 flex flex-col flex-grow">
                <div class="flex justify-end mb-2">
                    <span
                        class="inline-flex items-center gap-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md px-2 py-0.5 text-xs"
                    >
                        <a href="#" title="See Profile">
                            <i class="ri-user-line"></i>
                            {{ $post["author_name"] }}
                        </a>
                    </span>
                </div>
                <h3
                    class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2"
                >
                    {{ $post["id"] }}.
                    {{ $post["title"] }}
                </h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm flex-grow">
                    {{ Str::limit($post['body'], 100, '...') }}
                </p>
                <a
                    href="#"
                    class="mt-4 inline-flex items-center gap-1 bg-custom-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-custom-red-500 transition justify-center"
                >
                    Read More <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- <div class="mt-6 flex justify-center gap-2">
        @if ($data->onFirstPage() === false)
        <a
            href="{{ $data->previousPageUrl() }}"
            class="px-3 py-1 bg-gray-300 rounded"
        >
            Prev
        </a>
        @endif @foreach ($data->getUrlRange(1, $data->lastPage()) as $page =>
        $url)
        <a
            href="{{ $url }}"
            class="px-3 py-1 {{ $page == $data->currentPage() ? 'bg-custom-red-600 text-white' : 'bg-gray-300' }} rounded"
        >
            {{ $page }}
        </a>
        @endforeach @if ($data->hasMorePages())
        <a
            href="{{ $data->nextPageUrl() }}"
            class="px-3 py-1 bg-gray-300 rounded"
        >
            Next
        </a>
        @endif
    </div> -->

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
@endsection
