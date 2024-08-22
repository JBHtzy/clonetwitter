@extends('layouts.admin')
@section('maincontents')

<h1 class="mt-4">Customer</h1>
<div class="d-flex justify-content-end">
    <div class="btn btn-success" onclick="createCustomer()"><i class="fa-solid fa-plus"></i> Add Customer</div>
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
                <tr data-room=''>
                    <td class="roomsName">test data</td>
                    <td class="roomtype">test data</td>
                    <td>
                        <button onclick="showCustomer('')" class="btn btn-info"><i class="fa-solid fa-eye"></i></button>

                        <button onclick="editCustomer('')" class="btn btn-success edit-btn"><i class="fa-solid fa-edit"></i></button>

                        <button onclick="deleteCustomer('')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection