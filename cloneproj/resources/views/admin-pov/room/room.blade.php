@extends('layouts.admin')
@section('maincontents')

<h1 class="mt-4">Rooms</h1>
<div class="d-flex justify-content-end">
    <div class="btn btn-success" onclick="createRoomsModal()"><i class="fa-solid fa-plus"></i> Add Room</div>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                <tr data-room='{{ $room->id }}'>
                    <td class="roomsName">{{ $room->room_name }}</td>
                    <td class="roomtype">{{ $room->roomtype->title }}</td>
                    <td>
                        <button onclick="showModalRoom('{{ $room->id }}')" class="btn btn-info"><i class="fa-solid fa-eye"></i></button>

                        <button onclick="editModalRoom('{{ $room->id }}')" class="btn btn-success edit-btn"><i class="fa-solid fa-edit"></i></button>

                        <button onclick="deleteModalRoom('{{ $room->id }}')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-end">
    {{ $rooms->links() }}
</div>

<script src=" {{ asset('js/createRoom.js') }}"></script>

@endsection