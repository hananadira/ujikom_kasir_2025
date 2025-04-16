@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
    <div class="max-w-full bg-white overflow-x-auto">
          <!-- Breadcrumb -->
          <nav class="mb-6 flex items-center text-sm text-gray-600 space-x-2">
            <a href="#" class="flex items-center text-blue-600 hover:underline hover:text-blue-800">
                <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
                </svg>
                Dashboard
            </a>
            <span>/</span>
            <a href="#" class="text-blue-600 hover:underline hover:text-blue-800">
                User
            </a>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center pb-6 mb-4">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Daftar User</h2>
        </div>
        
        <!-- Alerts -->
        @if(Session::get('success'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">{{ Session::get('success') }}</div>
        @endif
        @if(Session::get('deleted'))
        <div class="p-4 mb-4 text-yellow-800 bg-yellow-100 rounded-lg">{{ Session::get('deleted') }}</div>
        @endif
        @if(Session::get('gagal'))
        <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">{{ Session::get('gagal') }}</div>
        @endif
        
        <!-- Card Container -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Header Table -->
            <div class="flex justify-end pb-4">
                <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Tambah User
                </a>
            </div>
        
            <!-- Table -->
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($users as $user)
                        <tr class="bg-white border-b">
                            <td class="px-4 py-3">{{ $no++ }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->role }}</td>
                            <td class="px-4 py-3 flex justify-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded-lg hover:bg-yellow-500">EDIT</a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ url('admin/users/' . $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
        
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
