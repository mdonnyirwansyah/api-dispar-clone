<script>
    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            $('#'+key).addClass('is-invalid');
            $('.'+key+'_err').text(value);
        });
    }

    function createRecord() {
        $.get('{{ route("users.create") }}', function (response) {
            $('#view-modal').html(response.success).show();
            $('#modal-form').modal('show'); 
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select roles',
            });

            $('#form-action').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.success){
                            $('#user-table').DataTable().draw();
                            $('#modal-form').modal('hide');
                            toastr.success(response.success, 'Congratulations,');
                        }else{
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        let errors = jQuery.parseJSON(xhr.responseText);
                        printErrorMsg(errors.errors);
                    }
                });
            });     
        });

        
    }

    function editRecord(id) {
        let route = $('#edit-'+id).attr('edit-route');
        $.get(route, function (response) {
            $('#view-modal').html(response.success).show();
            $('#modal-form').modal('show');
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select roles',
            });

            $('#form-action').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if(response.success){
                            $('#user-table').DataTable().draw();
                            $('#modal-form').modal('hide');
                            toastr.success(response.success, 'Congratulations,');
                        }else{
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError);
                    }
                });
            });
        });
    }

    function deleteRecord(id) {
        let route = $('#delete-'+id).attr('delete-route');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: route,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#user-table').DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal('Your record is safe!');
            }
        });
    }
</script>