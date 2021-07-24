<script>
    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            $('#'+key).addClass('is-invalid');
            $('.'+key+'_err').text(value);
        });
    }

    function createRecord() {
        $.get('{{ route("news.tags.create") }}', function (response) {
            $('#view-modal').html(response.success).show();
            $('#modal-form').modal('show');

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
                            $('#newstag-table').DataTable().draw();
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

    function editRecord(id) {
        let route = $('#edit-'+id).attr('edit-route');
        $.get(route, function (response) {
            $('#view-modal').html(response.success).show();
            $('#modal-form').modal('show');

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
                            $('#newstag-table').DataTable().draw();
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
                        $('#newstag-table').DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal('Your record is safe!');
            }
        });
    }
</script>
