<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instructeurs in dienst') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-4">
                        <span class="text-lg font-medium">{{ __('Aantal instructeurs in dienst:') }}</span>
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $instructorsCount }}</span>

                        <div class="mt-8">
                            <h3 class="text-lg font-medium mb-4">{{ __('Instructeurs') }}</h3>
                            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                            {{ __('Naam') }}
                                        </th>
                                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                            {{ __('Mobiel') }}
                                        </th>
                                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                            {{ __('Datum in Dienst') }}
                                        </th>
                                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                            {{ __('Aantal Sterren') }}
                                        </th>
                                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                            {{ __('Voertuigen') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($instructors as $instructor)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                {{ $instructor->FullName }}
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                {{ $instructor->Mobile ?? '-' }}
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                {{ $instructor->StartDate ?? '-' }}
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                                {{ $instructor->NumberOfStars }}
                                            </td>
                                            <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                                <a href="{{ route('instructor.details', ['instructorId' => $instructor->Id]) }}"
                                                    class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                                    <i class="bi bi-car-front-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                                {{ __('Geen instructeurs gevonden') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-4">
                                {{ $instructors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>