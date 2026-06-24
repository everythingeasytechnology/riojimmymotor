<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::latest()->paginate(10);
        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Mark a lead as read.
     */
    public function markRead(Lead $lead)
    {
        $lead->is_read = true;
        $lead->save();

        return response()->json(['success' => true, 'message' => 'Lead marked as read.']);
    }

    /**
     * Remove a lead.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted successfully.');
    }
}
