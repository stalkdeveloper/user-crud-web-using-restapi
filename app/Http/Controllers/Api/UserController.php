<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            /* $page = $request['page'] ?? 1; 
            $perPage = 10;
            $users = User::with('role')->orderBy('updated_at', 'desc')->paginate($perPage); */
            $page = $request->page ?? 1; 
            $perPage = 10;
            $search = $request->search ?? null;
            \Log::info([
                'page ' => $page,
                'perPage ' => $perPage,
                'search' => $search,
                'request ' => $request->all()
            ]);
            $query = User::with('role')->orderBy('updated_at', 'desc');

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhereHas('role', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
            }

            $users = $query->paginate($perPage);
            return response()->json([
                'status' => true, 'status_code' => 200, 'message' => 'Users retrieved successfully', 'data' => UserResource::collection($users),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'total_pages' => $users->lastPage(),
                    'total_items' => $users->total(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 'status_code' => 500, 'message' => 'Something went wrong. Please try again later.', 'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $validated['profile_image'] = $imagePath;
            }

            $user = User::create($validated);

            return response()->json([
                'status' => true, 'status_code' => 201, 'message' => 'User created successfully', 'data' => new UserResource($user),
            ], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return response()->json([
                'status' => false, 'status_code' => 400, 'message' => 'Failed to create user.', 'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with('role')->findOrFail($id);
            return response()->json([
                'status' => true, 'status_code' => 200, 'message' => 'User retrieved successfully', 'data' => new UserResource($user),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false, 'status_code' => 404, 'message' => 'User not found.', 'data' => null
            ], 404);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return response()->json([
                'status' => false, 'status_code' => 500, 'message' => 'Something went wrong.', 'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $user = User::findOrFail($id);
            $user->update($validated);

            if ($request->hasFile('profile_image')) {
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }
        
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $user->update(['profile_image' => $imagePath]);
            }

            return response()->json([
                'status' => true, 'status_code' => 200, 'message' => 'User updated successfully', 'data' => new UserResource($user),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false, 'status_code' => 404, 'message' => 'User not found.', 'data' => null
            ], 404);
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return response()->json([
                'status' => false, 'status_code' => 500, 'message' => 'Failed to update user.', 'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['status' => true, 'status_code' => 200, 'message' => 'User deleted successfully.', 'data' => new UserResource($user),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => false, 'status_code' => 404, 'message' => 'User not found.', 'data'=>null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'status_code' => 500, 'message' => 'Failed to delete user.', 'error' => $e->getMessage(),
            ], 500);
        }
    }
}

