<?php

namespace App\Http\Controllers;

use App\Models\KycSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $latestSubmission = $user->latestKycSubmission;
        
        return view('kyc.index', compact('user', 'latestSubmission'));
    }

    public function create()
    {
        $user = auth()->user();
        
        // Check if user already has a pending submission
        if ($user->latestKycSubmission && $user->latestKycSubmission->isPending()) {
            return redirect()->route('kyc.index')
                ->with('info', 'You already have a pending KYC submission. Please wait for admin review.');
        }
        
        // Check if user is already verified
        if ($user->isKycVerified()) {
            return redirect()->route('kyc.index')
                ->with('info', 'Your KYC is already verified.');
        }
        
        return view('kyc.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Check if user already has a pending submission
        if ($user->latestKycSubmission && $user->latestKycSubmission->isPending()) {
            return redirect()->route('kyc.index')
                ->with('error', 'You already have a pending KYC submission.');
        }
        
        // Check if user is already verified
        if ($user->isKycVerified()) {
            return redirect()->route('kyc.index')
                ->with('error', 'Your KYC is already verified.');
        }

        $validated = $request->validate([
            'id_front' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'id_back' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'selfie_video' => ['required', 'mimetypes:video/mp4,video/quicktime,video/webm', 'max:51200'],
        ], [
            'id_front.required' => 'Please upload the front of your ID.',
            'id_front.image' => 'The front ID must be an image.',
            'id_front.mimes' => 'The front ID must be a JPEG or PNG file.',
            'id_front.max' => 'The front ID must not exceed 5MB.',
            'id_back.required' => 'Please upload the back of your ID.',
            'id_back.image' => 'The back ID must be an image.',
            'id_back.mimes' => 'The back ID must be a JPEG or PNG file.',
            'id_back.max' => 'The back ID must not exceed 5MB.',
            'selfie_video.required' => 'Please record a selfie video.',
            'selfie_video.mimetypes' => 'The selfie video must be in MP4, MOV, or WebM format.',
            'selfie_video.max' => 'The selfie video must not exceed 50MB.',
        ]);

        try {
            // Store files
            $idFrontPath = $request->file('id_front')->store('kyc/' . $user->id . '/id_front', 'private');
            $idBackPath = $request->file('id_back')->store('kyc/' . $user->id . '/id_back', 'private');
            $selfieVideoPath = $request->file('selfie_video')->store('kyc/' . $user->id . '/selfie', 'private');

            // Create KYC submission
            $submission = KycSubmission::create([
                'user_id' => $user->id,
                'id_front_path' => $idFrontPath,
                'id_back_path' => $idBackPath,
                'selfie_video_path' => $selfieVideoPath,
                'status' => 'pending',
            ]);

            // Update user KYC status to pending
            $user->update(['kyc_status' => 'pending']);

            return redirect()->route('kyc.index')
                ->with('success', 'Your KYC documents have been submitted successfully. We will review them shortly.');
        } catch (\Exception $e) {
            // Clean up any stored files if something went wrong
            if (isset($idFrontPath)) Storage::disk('private')->delete($idFrontPath);
            if (isset($idBackPath)) Storage::disk('private')->delete($idBackPath);
            if (isset($selfieVideoPath)) Storage::disk('private')->delete($selfieVideoPath);

            return redirect()->back()
                ->with('error', 'An error occurred while submitting your KYC. Please try again.');
        }
    }

    public function show(KycSubmission $kyc)
    {
        // Ensure users can only view their own KYC submissions
        if ($kyc->user_id !== auth()->id()) {
            abort(403);
        }

        return view('kyc.show', compact('kyc'));
    }

    public function document(KycSubmission $kyc, string $type)
    {
        // Ensure users can only access their own KYC documents
        if ($kyc->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $path = match($type) {
            'front' => $kyc->id_front_path,
            'back' => $kyc->id_back_path,
            'video' => $kyc->selfie_video_path,
            default => abort(404),
        };

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('private')->path($path));
    }
}
