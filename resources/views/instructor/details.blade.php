<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Door Instructeur gebruikte voertuigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Instructeur info --}}
                    <div class="space-y-2 mb-6">
                        <p class="text-lg">
                            <span class="font-medium">Naam:</span>
                            {{ $instructor->Firstname }} {{ $instructor->Middlename }} {{ $instructor->Lastname }}
                        </p>
                        <p class="text-lg">
                            <span class="font-medium">Datum in dienst:</span>
                            {{ $instructor->StartDate ?? 'onbekend' }}
                        </p>
                        <p class="text-lg">
                            <span class="font-medium">Aantal sterren:</span>
                            {{ $instructor->NumberOfStars ?? 'onbekend' }}
                        </p>
                    </div>

                    {{-- Toevoegen knop --}}
                    <div class="mb-6">
                        <a href="{{ route('vehicle.index', ['instructorId' => $instructor->Id]) }}"
                            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            Toevoegen Voertuig
                        </a>
                    </div>

                    {{-- Voertuigen tabel --}}
                    <div class="mt-4">
                        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Type Voertuig</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Model</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Kenteken</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Bouwjaar</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Brandstof</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">
                                        Rijbewijscategorie</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                        Wijzigen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($instructorvehicles as $vehicle)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $vehicle->VehicleType ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $vehicle->Model ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $vehicle->LicensePlate ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ \Carbon\Carbon::parse($vehicle->YearOfManufacture)->format('Y') }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $vehicle->FuelType ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2">
                                        {{ $vehicle->LicenseCategory ?? '-' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                        <a href="{{ route('vehicle.index', [
                                            'instructorId' => $vehicle->InstructorId,
                                        ]) }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                            Geen voertuigen gevonden
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>