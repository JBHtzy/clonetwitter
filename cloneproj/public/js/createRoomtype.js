function createRoom() {
    Swal.fire({
        title: "Submit your info",
        html: `
            <form id="myForm" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" class="swal2-input"><br><br>

            <label for="detail">Detail:</label><br>
            <input type="text" id="detail" name="detail" class="swal2-input"><br>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Submit",
        preConfirm: () => {
            const title = $("#title").val();
            const detail = $("#detail").val();

            if (!title || !detail) {
                Swal.showValidationMessage("Please fill in all fields");
            }

            return {
                title: title,
                detail: detail,
            };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = result.value; // Access form data here

            axios
                .post("/admin/roomtype/store", formData)
                .then(function (response) {
                    // console.log(response);
                    Swal.fire({
                        title: "Form Submitted",
                        text: response.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    let newRow = `<tr>
                        <td>${response.data[0].title}</td>
                        <td>${response.data[0].detail}</td>
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

// Show data details
function showModal(id) {
    Swal.fire({
        title: "Submit your info",
        html: `
            <label for="titles">Title:</label><br>
            <input type="text" id="titles" name="title" class="swal2-input" readonly><br><br>

            <label for="details">Detail:</label><br>
            <input type="text" id="details" name="detail" class="swal2-input" readonly><br>
        `,
        showConfirmButton: false,
        didOpen: () => {
            axios
                .get("/admin/roomtype/" + id)
                .then(function (response) {
                    // handle success
                    // console.log(response);
                    $("#titles").val(response.data[0].title);
                    $("#details").val(response.data[0].detail);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
    });
}

function editModal(id) {
    Swal.fire({
        title: "Edit your info",
        html: `
        <form id="myForm" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="titles">Title:</label><br>
            <input type="text" id="titles" name="title" class="swal2-input"><br><br>

            <label for="details">Detail:</label><br>
            <input type="text" id="details" name="detail" class="swal2-input"><br>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Submit",
        didOpen: () => {
            axios
                .get("/admin/roomtype/" + id)
                .then(function (response) {
                    // handle success
                    // console.log(response);
                    $("#titles").val(response.data[0].title);
                    $("#details").val(response.data[0].detail);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        preConfirm: () => {
            const title = $("#titles").val();
            const details = $("#details").val();

            if (!title || !details) {
                Swal.showValidationMessage("Please fill in all fields");
            }

            return {
                title: title,
                detail: details,
            };
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = result.value; // Access form data here
            // console.log(formData);

            axios
                .put("/admin/roomtype/" + id + "/edit", formData)
                .then(function (response) {
                    console.log("Response data:", response.data[0]);
                    // console.log(response);
                    Swal.fire({
                        title: "Update Success",
                        text: response.message,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    const mappedIndex = id - 1;
                    let updatedRow = document.querySelector(
                        `#datatablesSimple tbody tr[data-index='${mappedIndex}']`
                    );
                    if (updatedRow) {
                        updatedRow.innerHTML = `
                            <td >${response.data[0].title}</td>
                            <td >${response.data[0].detail}</td>
                            ${updatedRow.innerHTML
                                .split("</td>")
                                .slice(2)
                                .join("</td>")}
                        `;
                    }
                })
                .catch(function (error) {
                    // console.log(error);
                    console.log(error);
                });
        }
    });
}

function deleteModal(id) {
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
            axios
                .delete("/admin/roomtype/delete=" + id)
                .then(function (response) {
                    console.log(response);

                    const mappedIndex = id - 1;
                    const rowToDelete = document.querySelector(
                        `#datatablesSimple tbody tr[data-index='${mappedIndex}']`
                    );

                    if (rowToDelete) {
                        // console.log("Row to delete found");
                        console.log("Row to delete found:", rowToDelete);
                        // rowToDelete.parentNode.removeChild(rowToDelete); // Try this alternative approach
                        rowToDelete.remove();

                        Swal.fire({
                            title: "Deleted!",
                            text: "Data has been deleted.",
                            icon: "success",
                        });
                        console.log("Row deleted successfully");
                    } else {
                        console.log("Row to delete not found");
                    }
                })
                .catch(function (error) {
                    console.error("Error during deletion:", error);
                });
        }
    });
}
