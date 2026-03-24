@extends('layouts.user')

@section('title', 'Submit KYC - GoldVault')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">Submit KYC Verification</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">Provide your identity documents for verification</p>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-[#D4AF37]/20">
            <h3 class="text-lg font-semibold text-white">Identity Verification</h3>
            <p class="text-[#A0A0A0] text-sm mt-1">Please provide clear photos of your driver's license and a selfie video.</p>
        </div>

        <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data" x-data="kycForm()">
            @csrf

            <div class="p-6 space-y-8">
                {{-- ID Front Upload --}}
                <div>
                    <label class="block text-sm font-medium text-white mb-3">Driver's License - Front Side</label>
                    <div class="relative">
                        <input type="file" 
                               name="id_front" 
                               id="id_front"
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden"
                               @change="handleFileChange($event, 'front')"
                               required>
                        <label for="id_front" 
                               class="block w-full cursor-pointer border-2 border-dashed border-[#D4AF37]/30 rounded-xl p-8 text-center hover:border-[#D4AF37]/60 transition-colors"
                               :class="{ 'border-[#D4AF37] bg-[#D4AF37]/5': frontPreview }">
                            <template x-if="!frontPreview">
                                <div>
                                    <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/>
                                        </svg>
                                    </div>
                                    <p class="text-white font-medium mb-1">Click to upload front of ID</p>
                                    <p class="text-sm text-[#A0A0A0]">JPEG, PNG up to 5MB</p>
                                </div>
                            </template>
                            <template x-if="frontPreview">
                                <div class="relative">
                                    <img :src="frontPreview" class="max-h-48 mx-auto rounded-lg">
                                    <button type="button" 
                                            @click.prevent="clearFile('front')"
                                            class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                        </label>
                    </div>
                    @error('id_front')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ID Back Upload --}}
                <div>
                    <label class="block text-sm font-medium text-white mb-3">Driver's License - Back Side</label>
                    <div class="relative">
                        <input type="file" 
                               name="id_back" 
                               id="id_back"
                               accept="image/jpeg,image/png,image/jpg"
                               class="hidden"
                               @change="handleFileChange($event, 'back')"
                               required>
                        <label for="id_back" 
                               class="block w-full cursor-pointer border-2 border-dashed border-[#D4AF37]/30 rounded-xl p-8 text-center hover:border-[#D4AF37]/60 transition-colors"
                               :class="{ 'border-[#D4AF37] bg-[#D4AF37]/5': backPreview }">
                            <template x-if="!backPreview">
                                <div>
                                    <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/>
                                        </svg>
                                    </div>
                                    <p class="text-white font-medium mb-1">Click to upload back of ID</p>
                                    <p class="text-sm text-[#A0A0A0]">JPEG, PNG up to 5MB</p>
                                </div>
                            </template>
                            <template x-if="backPreview">
                                <div class="relative">
                                    <img :src="backPreview" class="max-h-48 mx-auto rounded-lg">
                                    <button type="button" 
                                            @click.prevent="clearFile('back')"
                                            class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                        </label>
                    </div>
                    @error('id_back')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Selfie Video Upload --}}
                <div>
                    <label class="block text-sm font-medium text-white mb-3">Selfie Video</label>
                    <div class="bg-[#0A0A0A] rounded-xl p-4 mb-3">
                        <h4 class="text-sm font-medium text-[#D4AF37] mb-2">Instructions:</h4>
                        <ul class="text-sm text-[#A0A0A0] space-y-1">
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                                Record a short video (5-10 seconds) of yourself
                            </li>
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                                Ensure your face is clearly visible and well-lit
                            </li>
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                                Slowly turn your head left and right
                            </li>
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><path d="M20 6 9 17l-5-5"/></svg>
                                Do not wear sunglasses or hats
                            </li>
                        </ul>
                    </div>
                    <div class="relative">
                        <input type="file" 
                               name="selfie_video" 
                               id="selfie_video"
                               accept="video/mp4,video/quicktime,video/webm"
                               class="hidden"
                               @change="handleVideoChange($event)"
                               required>
                        <label for="selfie_video" 
                               class="block w-full cursor-pointer border-2 border-dashed border-[#D4AF37]/30 rounded-xl p-8 text-center hover:border-[#D4AF37]/60 transition-colors"
                               :class="{ 'border-[#D4AF37] bg-[#D4AF37]/5': videoPreview }">
                            <template x-if="!videoPreview">
                                <div>
                                    <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                                            <path d="m22 8-6 4-6-4V6l6 4 6-4Z"/><path d="M2 8v8"/><path d="M4 12V8a4 4 0 0 1 4-4h12"/><path d="M6 12v8"/><path d="m10 12 6 4 6-4"/>
                                        </svg>
                                    </div>
                                    <p class="text-white font-medium mb-1">Click to upload selfie video</p>
                                    <p class="text-sm text-[#A0A0A0]">MP4, MOV, WebM up to 50MB</p>
                                </div>
                            </template>
                            <template x-if="videoPreview">
                                <div class="relative">
                                    <video :src="videoPreview" class="max-h-48 mx-auto rounded-lg" controls></video>
                                    <button type="button" 
                                            @click.prevent="clearVideo()"
                                            class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                        </label>
                    </div>
                    @error('selfie_video')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="p-6 border-t border-[#D4AF37]/20 bg-[#0A0A0A]">
                <div class="flex items-center gap-3 mb-6">
                    <input type="checkbox" id="terms" required class="w-4 h-4 rounded border-[#D4AF37]/30 bg-[#141414] text-[#D4AF37] focus:ring-[#D4AF37]">
                    <label for="terms" class="text-sm text-[#A0A0A0]">
                        I confirm that the documents provided are genuine and belong to me. I understand that providing false information may result in account suspension.
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <a href="{{ route('kyc.index') }}" class="text-[#A0A0A0] hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="btn-primary"
                            :disabled="!frontPreview || !backPreview || !videoPreview"
                            :class="{ 'opacity-50 cursor-not-allowed': !frontPreview || !backPreview || !videoPreview }">
                        Submit for Verification
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function kycForm() {
        return {
            frontPreview: null,
            backPreview: null,
            videoPreview: null,

            handleFileChange(event, type) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (type === 'front') {
                            this.frontPreview = e.target.result;
                        } else {
                            this.backPreview = e.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            },

            handleVideoChange(event) {
                const file = event.target.files[0];
                if (file) {
                    this.videoPreview = URL.createObjectURL(file);
                }
            },

            clearFile(type) {
                if (type === 'front') {
                    this.frontPreview = null;
                    document.getElementById('id_front').value = '';
                } else {
                    this.backPreview = null;
                    document.getElementById('id_back').value = '';
                }
            },

            clearVideo() {
                this.videoPreview = null;
                document.getElementById('selfie_video').value = '';
            }
        }
    }
</script>
@endpush
@endsection
