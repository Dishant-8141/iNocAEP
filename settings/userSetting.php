<?php
  include '../layouts/sidebar.php';
?>
<style>
    .error {
        color: red;
        font-weight: 400;
        display: block;
        padding: 6px 0;
        font-size: 14px;
    }
    .form-control.error {
        border-color: red;
        padding: .375rem .75rem;
    } 
</style>
  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Adobe I/O Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Adobe I/O Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row mb-2">
                <div class="col-sm-10">
                </div><!-- /.col -->
                <div class="col-sm-2">
                    <button class="btn btn-primary createProject" type="button">Create Project</button>   
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row" id="showProject">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box" style="height: 150px;">
                        <div class="info-box-content" style="align-items: center">
                            <span class="info-box-text">Create New</span>
                            <span class="info-box-icon bg-info createProject" style="height: 50px; margin-top: 10px; cursor: pointer"><i class="fa fa-plus"></i></span>
                        </div>
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box" style="height: 150px;">
                        <div class="info-box-content" style="align-items: center;">
                            <span class="info-box-text">Project Name:- <u>Project A</u></span>
                            <span class="info-box-text mt-1"> Activate:- <input type="checkbox" class="activeSwitch" name="my-checkbox" checked data-bootstrap-switch></span>
                            <button class="btn btn-link viewBtn" type="button">View More</button>
                        </div>
                    </div>
                </div> -->
            </div>
            
            <!-- ===============Create project modal==================== -->
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-lg">
                    <form class="form-horizontal" role="form" id="createProjectForm" action="#" method="POST">
                        <div class="modal-content">
                            <div class="overlay modal-loader">
                                <i class="fas fa-2x fa-sync fa-spin"></i>
                            </div>
                            <div class="modal-header">
                                <h4 class="modal-title">Create Project</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Project Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter project name">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Client Id (API Key):</label>
                                            <input type="text" class="form-control" id="c_id" name="c_id" placeholder="Enter client id">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Client Secret:</label>
                                            <input type="text" class="form-control" id="c_secret" name="c_secret" placeholder="Enter client secret">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Org ID:</label>
                                            <input type="text" class="form-control" id="org_id" name="org_id" placeholder="Enter org id">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="exampleInputEmail1">JWT Token:</label>
                                            <input type="text" class="form-control" id="jwt" name="jwt" placeholder="Enter JWT token">
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active">
                                                <label class="custom-control-label" for="is_active">Make it default</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- =================View project modal======================= -->
            <div class="modal fade" id="view-project-modal">
                <div class="modal-dialog modal-lg">
                    <form class="form-horizontal" role="form" id="viewProjectForm" action="#" method="POST">
                        <div class="modal-content">
                            <div class="overlay modal-loader">
                                <i class="fas fa-2x fa-sync fa-spin"></i>
                            </div>
                            <div class="modal-header">
                                <h4 class="modal-title" id="view-name"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Project Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter project name">
                                        </div> -->
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Client Id (API Key):</label>
                                            <input type="text" class="form-control" id="view_c_id" name="view_c_id" placeholder="Enter client id" disabled>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Client Secret:</label>
                                            <input type="text" class="form-control" id="view_c_secret" name="view_c_secret" placeholder="Enter client secret" disabled>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputEmail1">Org ID:</label>
                                            <input type="text" class="form-control" id="view_org_id" name="view_org_id" placeholder="Enter org id" disabled>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="exampleInputEmail1">JWT Token:</label>
                                            <input type="text" class="form-control" id="view_jwt" name="view_jwt" placeholder="Enter JWT token" disabled>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="view_is_active" name="view_is_active" disabled>
                                                <label class="custom-control-label" for="view_is_active">Make it default</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </section>
</div>

        
    <!-- /#page-wrapper -->
<?php
    include '../layouts/footer.php';
?>

