<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAffiliateController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        $totalReferrals = Referral::count();
        $totalConverted = Referral::whereIn('status', ['converted', 'paid'])->count();
        $totalCommissionPaid = Referral::where('status', 'paid')->sum('commission_amount');
        $totalCommissionPending = Referral::where('status', 'converted')->sum('commission_amount');

        $referrals = Referral::with(['referrer', 'referredUser'])
            ->latest()
            ->paginate(15);

        return view('admin.affiliates', compact(
            'page',
            'profile',
            'totalReferrals',
            'totalConverted',
            'totalCommissionPaid',
            'totalCommissionPending',
            'referrals'
        ));
    }

    public function update(Request $request, $id)
    {
        $referral = Referral::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,converted,paid',
            'commission_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        $referral->update($validated);

        return redirect()->back()->with('success', 'Referral status updated successfully.');
    }
}
