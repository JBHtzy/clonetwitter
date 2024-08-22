<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = Room::paginate(10);
        return view('admin-pov.room.room', [
            'rooms' => $rooms,
            // 'roomspag' => Room::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roomtypes = RoomType::all();
        return response(['datas' => $roomtypes], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        //
        try {

            $validated = $request->validated();

            $rooms = new Room();
            $rooms->roomtype_id = $validated['roomtypeId'];
            $rooms->room_name = $validated['roomname'];
            $rooms->save();

            $rooms = Room::with('roomtype')->latest()->first(); // gets data with relationship

            return response(['message' => 'Successfully added', $rooms], 201);
        } catch (\Exception $e) {
            // return $e->getMessage();
            return response(['error' => 'Create room unsuccessfully'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // $data = Room::find($id);
        $data = Room::with('roomtype')->findOrFail($id);
        $roomtypes = RoomType::all();
        return response(['data' => $data, 'roomtypes' => $roomtypes], 201);
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
    public function update(RoomRequest $request, string $id)
    {
        //
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            // $id = $request->roomtypeId;
            $data = Room::with('roomtype')->findOrFail($id);

            if (!$data) {
                return response(['error' => 'Room not found'], 404);
            }

            $data->room_name = $validated['roomname'];
            $data->roomtype->title = $validated['title'];
            $data->roomtype->detail = $validated['detail'];
            $data->push();

            DB::commit();

            return response(['message' => 'Updated Success', 'datas' => $data], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return response(['error' => 'Update unsuccessfully'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {

            $roomdel = Room::with('roomtype')->findOrFail($id);
            $roomdel->roomtype()->delete();
            $roomdel->delete();

            return response(['message' => 'Deleted Successfully', $roomdel], 201);
        } catch (\Exception $e) {

            return response(['error' => 'Deleted unsuccessfully'], 404);
        }
    }
}
