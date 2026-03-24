<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function index()
    {
        $pendingKycs = KycSubmission::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(10, ['*'], 'pending_page');

        $approvedKycs = KycSubmission::where('status', 'approved')
            ->with(['user', 'reviewer'])
            ->latest()
            ->paginate(10, ['*'], 'approved_page');

        $rejectedKycs = KycSubmission::where('status', 'rejected')
            ->with(['user', 'reviewer'])
            ->latest()
            ->paginate(10, ['*'], 'rejected_page');

        $stats = [
            'pending' => KycSubmission::where('status', 'pending')->count(),
            'approved' => KycSubmission::where('status', 'approved')->count(),
            'rejected' => KycSubmission::where('status', 'rejected')->count(),
            'total' => KycSubmission::count(),
        ];

        return view('admin.kyc.index', compact('pendingKycs', 'approvedKycs', 'rejectedKycs', 'stats'));
    }

    public function show(KycSubmission $kyc)
    {
        $kyc->load(['user', 'reviewer']);
        return view('admin.kyc.show', compact('kyc'));
    }

    public function approve(Request $request, KycSubmission $kyc)
    {
        if (!$kyc->isPending()) {
            return redirect()->back()->with('error', 'This KYC submission has already been reviewed.');
        }

        $kyc->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Update user KYC status
        $kyc->user->update(['kyc_status' => 'verified']);

        // TODO: Send notification to user

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC submission approved successfully.');
    }

    public function reject(Request $request, KycSubmission $kyc)
    {
        if (!$kyc->isPending()) {
            return redirect()->back()->with('error', 'This KYC submission has already been reviewed.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Please provide a reason for rejection.',
            'rejection_reason.min' => 'The rejection reason must be at least 10 characters.',
        ]);

        $kyc->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Update user KYC status
        $kyc->user->update(['kyc_status' => 'rejected']);

        // TODO: Send notification to user

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC submission rejected successfully.');
    }

    public function document(KycSubmission $kyc, string $type)
    {
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
