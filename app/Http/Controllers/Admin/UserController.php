<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search Scope
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Role Filter (if needed later)
        if ($role = $request->input('role')) {
            // Assuming explicit role column or relationship
            // $query->where('role', $role);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // For standard "View User" modal/page
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $user->id,
            'type' => 'required|in:admin,seller,buyer,user', // adjusting roles based on User model
            'status' => 'required|in:active,inactive,banned',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Export users to CSV.
     */
    public function export()
    {
        $fileName = 'users-export-' . date('Y-m-d') . '.csv';
        $users = User::all();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('ID', 'Name', 'Phone', 'Role', 'Status', 'Joined Date');

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                $row['ID'] = $user->id;
                $row['Name'] = $user->name;
                $row['Phone'] = $user->phone_number;
                $row['Role'] = $user->type;
                $row['Status'] = $user->status instanceof \App\Utility\Enums\UserStatusEnum ? $user->status->value : $user->status;
                $row['Joined Date'] = $user->created_at->format('Y-m-d H:i:s');

                fputcsv($file, array($row['ID'], $row['Name'], $row['Phone'], $row['Role'], $row['Status'], $row['Joined Date']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Typically we don't hard delete users, but for now:
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
