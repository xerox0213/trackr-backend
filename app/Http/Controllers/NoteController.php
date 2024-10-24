<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController
{

    public function getNotes(Request $request): JsonResponse
    {
        $data = $request->validate(['date' => ['required', 'date_format:Y-m']]);

        $notes = Auth::user()->notes()
            ->select(['id', 'content', 'creation_date'])
            ->where('creation_date', 'LIKE', $data['date'] . '%')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Notes fetched successfully',
            'data' => $notes
        ]);
    }

    public function addNote(Request $request): JsonResponse
    {
        $data = $request->validate(['content' => ['required', 'string'],]);

        $data['creation_date'] = date('Y-m-d');
        $note = Auth::user()->notes()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Note added successfully',
            'data' => $note
        ]);
    }

    public function updateNote(Request $request, int $id): JsonResponse
    {
        $data = $request->validate(['content' => ['required', 'string']]);

        $note = Note::find($id);
        $note->content = $data['content'];
        $note->save();

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $note
        ]);
    }

    public function deleteNote(int $id): JsonResponse
    {
        Note::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ]);
    }

}
