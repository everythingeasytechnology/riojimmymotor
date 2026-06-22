<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of contact form leads.
     */
    public function index()
    {
        $leads = Lead::with('assignedAgent')->latest()->paginate(10);
        $agents = User::all(); // Potential target agents list
        
        return view('admin.leads.index', compact('leads', 'agents'));
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
     * Assign a lead to a support agent.
     */
    public function assign(Request $request, Lead $lead)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id'
        ]);

        $lead->assigned_to = $request->agent_id;
        $lead->status = 'in_progress';
        $lead->save();

        return redirect()->route('admin.leads.index')->with('success', 'Lead assigned successfully.');
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
