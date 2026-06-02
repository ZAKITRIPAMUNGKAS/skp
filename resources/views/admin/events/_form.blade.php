{{-- Shared form partial for Event create/edit --}}
@php $event = $event ?? null; @endphp

<div class="space-y-6">
    {{-- Nama Event --}}
    <div>
        <label for="nama_event" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Event <span class="text-red-500">*</span></label>
        <input type="text" id="nama_event" name="nama_event"
            value="{{ old('nama_event', $event?->nama_event) }}"
            class="w-full px-4 py-3 text-sm border {{ $errors->has('nama_event') ? 'border-red-300 bg-red-50/50' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white"
            placeholder="Contoh: Baitul Arqam Angkatan I Tahun 2026" required>
        @error('nama_event')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Date range --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                value="{{ old('tanggal_mulai', $event?->tanggal_mulai?->format('Y-m-d')) }}"
                class="w-full px-4 py-3 text-sm border {{ $errors->has('tanggal_mulai') ? 'border-red-300' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
            @error('tanggal_mulai')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                value="{{ old('tanggal_selesai', $event?->tanggal_selesai?->format('Y-m-d')) }}"
                class="w-full px-4 py-3 text-sm border {{ $errors->has('tanggal_selesai') ? 'border-red-300' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
            @error('tanggal_selesai')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Lokasi & Kuota --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
            <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi"
                value="{{ old('lokasi', $event?->lokasi) }}"
                class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white"
                placeholder="Contoh: Kampus Utama - Gedung Serbaguna">
            @error('lokasi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="kuota" class="block text-sm font-medium text-gray-700 mb-1.5">Kuota Peserta</label>
            <input type="number" id="kuota" name="kuota"
                value="{{ old('kuota', $event?->kuota) }}"
                class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white"
                placeholder="Contoh: 100" min="0">
            @error('kuota')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"
            class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white resize-none"
            placeholder="Deskripsi kegiatan...">{{ old('deskripsi', $event?->deskripsi) }}</textarea>
        @error('deskripsi')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
        <select id="status" name="status"
            class="w-full px-4 py-3 text-sm border {{ $errors->has('status') ? 'border-red-300' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
            <option value="persiapan" {{ old('status', $event?->status) == 'persiapan' ? 'selected' : '' }}>Persiapan</option>
            <option value="berlangsung" {{ old('status', $event?->status) == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
            <option value="selesai" {{ old('status', $event?->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        @error('status')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
