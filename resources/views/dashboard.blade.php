@extends('layout.app')

@section('title', 'Dashboard')
@section('heading', 'Sites Available')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="row">
        <div class="col-12 col-md-12 col-xs-12 col-lg-12">
            <div class="text-end my-4">
                <button class="btn btn-primary text-end" onclick="openModal(this)"
                    style="color: white; background: linear-gradient(315deg, #e91e63, #5d02ff); border: none;"
                    data-type="new">Add Site</button>
            </div>
            <table class="table table-responsive" id="sitesTable">
                <thead class="table-info">
                    <tr>
                        <th>#</th>
                        <th>Site Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="siteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="siteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('layout.notifications')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="siteModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true" style="color: white;">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="siteForm" class="siteForm">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id" id="id">
                                <div class="col-12 col-md-12 col-lg-12 col-xs-12 mt-2">
                                    <label for="url" style="color: #fff;">Site URL</label>
                                    <input type="website" name="url" id="url" placeholder="Site URL"
                                        class="form-control" required>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 col-xs-12 mt-2">
                                    <label for="frequency" style="color: #fff;">Task Frequency</label>
                                    <input type="text" name="frequency" id="frequency" placeholder="Task Frequency"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="siteModalClose">Close</button>
                    <button type="button" class="btn btn-primary"
                        style="background: linear-gradient(315deg, #e91e63, #5d02ff); border:none;" id="siteModalButton"
                        data-type onclick="handleClick(this);"></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        var type = "new";
        var table;
        const modal = $('#siteModal');
        $(document).ready(function() {
            modal.on('hide.bs.modal', function() {
                modal.find('form#siteForm')[0].reset()
            });
            table = $('#sitesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('site-monitor.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        able: false
                    },
                ]
            });
        })

        function openModal(key) {
            const data = $(key).data();
            const type = data.type;
            switch (type) {
                case "new":
                    modal.find('#siteModalLabel').text('Add New Site');
                    modal.find('#siteModalButton').text('Submit').attr({
                        'data-type': type
                    });
                    modal.modal('show');
                    modal.find('#id').attr("name", null);
                    break;
                default:
                    modal.find('#siteModalLabel').text(`Edit Site`);
                    modal.find('#url').val(data.url);
                    modal.find('#frequency').val(data.frequency);
                    modal.find('#siteModalButton').text('Update').attr({
                        'data-type': type
                    });
                    modal.find('#id').attr("name", "id");
                    modal.find('#id').val(data.id)
                    modal.modal('show');
                    break;
            }
        }

        function handleClick(key) {
            const data = $(key).data();
            type = data.type ?? "new";
            modal.find('#siteForm').submit();
        }

        $('#siteForm').submit(function(event) {
            event.preventDefault();
            var params = {};
            if (validate()) {
                switch (type) {
                    case "new":
                        params = {
                            method: "POST",
                            url: "{{ route('site-monitor.store') }}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                url: modal.find('#url').val(),
                                frequency: modal.find('#frequency').val(),
                            },
                            headers: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }
                        }
                        break;
                    default:
                        var url = "{{ route('site-monitor.update', '--PARAM--') }}";
                        url = url.replace('--PARAM--', modal.find('#id').val());
                        params = {
                            method: "PUT",
                            url: url,
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                url: modal.find('#url').val(),
                                frequency: modal.find('#frequency').val(),
                            },
                            headers: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }
                        }
                        break;
                }
                $.ajax({
                    ...params,
                    success: function(data) {
                        modal.find('#siteModalClose').click();
                        table.ajax.reload();
                    },
                    error: function(jqXhr) {
                        var alertDiv = modal.find('.alert')
                        alertDiv.find('#content').text(jqXhr?.responseJSON?.error ??
                            'error occured, please try again');
                        alertDiv.show();
                    }
                });
            }
        });

        function validate() {
            return true;
            $('.error').removeClass('error');
            var urlPattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\/\S*)?$/;
            if (!$('#url').val() || !$('#url').val().test(urlPattern)) {
                $('#url').addClass('error');
                $('#url').prev('label').addClass('error');
                return false;
            }
            if (!$('#frequency').val()) {
                $('#frequency').addClass('error');
                $('#frequency').prev('label').addClass('error');
                return false;
            }
        }
    </script>
@endsection
