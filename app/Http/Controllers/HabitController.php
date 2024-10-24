<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController
{

    public function getHabits(Request $request): JsonResponse
    {
        $data = $request->validate(['date' => ['required', 'date_format:Y-m']]);

        $habits = Auth::user()->habits()
            ->select(['id', 'title', 'goal', 'creation_date'])
            ->where('creation_date', 'like', $data['date'] . '%')
            ->with(['achievements' => function ($query) use ($data) {
                $query->where('achievement_date', 'like', $data['date'] . '%');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Habits fetched successfully',
            'data' => $habits
        ]);
    }

    public function addHabit(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'goal' => ['required', 'integer', 'numeric', 'min:0'],
        ]);

        $data['creation_date'] = date('Y-m-d');

        $habit = Auth::user()->habits()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Habit created successfully',
            'data' => $habit
        ]);
    }

    public function updateHabit(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'goal' => ['required', 'integer', 'numeric', 'min:0']
        ]);

        $habit = Habit::find($id);
        $habit->title = $data['title'];
        $habit->goal = $data['goal'];
        $habit->save();

        return response()->json([
            'success' => true,
            'message' => 'Habit updated successfully',
            'data' => $habit
        ]);
    }

    public function deleteHabit(int $id): JsonResponse
    {
        Habit::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Habit deleted successfully'
        ]);
    }

    public function toggleHabit(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'achievement_date' => ['required', 'date_format:Y-m-d']
        ]);

        $habit = Habit::find($id);
        $achievement = $habit->achievements()
            ->where('achievement_date', $data['achievement_date'])
            ->first();

        if ($achievement) {
            $achievement->delete();
        } else {
            $habit->achievements()->create(['achievement_date' => $data['achievement_date']]);
        }

        $habit->refresh();

        $date = Carbon::parse($data['achievement_date']);
        $yearMonth = $date->format('Y-m');

        $newHabit = Habit::with(['achievements' => function (HasMany $query) use ($yearMonth) {
            $query->where('achievement_date', 'like', $yearMonth . '%');
        }])->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Habit toggled successfully',
            'data' => $newHabit
        ]);
    }
}
