function createRoomsModal() {
    Swal.fire({
        title: "Add Rooms",
        html: `
            <form id="myForm" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="selectRooms">Room Category:</label><br>
                    <select class="form-control" name="roomId" id="selectRooms">
                    </select>
                <br><br>

                <label for="room">Room Name:</label><br>
                <input type="text" id="room" name="room" class="form-control"><br>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Submit",
        didOpen: () => {
            axios
                .get("/admin/room/create")
                .then(function (response) {
                    // handle success
                    $("#selectRooms").append(
                        '<option value="">Select a category</option>'
                    );

                    // console.log("datas", response.data.datas);
                    $.each(response.data.datas, function (index, category) {
                        $("#selectRooms").append(
                            $("<option></option>")
                                .attr("value", category.id) // Set the value attribute
                                .text(category.title + " " + category.detail) // Set the text of the option
                        );
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        preConfirm: () => {
            const roomId = $("#selectRooms").val();
            const room = $("#room").val();

            if (!roomId || !room) {
                Swal.showValidationMessage("Please fill in all fields");
            }

            return {
                roomtypeId: roomId,
                roomname: room,
            };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const roomData = result.value;
            // console.log("Sent data", roomData);

            axios
                .post("/admin/room", roomData)
                .then(function (response) {
                    // console.log(response);
                    Swal.fire({
                        title: "Form Submitted",
                        text: response.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });

                    let newRow = `<tr data-room="${response.data[0].id}">
                            <td class="roomsName">${response.data[0].room_name}</td>
                            <td class="roomtype">${response.data[0].roomtype.title}</td>
                            <td>
                                <button onclick="showModalRoom(${response.data[0].id})" class="btn btn-info"><i class="fa-solid fa-eye"></i></button>

                                <button onclick="editModalRoom(${response.data[0].id})" class="btn btn-success edit-btn"><i class="fa-solid fa-edit"></i></button>

                                <button onclick="deleteModalRoom(${response.data[0].id})" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>`;

                    $("#datatablesSimple").append(newRow);
                })
                .catch(function (error) {
                    // console.log(error);
                    console.log(error.response.data);
                });
        }
    });
}

function showModalRoom(id) {
    Swal.fire({
        title: "Show Room",
        html: `
            <form id="myForm" >
            <label for="room">Room Name: <span id="titleRoom"></span></label><br>

            <label for="titles">Title:</label><br>
            <input type="text" id="titles" name="title" class="swal2-input"><br><br>

            <label for="details">Detail:</label><br>
            <input type="text" id="details" name="detail" class="swal2-input"><br><br>
            </form>
        `,
        showConfirmButton: false,
        didOpen: () => {
            axios
                .get("/admin/room/" + id)
                .then(function (response) {
                    const res = response.data.data.roomtype;
                    // console.log(response);
                    $("#titleRoom").text(response.data.data.room_name);
                    $("#titles").val(res.title);
                    $("#details").val(res.detail);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
    });
}

function editModalRoom(id) {
    Swal.fire({
        title: "Edit Room",
        html: `
            <form id="myForm" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="roomtypeId" id="roomtypeId" >

                <label for="titles">Title:</label><br>
                <input type="text" id="rtitles" name="title" class="swal2-input"><br><br>

                <label for="details">Detail:</label><br>
                <input type="text" id="rdetails" name="detail" class="swal2-input"><br><br>

                <label for="room">Room Name:</label><br>
                <input type="text" id="room" name="room" class="swal2-input"><br>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Submit",
        didOpen: () => {
            axios
                .get("/admin/room/" + id)
                .then(function (response) {
                    // console.log(response);
                    const x = response.data.data;
                    const y = response.data.data.roomtype;

                    $("#rtitles").val(y.title);
                    $("#rdetails").val(y.detail);
                    $("#roomtypeId").val(x.roomtype_id);
                    $("#room").val(x.room_name);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        preConfirm: () => {
            const roomtypeId = $("#roomtypeId").val();
            const title = $("#rtitles").val();
            const detail = $("#rdetails").val();
            const roomName = $("#room").val();

            return {
                roomtypeId: roomtypeId,
                title: title,
                detail: detail,
                roomname: roomName,
            };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = result.value;
            // console.log(formData);

            axios
                .put(`/admin/room/${id}`, formData)
                .then(function (response) {
                    // console.log(response);
                    let res = response.data.datas.roomtype;

                    Swal.fire({
                        title: "Update Success",
                        text: response.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });

                    let updatedRow = $(
                        `#datatablesSimple tbody tr[data-room='${id}']`
                    );
                    // console.log(id);

                    if (updatedRow.length > 0) {
                        let roomsName = updatedRow.find("td.roomsName");
                        let roomtype = updatedRow.find("td.roomtype");

                        if (roomsName.length > 0) {
                            roomsName.text(response.data.datas.room_name);
                        }
                        if (roomtype.length > 0) {
                            roomtype.text(res.title);
                        }
                    } else {
                        console.error("room not found", updatedRow);
                    }
                })
                .catch(function (error) {
                    // console.log(error);
                    console.log(error);
                });
        }
    });
}

function deleteModalRoom(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/admin/room/${id}`).then(function (response) {
                // console.log(response);
                const rowToDelete = document.querySelector(
                    `#datatablesSimple tbody tr[data-room='${id}']`
                );

                if (rowToDelete) {
                    rowToDelete.remove();

                    Swal.fire({
                        title: response.data.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    // console.log("Row deleted successfully");
                } else {
                    console.log("Row to delete not found");
                }
            });
        }
    });
}
