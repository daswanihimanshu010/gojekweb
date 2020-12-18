@extends('common.admin.layout.base')

@section('title') {{ __('admin.dispute.service_title') }}@stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.css')}}">

@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('admin.dispute.service.title') }}</span>
            <h3 class="page-title">{{ __('admin.dispute.service.title') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('admin.dispute.service.title') }}</h6>
                    
                    <a href="javascript:;" class="btn btn-success pull-right add"><i class="fa fa-plus"></i> {{ __('admin.dispute.add_service_dispute') }}</a>
                    
                </div>

                <div class="col-md-12">
                    <div class="note_txt">
                        @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif
                        
                    </div>
                </div>

                <table id="data-table" class="table table-hover table_width display">
                <thead>
                    <tr>
                            <th>{{ __('admin.id') }}</th>                         
                            <th>{{ __('admin.dispute.dispute_request_id') }}</th>
                            <th>{{ __('admin.dispute.dispute_request') }}</th> 
                            <th>{{ __('admin.dispute.dispute_type') }}</th> 
                            <th>{{ __('admin.dispute.dispute_name') }}</th>                           
                            <th>{{ __('admin.dispute.dispute_comments') }}</th>                           
                            <th>{{ __('admin.dispute.dispute_refund') }}</th>                           
                            <th>{{ __('admin.status')   }}</th>
                            <th>{{ __('admin.action')  }}</th>
                    </tr>
                 </thead>


                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
@parent

<script src="{{ asset('assets/plugins/data-tables/js/buttons.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.js')}}"></script>

<script>
var tableName = '#data-table';
var table = $(tableName);
$(document).ready(function() {

    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/service-dispute/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/service-dispute/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });


    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [8]}],
        "ajax": {
            "url": getBaseUrl() +"/admin/service/requestdispute",
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            data: function(data){
                var info = $(tableName).DataTable().page.info();
                delete data.columns;
                data.page = info.page + 1;
                data.search_text = data.search['value'];
                data.order_by = $(tableName+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];                
            },
            dataFilter: function(data){

                var json = parseData( data );

                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
                json.data = json.responseData.data;
                hideLoader();
                return JSON.stringify( json ); // return JSON string
            }
        },

        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "request_id",render: function (data, type, row) {
               return row.request?row.request.booking_id:'';
              }
            },
            { "data": "dispute_type", render: function (data, type, row) {
                if(data =="user"){
                    return row.user?row.user.first_name+" "+row.user.last_name:'';
                }
                    return row.provider?row.provider.first_name+" "+row.provider.last_name:'';
               }
            },
            { "data": "dispute_type", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1);
               }
            },
            { "data": "dispute_name", render: function (data, type, row) {
                if(data){
                    return data.replace(/^(.)|\s(.)/g, function(dispute_name){ return dispute_name.toUpperCase( ); });
                }else{
                    return data;
                }
               }
            },
            { "data": "comments", render: function (data, type, row) {
                if(data){
                  return data.replace(/^(.)|\s(.)/g, function(comments){ return comments.toUpperCase( ); });
                }else{
                  return data;
                }
               }
            },
            { "data": "refund_amount" },
            { "data": "status", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1);
               }
            },
            { "data": "id", render: function (data, type, row) {
                if(row.status =="open" && "{{Helper::getDemomode()}}" != 1)
                return "<button data-id='"+data+"' class='btn btn-block btn-success edit'>Edit</button>";
               }
            }

        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            dom: 'Bfrtip',
            buttons: [{
               extend: "copy",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "csv",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "excel",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "pdf",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }],"drawCallback": function () {
    
                var info = $(this).DataTable().page.info();
                if (info.pages<=1) {
                   $('.dataTables_paginate').hide();
                   $('.dataTables_info').hide();
                }
            }
    } );

    $('body').on('click', '.delete', function() {
        var id = $(this).data('id');
        var url = getBaseUrl() +"/admin/service/requestdispute/"+id;
        deleteRow(id, url, table);
    });

} );
</script>
@stop
