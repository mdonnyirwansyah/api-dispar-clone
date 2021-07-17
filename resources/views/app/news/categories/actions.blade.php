<script>
    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            $("#"+key).addClass("is-invalid");
            $("."+key+"_err").text(value);
        });
    }

    function createRecord() {
        $.get("/news/categories/create", function (response) {
            $('#view-modal').html(response.success).show();
            $("#modal-title").html("Create New Category");
            $("#form-btn").html("Submit");
            $("#modal-form").modal('show'); 

            $("#form-action").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "/news/categories",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.success){
                            $("#newscategory-table").DataTable().draw();
                            $("#modal-form").modal('hide');
                            toastr.success(response.success, 'Congratulations,');
                        }else{
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });     
        });

        
    }

    function editRecord(id) {
        $.get("/news/categories/edit/" + id, function (response) {
            $('#view-modal').html(response.success).show();
            $("#id").val(response.data.id);
            $("#name").val(response.data.name);
            $("#modal-title").html("Edit Category");
            $("#form-btn").html("Save Changes");
            $("#modal-form").modal('show');

            $("#form-action").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "/news/categories/" + id,
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.success){
                            $("#newscategory-table").DataTable().draw();
                            $("#modal-form").modal('hide');
                            toastr.success(response.success, 'Congratulations,');
                        }else{
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });
        });
    }

    function deleteRecord(id) {
        swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "/news/categories/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $("#newscategory-table").DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal("Your record is safe!");
            }
        });
    }
</script>