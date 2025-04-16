@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-600 flex items-center gap-2">
        <a href="#" class="flex items-center text-blue-600 hover:underline">
            <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
            </svg>
            Dashboard
        </a>
        <span class="text-gray-400">/</span>
        <a href="#" class="text-blue-600 hover:underline">User</a>
        <span class="text-gray-400">/</span>
        <span class="text-gray-500">Buat User</span>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center pb-4">
        <h2 class="text-3xl font-bold text-gray-900">User</h2>
    </div>

    <!-- Card untuk Form -->
    <div class="bg-white shadow-sm rounded p-8 mt-10">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <!-- Nama -->
                <div>
                    <label class="text-gray-700 font-semibold">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="text-gray-700 font-semibold">Email <span class="text-red-500">*</span></label>
                    <input type="text" name="email" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Role -->
                <div>
                    <label class="text-gray-700 font-semibold">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('role') border-red-500 @enderror">
                        <option selected disabled>Pilih Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror   
                </div>
                
                <!-- Password -->
                <div>
                    <label class="text-gray-700 font-semibold">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror" value="{{ old('password') }}">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
