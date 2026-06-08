@extends('layouts.main')

@section('title', 'Kelola Fasilitator — ARQAM')

@section('content')
    <x-page-header title="Kelola Fasilitator" subtitle="Buat dan kelola akun fasilitator yang dapat mengelola event." />

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"
         x-data="{ showAddModal: {{ $errors->any() ? 'true' : 'false' }}, showResetModal: false, resetFasId: null, resetFasName: '' }">

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.fasilitator.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama, email, username..."
                    class="w-full sm:w-72 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <x-button type="submit" variant="primary">Cari</x-button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.fasilitator.index') }}" class="text-xs text-gray-500 hover:text-red-500 underline transition-colors">Reset</a>
            @endif
        </form>

        {{-- Tambah Fasilitator Button --}}
        <button type="button" @click="showAddModal = true"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-sm hover:shadow-md active:scale-95 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Fasilitator
        </button>

        {{-- ============================================================ --}}
        {{-- MODAL: Tambah Fasilitator --}}
        {{-- ============================================================ --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" style="display:none;">
            <div x-show="showAddModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showAddModal = false"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showAddModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.outside="showAddModal = false"
                     class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

                    {{-- Header --}}
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-primary/5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 font-heading">Tambah Fasilitator Baru</h3>
                        </div>
                        <button @click="showAddModal = false"
                                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Form --}}
                    <form method="POST" action="{{ route('admin.fasilitator.store') }}">
                        @csrf
                        <div class="px-6 py-5 space-y-4">

                            {{-- Validation Errors --}}
                            @if($errors->any())
                                <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                                    <ul class="text-xs text-red-700 space-y-1 list-disc list-inside">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="Contoh: Ahmad Fauzi, S.Pd."
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="fasilitator@example.com"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="username" value="{{ old('username') }}" required
                                    placeholder="fas_ahmad (huruf, angka, - atau _)"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-mono">
                                <p class="mt-1 text-[10px] text-gray-400">Digunakan untuk login. Hanya huruf, angka, strip, dan garis bawah.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" required minlength="6"
                                        placeholder="Min. 6 karakter"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" required minlength="6"
                                        placeholder="Ulangi password"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                                </div>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="px-6 py-4 bg-gray-50/60 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showAddModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-xl hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MODAL: Reset Password --}}
        {{-- ============================================================ --}}
        <div x-show="showResetModal" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" style="display:none;">
            <div x-show="showResetModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 @click="showResetModal = false"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showResetModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     @click.outside="showResetModal = false"
                     class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-amber-50/60">
                        <h3 class="text-base font-semibold text-amber-800 font-heading">Reset Password Fasilitator</h3>
                        <button @click="showResetModal = false"
                                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" :action="'/admin/fasilitator/' + resetFasId + '/reset-password'">
                        @csrf
                        <div class="px-6 py-5 space-y-4">
                            <p class="text-sm text-gray-600">
                                Reset password untuk: <span class="font-semibold text-gray-800" x-text="resetFasName"></span>
                            </p>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required minlength="6"
                                    placeholder="Min. 6 karakter"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required minlength="6"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50/60 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showResetModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-xl hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-semibold rounded-xl hover:bg-amber-600 transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TABLE --}}
        {{-- ============================================================ --}}
        {{-- NOTE: The table is placed outside x-data scope intentionally,
             we use @click handlers that bubble up to the parent x-data --}}
    </div>

    {{-- Fasilitator Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
         x-data="{ showResetModal: false, resetFasId: null, resetFasName: '' }">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600">Fasilitator</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Username</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Event Ditugaskan</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($fasilitators as $fas)
                    <tr class="hover:bg-gray-50/50 transition-colors group">

                        {{-- Nama + Email --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 ring-2 ring-primary/5">
                                    <span class="text-xs font-bold text-primary">{{ strtoupper(substr($fas->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $fas->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $fas->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Username --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 font-mono text-xs">
                                {{ $fas->username }}
                            </span>
                        </td>

                        {{-- Jumlah Event --}}
                        <td class="px-6 py-4 text-center">
                            @if($fas->assigned_events_count > 0)
                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                                    {{ $fas->assigned_events_count }} event
                                </span>
                            @else
                                <span class="text-xs text-gray-400 italic">Belum ditugaskan</span>
                            @endif
                        </td>

                        {{-- Tanggal dibuat --}}
                        <td class="px-6 py-4 text-center text-gray-500 text-xs">
                            {{ $fas->created_at->format('d M Y') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Detail --}}
                                <a href="{{ route('admin.fasilitator.show', $fas->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/5 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>

                                {{-- Reset Password --}}
                                <button type="button"
                                    @click="showResetModal = true; resetFasId = {{ $fas->id }}; resetFasName = '{{ addslashes($fas->name) }}'"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-lg text-xs font-bold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    Reset Password
                                </button>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('admin.fasilitator.destroy', $fas->id) }}"
                                      onsubmit="return confirm('Hapus fasilitator \'{{ addslashes($fas->name) }}\'? Semua penugasan event-nya akan ikut dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Belum ada fasilitator</p>
                                <p class="text-xs text-gray-400">Klik tombol "Tambah Fasilitator" untuk membuat akun baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($fasilitators->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $fasilitators->links() }}
        </div>
        @endif

        {{-- Reset Password Modal (scoped inside this x-data) --}}
        <div x-show="showResetModal" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" style="display:none;">
            <div x-show="showResetModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 @click="showResetModal = false"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showResetModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     @click.outside="showResetModal = false"
                     class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-amber-50/60">
                        <h3 class="text-base font-semibold text-amber-800 font-heading">Reset Password Fasilitator</h3>
                        <button @click="showResetModal = false"
                                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" :action="'/admin/fasilitator/' + resetFasId + '/reset-password'">
                        @csrf
                        <div class="px-6 py-5 space-y-4">
                            <p class="text-sm text-gray-600">
                                Reset password untuk: <span class="font-semibold text-gray-800" x-text="resetFasName"></span>
                            </p>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required minlength="6"
                                    placeholder="Min. 6 karakter"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required minlength="6"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50/60 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showResetModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-xl hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-semibold rounded-xl hover:bg-amber-600 transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
