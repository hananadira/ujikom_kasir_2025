@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
    <!-- Breadcrumb -->
    <nav class="mb-4 text-sm text-gray-600 flex items-center gap-2">
        <a href="#" class="text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-gray-800 dark:text-gray" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
            </svg>                      
        </a> >
        <a href="#" class="text-blue-600 hover:underline">User</a>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center pb-4">
        <h2 class="text-3xl font-bold text-gray-900">User</h2>
    </div>

    <!-- Card untuk Form -->
    <div class="bg-white shadow-sm rounded p-8 mt-10">
        <form action="{{ route('admin.users.update', $users->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-2 gap-4">
                <!-- Nama -->
                <div>
                    <label class="text-gray-700 font-semibold">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror" value="{{ old('name', $users->name) }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="text-gray-700 font-semibold">Email <span class="text-red-500">*</span></label>
                    <input type="text" name="email" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror" value="{{ old('email', $users->email) }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Role -->
                <div>
                    <label class="text-gray-700 font-semibold">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full border rounded-md p-2">
                        <option disabled>Pilih Role</option>
                        <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="employee" {{ $users->role == 'employee' ? 'selected' : '' }}>Employee</option>
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
