<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Voertuig wijzigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-700">
                            {{ session('success') }}
                            <meta http-equiv="refresh" content="2;url={{ route('instructor.details', ['instructorId' => $instructorId]) }}">
                        </div>
                    @elseif (session('error'))
                        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
                            {{ session('error') }}
                            <meta http-equiv="refresh" content="2;url={{ route('instructor.details', ['instructorId' => $instructorId]) }}">
                        </div>
                    @endif
                 

                    @if (isset($errors) && $errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-900/60 dark:bg-red-950/30 dark:text-red-200">
                            <p class="font-semibold">Controleer de ingevulde gegevens.</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vehicle.update', ['instructorId' => $instructorId, 'vehicleId' => $vehicleId]) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="instructor_id"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Instructeur
                                </label>
                                <select id="instructor_id" name="instructor_id"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                                    <option value="" @selected(old('instructor_id', $vehicle->InstructorId ?? '') == '')>Geen instructeur</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->Id }}"
                                            @selected(old('instructor_id', $vehicle->InstructorId ?? '') == $instructor->Id)>
                                            {{ $instructor->FirstName }} {{ $instructor->MiddleName }} {{ $instructor->LastName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instructor_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="license_plate"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Kenteken
                                </label>
                                <input id="license_plate" name="license_plate" type="text"
                                    value="{{ old('license_plate', $vehicle->LicensePlate) }}"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                                @error('license_plate')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="model"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Type
                                </label>
                                <input id="model" name="model" type="text" value="{{ old('model', $vehicle->Model) }}"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                                @error('model')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fuel_type"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Brandstof
                                </label>
                                <select id="fuel_type" name="fuel_type"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                                    <option value="">Kies een brandstofsoort</option>
                                    @foreach($fuelTypes as $fuelType)
                                        <option value="{{ $fuelType }}" @selected(old('fuel_type', $vehicle->FuelType) === $fuelType)>
                                            {{ $fuelType }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fuel_type')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="vehicle_type_id"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Voertuigtype
                                </label>
                                <select id="vehicle_type_id" name="vehicle_type_id"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                                    <option value="">Kies een voertuigtype</option>
                                    @foreach($vehicleTypes as $vehicleType)
                                        <option value="{{ $vehicleType->Id }}"
                                            @selected(old('vehicle_type_id', $vehicle->VehicleTypeId) == $vehicleType->Id)>
                                            {{ $vehicleType->VehicleType }} ({{ $vehicleType->LicenseCategory }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_type_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="year_of_manufacture"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Bouwjaar
                                </label>
                                <input id="year_of_manufacture" name="year_of_manufacture" type="date" readonly
                                    value="{{ old('year_of_manufacture', $vehicle->YearOfManufacture ? \Illuminate\Support\Carbon::parse($vehicle->YearOfManufacture)->format('Y-m-d') : '') }}"
                                    class="block w-full cursor-not-allowed rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-500 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                @error('year_of_manufacture')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="remark"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">
                                    Opmerking
                                </label>
                                <textarea id="remark" name="remark" rows="4"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">{{ old('remark', $vehicle->Remark) }}</textarea>
                                @error('remark')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <button type="submit"
                                class="inline-flex items-center rounded-lg bg-amber-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-amber-700">
                                Wijzig
                            </button>
                            <a href="{{ route('vehicle.index', ['instructorId' => $instructorId]) }}"
                                class="inline-flex items-center rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                Terug naar beschikbare voertuigen
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>