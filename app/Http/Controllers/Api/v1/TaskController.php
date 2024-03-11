<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//         return response()->json(['data' => TaskResource::collection(Task::orderBy('id')->cursorPaginate(5))]);
        try {
            $tasks = Task::orderBy('id')->cursorPaginate(5);
            if ($tasks->isEmpty()) {
                return response()->json(['message' => 'No tasks found.']);
            }
            return response()->json([
                'message' => 'Tasks fetched successfully.',
                'data' => TaskResource::collection($tasks)
            ]);
//            return response()->json($tasks);
        } catch (\Exception $e) {
            Log::error('Error fetching tasks: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch tasks.'], 500);
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
    public function store(StoreTaskRequest $request)
    {
        try {
            $validatedData                      = $request->validated();
            $validatedData['status_active']     = $validatedData['status_active'] ?? 1;
            $validatedData['is_delete']         = $validatedData['is_delete'] ?? 0;
            $task = Task::create($validatedData);
            return response()->json([
                'message'   => 'Task created successfully.',
                'data'      =>TaskResource::make($task)
            ], 201);
        } catch (\Exception $e)
        {
            Log::error('Error creating task: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create task.'.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            return response()->json([
                    'message'   => 'Task fetched successfully.',
                    'data'      => TaskResource::make($task)]
            );
        } catch (\Exception $e) {
            Log::error('Error fetching task: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch task.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $validatedData = $request->validated();
            $task->update($validatedData);
            return response()->json([
                'message'   => 'Task updated successfully.',
                'data'      =>TaskResource::make($task)
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update task.'.$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Task is Delete
         try {
            $task->delete();
            // return from resource collection
            return response()->json([
                'message' => 'Task deleted successfully.',
                'data' => TaskResource::make($task)
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete task.'], 500);
        }
    }
}
