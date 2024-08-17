@extends('layouts.admin')
@section('maincontents')

<h1 class="mt-4">Room Type</h1>
<div class="d-flex justify-content-end">
    <div class="btn btn-success" onclick="createRoom()"><i class="fa-solid fa-plus"></i> Add Room</div>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Detail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $rtype)
                <tr data-index='{{ $rtype->id }}'>
                    <td>{{ $rtype->title }}</td>
                    <td>{{ $rtype->detail }}</td>
                    <td>
                        <button onclick="showModal({{ $rtype->id }})" class="btn btn-info"><i class="fa-solid fa-eye"></i></button>

                        <button onclick="editModal({{ $rtype->id }})" class="btn btn-success"><i class="fa-solid fa-edit"></i></button>

                        <button onclick="deleteModal({{ $rtype->id }})" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection