@extends('layouts.ForumApp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-6">Эмчний мэдээлэл бүртгэх</h2>

        <form method="POST" action="{{ route('doctor-info.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div class="mb-4">
                    <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">
                        Бүтэн нэр
                    </label>
                    <input type="text" name="full_name" id="full_name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required>
                </div>


                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Утасны дугаар</label>
                    <input type="text" name="phone_number" id="phone_number"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Workplace -->
                <div>
                    <label for="workplace" class="block text-sm font-medium text-gray-700">Ажилладаг газар</label>
                    <input type="text" name="workplace" id="workplace"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Хаяг</label>
                    <input type="text" name="address" id="address"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Education -->
                <div>
                    <label for="education" class="block text-sm font-medium text-gray-700">Боловсрол</label>
                    <input type="text" name="education" id="education"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Years Experience -->
                <div>
                    <label for="years_experience" class="block text-sm font-medium text-gray-700">Туршлага (жил)</label>
                    <input type="number" name="years_experience" id="years_experience" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Languages -->
                <div>
                    <label for="languages" class="block text-sm font-medium text-gray-700">Хэлний мэдлэг</label>
                    <input type="text" name="languages" id="languages"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Profile Photo -->
                {{-- <div>
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700">Профайл зураг</label>
                    <input type="file" name="profile_photo" id="profile_photo"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           accept="image/*">
                </div> --}}
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Хадгалах
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
