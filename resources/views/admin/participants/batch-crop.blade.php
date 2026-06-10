@extends('layouts.main')

@section('title', 'Batch Crop Foto Profil Lama — ARQAM')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Auto-Crop Pas Foto Lama</h1>
                <p class="text-sm text-gray-500 mt-1">Gunakan teknologi deteksi wajah otomatis untuk merapikan semua foto profil lama yang sudah ada di database.</p>
            </div>
            <div>
                <a href="{{ route('admin.participants.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl text-sm font-bold transition-all">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- Control Panel Card --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-1">
                    <h2 class="text-lg font-bold text-gray-800">Status Database</h2>
                    <p class="text-sm text-gray-500">Ditemukan <strong class="text-primary font-bold">{{ count($participants) }}</strong> peserta yang memiliki foto profil di sistem.</p>
                </div>
                <div>
                    <button type="button" id="startBatchBtn" onclick="startBatchProcessing()" 
                            class="px-6 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-600 transition-all shadow-md active:scale-95 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Mulai Selaraskan Semua Foto
                    </button>
                </div>
            </div>

            {{-- Progress Box (Hidden at first) --}}
            <div id="progressBox" class="mt-8 space-y-4 hidden border-t border-gray-100 pt-6">
                <div class="flex justify-between items-center text-sm font-semibold">
                    <span id="progressStatus" class="text-gray-700">Menghubungkan & Memuat Model Deteksi...</span>
                    <span id="progressPercent" class="text-primary">0%</span>
                </div>
                
                {{-- Progress Bar --}}
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div id="progressBar" class="bg-gradient-to-r from-primary to-primary-700 h-full w-0 transition-all duration-300 rounded-full"></div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs font-semibold text-gray-500 pt-2">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Total Antrean</p>
                        <p id="statTotal" class="text-lg font-bold text-gray-800 mt-0.5">{{ count($participants) }}</p>
                    </div>
                    <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                        <p class="text-[10px] text-emerald-600 uppercase tracking-wider">Berhasil Dideteksi</p>
                        <p id="statSuccess" class="text-lg font-bold text-emerald-700 mt-0.5">0</p>
                    </div>
                    <div class="bg-amber-50/70 p-3 rounded-xl border border-amber-100">
                        <p class="text-[10px] text-amber-600 uppercase tracking-wider">Selesai Tanpa Deteksi</p>
                        <p id="statNoFace" class="text-lg font-bold text-amber-700 mt-0.5">0</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-xl border border-red-100">
                        <p class="text-[10px] text-red-600 uppercase tracking-wider">Gagal</p>
                        <p id="statFailed" class="text-lg font-bold text-red-700 mt-0.5">0</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Working Area (Image elements used by script, hidden) --}}
        <div class="hidden">
            <img id="tempImage" crossOrigin="anonymous">
            <canvas id="tempCanvas"></canvas>
        </div>

        {{-- Processing Queue Grid --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h3 class="text-md font-bold text-gray-800 mb-4">Daftar Foto Peserta</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 font-semibold text-gray-600">Peserta</th>
                            <th class="px-6 py-4 font-semibold text-gray-600">Foto Asli</th>
                            <th class="px-6 py-4 font-semibold text-gray-600">Hasil Pemotongan</th>
                            <th class="px-6 py-4 font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="participantsTableBody">
                        @forelse($participants as $p)
                            <tr id="row-{{ $p->id }}" class="hover:bg-gray-50/30 transition-colors group">
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $p->nama_lengkap }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ $p->foto_url }}" class="w-12 h-16 object-cover rounded-lg border border-gray-200 shadow-sm">
                                </td>
                                <td class="px-6 py-4" id="cropped-cell-{{ $p->id }}">
                                    <div class="w-12 h-16 bg-gray-100 border border-dashed border-gray-300 rounded-lg flex items-center justify-center text-[10px] text-gray-400">
                                        Antre
                                    </div>
                                </td>
                                <td class="px-6 py-4" id="status-cell-{{ $p->id }}">
                                    <span class="px-2.5 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded-full">
                                        Menunggu...
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    Tidak ada data peserta yang memiliki foto.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.12/dist/face-api.js"></script>
<script>
    const csrfToken = '{{ csrf_token() }}';
    const participants = @json($participants);
    
    let isProcessing = false;
    let faceapiLoaded = false;
    let faceapiModelsLoaded = false;

    let index = 0;
    let successCount = 0;
    let noFaceCount = 0;
    let failedCount = 0;
    async function initFaceApi() {
        if (faceapiLoaded) return;
        try {
            await faceapi.nets.tinyFaceDetector.loadFromUri('https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model');
            faceapiLoaded = true;
            faceapiModelsLoaded = true;
        } catch (e) {
            console.error("Gagal memuat model deteksi wajah:", e);
            throw new Error("Gagal mengunduh model AI wajah.");
        }
    }

    async function startBatchProcessing() {
        if (isProcessing) return;
        if (participants.length === 0) {
            alert('Tidak ada foto untuk diselaraskan.');
            return;
        }

        isProcessing = true;
        document.getElementById('startBatchBtn').disabled = true;
        document.getElementById('startBatchBtn').classList.add('opacity-50');
        
        const progressBox = document.getElementById('progressBox');
        progressBox.classList.remove('hidden');
        
        try {
            document.getElementById('progressStatus').innerText = "Memuat model deteksi wajah AI...";
            await initFaceApi();
            
            document.getElementById('progressStatus').innerText = "Memulai pemotongan otomatis...";
            processNext();
        } catch (err) {
            alert('Error inisialisasi: ' + err.message);
            isProcessing = false;
            document.getElementById('startBatchBtn').disabled = false;
            document.getElementById('startBatchBtn').classList.remove('opacity-50');
        }
    }

    async function processNext() {
        if (index >= participants.length) {
            document.getElementById('progressStatus').innerText = "Selesai memproses seluruh foto!";
            isProcessing = false;
            return;
        }

        const participant = participants[index];
        const row = document.getElementById(`row-${participant.id}`);
        const statusCell = document.getElementById(`status-cell-${participant.id}`);
        const croppedCell = document.getElementById(`cropped-cell-${participant.id}`);

        statusCell.innerHTML = `
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-100 rounded-full">
                <svg class="animate-spin h-3.5 w-3.5 text-blue-700" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            </span>
        `;
        row.scrollIntoView({ behavior: 'smooth', block: 'center' });

        try {
            // Load image into hidden element to run face detection and crop
            const img = document.getElementById('tempImage');
            
            // Convert to dataurl or handle with proxy to avoid CORS tainted canvas
            // Because storage folder is in same domain, we can fetch it directly
            const fotoUrl = participant.foto_url;
            
            await new Promise((resolve, reject) => {
                img.onload = () => resolve();
                img.onerror = () => reject(new Error("Gagal memuat file gambar"));
                img.src = fotoUrl;
            });

            // Perform Face Detection
            const detections = await faceapi.detectAllFaces(img, new faceapi.TinyFaceDetectorOptions());
            
            const canvas = document.getElementById('tempCanvas');
            const ctx = canvas.getContext('2d');
            
            // Target pas foto 3:4 aspect ratio
            canvas.width = 300;
            canvas.height = 400;
            
            let sourceX = 0, sourceY = 0, sourceWidth = img.naturalWidth, sourceHeight = img.naturalHeight;
            let detectType = "noface";

            if (detections && detections.length > 0) {
                const face = detections[0].box;
                detectType = "success";

                // Count coordinates
                const faceCenterX = face.x + (face.width / 2);
                const faceCenterY = face.y + (face.height / 2);

                // Target cropping box on face with 3:4 ratio
                sourceWidth = Math.max(face.width, face.height * 0.75) * 2.4;
                sourceHeight = sourceWidth * (4/3);

                // Boundaries checking
                sourceX = faceCenterX - (sourceWidth / 2);
                sourceY = faceCenterY - (sourceHeight * 0.42); // offset a bit up

                // Prevent boundary out and maintain 3:4 aspect ratio
                if (sourceX < 0) {
                    sourceX = 0;
                }
                if (sourceY < 0) {
                    sourceY = 0;
                }
                if (sourceX + sourceWidth > img.naturalWidth) {
                    sourceWidth = img.naturalWidth - sourceX;
                    sourceHeight = sourceWidth * (4/3);
                }
                if (sourceY + sourceHeight > img.naturalHeight) {
                    sourceHeight = img.naturalHeight - sourceY;
                    sourceWidth = sourceHeight * (3/4);
                }
            } else {
                // Fallback: standard 3:4 center crop
                if (sourceWidth / sourceHeight > 3/4) {
                    // Wide image: crop left & right
                    sourceWidth = sourceHeight * (3/4);
                    sourceX = (img.naturalWidth - sourceWidth) / 2;
                } else {
                    // Tall image: crop top & bottom
                    sourceHeight = sourceWidth * (4/3);
                    sourceY = (img.naturalHeight - sourceHeight) / 2;
                }
            }

            // Draw to canvas
            ctx.drawImage(img, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, 300, 400);
            
            const croppedBase64 = canvas.toDataURL('image/jpeg', 0.95);

            // Upload cropped back to server
            const uploadRes = await fetch(`/admin/participants/${participant.id}/update-cropped`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ cropped_foto: croppedBase64 })
            });

            const response = await uploadRes.json();
            
            if (response.success) {
                croppedCell.innerHTML = `<img src="${croppedBase64}" class="w-12 h-16 object-cover rounded-lg border border-emerald-200 shadow-sm animate-fade-in">`;
                
                if (detectType === "success") {
                    successCount++;
                    document.getElementById('statSuccess').innerText = successCount;
                    statusCell.innerHTML = `<span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-full">Wajah Centered</span>`;
                } else {
                    noFaceCount++;
                    document.getElementById('statNoFace').innerText = noFaceCount;
                    statusCell.innerHTML = `<span class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-100 rounded-full">Center Crop (Manual)</span>`;
                }
            } else {
                throw new Error(response.message || "Gagal memperbarui");
            }

        } catch (err) {
            console.error(err);
            failedCount++;
            document.getElementById('statFailed').innerText = failedCount;
            statusCell.innerHTML = `<span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 border border-red-100 rounded-full" title="${err.message}">Gagal</span>`;
        }

        // Update Progress Bar
        index++;
        const percent = Math.round((index / participants.length) * 100);
        document.getElementById('progressPercent').innerText = `${percent}%`;
        document.getElementById('progressBar').style.width = `${percent}%`;
        document.getElementById('progressStatus').innerText = `Memproses foto ke-${index} dari ${participants.length}...`;

        // Process next delay
        setTimeout(processNext, 500);
    }
</script>
@endpush
