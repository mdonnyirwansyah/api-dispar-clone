<script>
    $(document).on('click', 'input[name="main_checkbox"]', function () {
        if (this.checked) {
            $('input[name="row_checkbox"]').each(function () {
                this.checked = true;
            })
        } else {
            $('input[name="row_checkbox"]').each(function () {
                this.checked = false;
            });
        }
        btnDeleteCheckbox();
    });

    $(document).on('change', 'input[name="row_checkbox"]', function () {
        if ($('input[name="row_checkbox"]').length == $('input[name="row_checkbox"]:checked').length) {
            $('input[name="main_checkbox"]').prop('checked', true);
        } else {
            $('input[name="main_checkbox"]').prop('checked', false);
        }
        btnDeleteCheckbox();
    });

    $(document).on('click', '#btn-delete-checkbox', function () {
        let rowChecked = [];

        $('input[name="row_checkbox"]:checked').each(function () {
            rowChecked.push($(this).data('id'));
        });

        let route = $(this).data('route');
        let total = rowChecked.length;

        swal({
            title: 'Are you sure?',
            text: 'You want to delete('+total+') record!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $('#btn-delete-checkbox').attr('disabled', true);
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        rowChecked
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('input[name="row_checkbox"]').each(function () {
                            this.checked = false;
                        });
                        $('input[name="main_checkbox"]').prop('checked', false);
                        $('#btn-delete-checkbox').hide();
                        $('#btn-delete-checkbox').attr('disabled', false);
                        $('#newspost-table').DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal('Your record is safe!');
            }
        });
    });

    $(document).on('change', 'select[name="newspost-table_length"]', function () {
        $('input[name="row_checkbox"]').each(function () {
            this.checked = false;
        });
        $('input[name="main_checkbox"]').prop('checked', false);
        $('#btn-delete-checkbox').hide();
    });

    $(document).on('click', '.page-link', function () {
        $('input[name="row_checkbox"]').each(function () {
            this.checked = false;
        });
        $('input[name="main_checkbox"]').prop('checked', false);
        $('#btn-delete-checkbox').hide();
    });

    $(document).on('click', 'input[type="search"]', function () {
        $('input[name="row_checkbox"]').each(function () {
            this.checked = false;
        });
        $('input[name="main_checkbox"]').prop('checked', false);
        $('#btn-delete-checkbox').hide();
    });

    function btnDeleteCheckbox() {
        let total = $('input[name="row_checkbox"]:checked').length;

        if (total > 0) {
            $('#btn-delete-checkbox').text("Delete("+total+")").show();
        } else {
            $('#btn-delete-checkbox').hide();
        }
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
                        $('#newspost-table').DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal('Your record is safe!');
            }
        });
    }
</script>
