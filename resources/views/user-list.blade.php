<x-app-layout>
    <div class="container">

        <table class="border-collapse w-full">
            <thead>
            <tr>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell text-left">#</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell text-left">{{ __('Name') }}</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell text-left">{{ __('E-mail') }}</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">{{ __('Language') }}</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">{{ __('Facebook') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left border border-b flex justify-start lg:table-cell relative lg:static">
                        <x-table-label>#</x-table-label>
                        <span>{{ ($users->currentPage() - 1) * 15 + $loop->index + 1 }}</span>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left border border-b flex justify-start lg:table-cell relative lg:static">
                        <x-table-label>{{ __('Name') }}</x-table-label>
                        <span>{{ $user->name }}</span>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left border border-b flex justify-start lg:table-cell relative lg:static">
                        <x-table-label>{{ __('E-mail') }}</x-table-label>
                        <span class="break-all">{{ $user->email }}</span>
                    </td>

                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center flex justify-start lg:table-cell relative lg:static">
                        <x-table-label>{{ __('Language') }}</x-table-label>
                        <x-locale-badge :lang="$user->language" />
                    </td>

                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center flex justify-start lg:table-cell relative lg:static">
                        <div class="flex justify-center">
                            <x-table-label>{{ __('Facebook') }}</x-table-label>
                            @if($user->facebook_token && $user->facebook_page)
                                <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-5 w-5 flex-shrink-0 rounded-full">
                                <span class="text-green-500">
                                    <svg fill="currentColor"
                                         viewBox="0 0 20 20"
                                         class="h-3 w-3">
                                        <path fill-rule="evenodd"
                                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                </div>
                            @else
                                <div class="alert-icon flex items-center bg-red-100 border-2 border-red-500 justify-center h-5 w-5 flex-shrink-0 rounded-full">
                                <span class="text-red-500">
                                    <svg fill="currentColor"
                                         viewBox="0 0 20 20"
                                         class="h-3 w-3">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                </div>
                            @endif
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pt-4">
            <div class="font-bold">{{ __('Third party components:') }}</div>
            <div>
                <a class="underline inline-block mr-1 text-indigo-400"  target="_blank" href="https://tailwindcomponents.com/component/responsive-table">Responsive Table</a>
            </div>
        </div>
    </div>
    <div class="pt-4">
        {{ $users->links() }}
    </div>
</x-app-layout>
