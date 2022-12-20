<?php

$this->registerJs(<<< JS
    $('body').append(`
        <div class="modal fade" id="modal-edit-document" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-edit-document">Rename Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                </div>
            </div>
        </div>

    `);

    $(document).on('click', '.btn-remove-file', function() {
        var self = this;
        Swal.fire({
            title: "Are you sure?",
            text: "You won\"t be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {

                KTApp.block('body', {
                    overlayColor: '#000000',
                    state: 'warning',
                    message: 'Please wait...'
                });
                $.ajax({
                    url: $(self).data('delete-url'),
                    method: 'post',
                    dataType: 'json',
                    success: function(s) {
                        if(s.status == 'success') {
                            $('#table-file').DataTable({
                                destroy: true,
                                pageLength: 3,
                                order: [[0, 'desc']]
                            }).row($(self).closest('tr')).remove().draw();
                            $(document).find('.file-hidden-input-' + $(self).data('token')).remove();
                            Swal.fire({
                                icon: "success",
                                title: "Deleted",
                                text: "Your file has been deleted.",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        else {
                            Swal.fire('Error', s.errors, 'error');
                        }
                        KTApp.unblock('body');
                    },
                    error: function(e) {
                        Swal.fire('Error', e.responseText, 'error');
                        KTApp.unblock('body');
                    },
                })
            }
        });
    });

    $(document).on('click', '.btn-edit-file', function() {
        let file = $(this),
            modal = $(document).find('#modal-edit-document'),
            modalBody = modal.find('.modal-body');

        KTApp.block('.files-container', {
            state: 'warning', // a bootstrap color
            message: 'Please wait...',
        });

        $.ajax({
            url: app.baseUrl + 'file/view',
            method: 'get',
            data: {
                token: file.data('token'),
                template: '_form-ajax',
            },
            dataType: 'json',
            success: function(s) {
                if(s.status == 'success') {
                    modalBody.html(s.form);
                    modal.modal('show');
                }
                else {
                    Swal.fire('Error', s.error, 'error');
                }
                KTApp.unblock('.files-container');
            },
            error: function(e) {
                Swal.fire('Error', e.responseText, 'error');
                KTApp.unblock('.files-container');
            }
        });
    }); 
JS);
?>

<div class="btn-group" role="group" aria-label="Basic example">
    <a href="<?= $model->downloadUrl ?>" class="btn btn-light-info btn-sm btn-icon btn-view-file">
        <i class="fa fa-download"></i>
    </a>
    <a href="<?= $model->viewerUrl ?>" target="_blank" class="btn btn-light-primary btn-sm btn-icon btn-view-file">
        <i class="fa fa-eye"></i>
    </a>
    <button data-token="<?= $model->token ?>" data-name="<?= $model->name ?>" type="button" class="btn btn-light-warning btn-sm btn-icon btn-edit-file">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data-token="<?= $model->token ?>" class="btn btn-light-danger btn-sm btn-icon btn-remove-file" data-delete-url="<?= $model->deleteUrl ?>">
        <i class="fa fa-trash"></i>
    </button>
</div>


