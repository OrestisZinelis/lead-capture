<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return response()->json($leads);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:leads',
            'consent' => 'required|boolean',
        ]);

        $lead = Lead::create($validatedData);

        if ($validatedData['consent']) {
            Newsletter::subscribeOrUpdate($validatedData['email'], ['FNAME' => $validatedData['name']]);
        }

        return response()->json(['message' => 'Lead created successfully', 'lead' => $lead]);
    }

    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return response()->json($lead);
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:leads,email,' . $lead->id,
            'consent' => 'required|boolean',
        ]);

        $lead->update($validatedData);

        if ($validatedData['consent']) {
            Newsletter::subscribeOrUpdate($validatedData['email'], ['FNAME' => $validatedData['name']]);
        } else {
            Newsletter::unsubscribe($validatedData['email']);
        }

        return response()->json(['message' => 'Lead updated successfully', 'lead' => $lead]);
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        Newsletter::delete($lead->email);
        $lead->delete();

        return response()->json(['message' => 'Lead deleted successfully']);
    }
}