<script type="text/javascript">
    $(document).ready(function() {
        var url = window.location.href;
        url = url.slice(0, url.lastIndexOf('/'));
        url = url.slice(0, url.lastIndexOf('/'));

        $('.modal-loader').hide();
            
        $('.createProject').on('click', function(){
            $('#modal-default').modal('show');
            $('#name').val('');
            $('#c_id').val('');
            $('#c_secret').val('');
            $('#org_id').val('');
            $('#jwt').val('');
            $('#is_active').prop('checked', false);
        });

        $('#createProjectForm').validate({
            rules: {
                name: {
                    required: true
                },
                c_id: {
                    required: true
                },
                c_secret: {
                    required: true
                },
                org_id: {
                    required: true
                },
                jwt: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Project name is required."
                },
                c_id: {
                    required: "Client id is required."
                },
                c_secret: {
                    required: "Client secret is required.",
                },
                org_id: {
                    required: "Org id is required.",
                },
                jwt: {
                    required: "Jwt token is required.",
                }
            },
            submitHandler: function (form) {
                var data = {
                    name: $('#name').val(),
                    c_id: $('#c_id').val(),
                    c_secret: $('#c_secret').val(),
                    org_id: $('#org_id').val(),
                    jwt_token: $('#jwt').val(),
                    is_active: ($('#is_active').is(":checked") == true) ? 1 : 0
                };

                $('.modal-loader').show();

                $.ajax({
                    url: url+'/backend/AjaxAPI.php?type=create_project',
                    type: "POST",
                    headers: {
                        "accept": "application/json",
                        "Access-Control-Allow-Origin": "*"
                    },
                    data: data,
                    success: function (response) {
                        $('.modal-loader').hide();
                        var res = JSON.parse(response);
                        if(res.status == true){
                            toastr.success(res.message);
                            $('#modal-default').modal('hide');
                            getProjectList();
                        }else{
                            toastr.error(res.message)
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('.modal-loader').hide();
                        toastr.error('Something went wrong on server side');
                    }

                })
            }
        });

        function getProjectList() {
            $.ajax({
                url: url+'/backend/AjaxAPI.php?type=get_project',
                type: "GET",
                headers: {
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status == true) {
                        // console.log(res.data)
                        if(res.data.length > 0){
                            $('.getProject').remove();
                            var data = res.data;
                            var html = '';
                            for (let index = 0; index < data.length; index++) {
                                html += '<div class="col-md-3 col-sm-6 col-12 getProject">';
                                html += '<div class="info-box" style="height: 150px;">';
                                if(data[index]['is_active'] == 1){
                                    html += '<div class="ribbon-wrapper mb-1">';
                                    html += '<div class="ribbon bg-success">Activate</div></div>';
                                }
                                html += '<div class="info-box-content" style="align-items: center;">';
                                html += '<span class="info-box-text">Project Name:- <u>'+ data[index]['name'] +'</u></span>';
                                if (data[index]['is_active'] == 0) {
                                    html += '<button class="btn btn-block btn-outline-info btn-sm defaultButton mt-1" data-name="'+data[index]['name']+'" data-id="'+data[index]['id']+'" type="button"> Make it default </button>';
                                }
                                html += '<button class="btn btn-link viewBtn" type="button" data-id="'+data[index]['id']+'">View More</button>';
                                html += '</div></div></div>';
                            }
                            $('#showProject').append(html);
                        }
                    }else{
                        toastr.error(res.message)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error('Something went wrong on server side');
                }
            })
        }

        getProjectList();

        $('#showProject').on('click', '.viewBtn', function() {
            $.ajax({
                url: url+'/backend/AjaxAPI.php?type=retrive_project',
                type: "POST",
                headers: {
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                data: {
                    id: $(this).data('id')
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status == true) {
                        // console.log(res.data);return;
                        if(res.data.length > 0){
                            var data = res.data[0]
                            $('#view-project-modal').modal('show');
                            $('#view-name').text(data['name']);
                            $('#view_c_id').val(data['c_id']);
                            $('#view_c_secret').val(data['c_secret']);
                            $('#view_org_id').val(data['org_id']);
                            $('#view_jwt').val(data['jwt_token']);
                            (data['is_active'] == 1) ? $('#view_is_active').prop('checked', true) : $('#view_is_active').prop('checked', false);
                        }
                    }else{
                        toastr.error(res.message)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error('Something went wrong on server side');
                }
            })
        });
        
        // $("input[data-bootstrap-switch]").each(function(){
        //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
        // })
        
        // $('.activeSwitch').on('switchChange.bootstrapSwitch', function (event, state) {
        //     console.log(state);
        // });
        $('#showProject').on('click', '.defaultButton', function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var heading = "Do you want to make "+name+" default?"
            Swal.fire({
                title: heading,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    makeDefault(id);
                } else if (result.isDenied) {
                    toastr.info('Changes are not saved');
                }
            })
        });

        function makeDefault(id){
            $.ajax({
                url: url+'/backend/AjaxAPI.php?type=make_default',
                type: "POST",
                headers: {
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                data: {
                    id: id
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status == true){
                        toastr.success(res.message);
                        getProjectList();
                    }else{
                        toastr.error(res.message)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error('Something went wrong on server side');
                }
            })
        }

    });  
</script>
