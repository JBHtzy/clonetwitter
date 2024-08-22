<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Http\Requests\RoomtypeRequest;
use Illuminate\Support\Facades\DB;

class RoomtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = RoomType::all();
        return view('admin-pov.roomtype.roomtype', [
            'data' => $data,
            'users' => RoomType::paginate(10)
        ]);
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
    public function store(RoomtypeRequest $request)
    {

        DB::beginTransaction();

        try {

            $validated = $request->validated();

            $roomtype = new RoomType();
            $roomtype->title = $validated['title'];
            $roomtype->detail = $validated['detail'];
            $roomtype->save();

            DB::commit();

            return response(['message' => 'Successfully added', $roomtype], 201);
        } catch (\Exception $e) {
            DB::rollBack();
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
        $data = RoomType::find($id);

        return response([$data], 201);
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
    public function update(RoomtypeRequest $request, string $id)
    {
        //
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $data = RoomType::find($id);
            $data->title = $validated['title'];
            $data->detail = $validated['detail'];
            $data->update();

            DB::commit();

            return response(['message' => 'Updated Success', $data], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return response(['error' => 'Update unsuccessfully'], 404);
        }

        // return response([$data], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {

            $data = RoomType::find($id);
            $data->delete();

            DB::commit();

            return response(['message' => 'Deleted Successfully', $data], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['error' => 'Delete unsuccessfull'], 404);
        }
    }
}
