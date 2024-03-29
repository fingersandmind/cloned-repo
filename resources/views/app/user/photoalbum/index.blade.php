@extends('app.admin.layouts.default')

{{-- Web site Title --}}
@section('title') {{{ trans("photoalbum.photoalbum") }}} ::
@parent @stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {{{ trans("photoalbum.photoalbum") }}}
            <div class="pull-right">
                <div class="pull-right">
                    <a href="{{{ URL::to('admin/photoalbum/create') }}}"
                       class="btn btn-sm  btn-primary iframe"><span
                                class="glyphicon glyphicon-plus-sign"></span> {{{
					trans("modal.new") }}}</a>
                </div>
            </div>
        </h3>
    </div>

    <table id="table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{{{ trans("modal.title") }}}</th>
            <th>{{{ trans("admin.language") }}}</th>
            <th>{{{ trans("photoalbum.numbers_of_items") }}}</th>
            <th>{{{ trans("admin.created_at") }}}</th>
            <th>{{{ trans("admin.action") }}}</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript">
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",

                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL::to('admin/photoalbum/data/') }}",
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        width: "80%",
                        height: "80%",
                        onClosed: function () {
                            oTable.ajax.reload();
                        }
                    });
                }
            });
            var startPosition;
            var endPosition;
            $("#table tbody").sortable({
                cursor: "move",
                start: function (event, ui) {
                    startPosition = ui.item.prevAll().length + 1;
                },
                update: function (event, ui) {
                    endPosition = ui.item.prevAll().length + 1;
                    var navigationList = "";
                    $('#table #row').each(function (i) {
                        navigationList = navigationList + ',' + $(this).val();
                    });
                    $.getJSON("{{ URL::to('admin/photoalbum/reorder') }}", {
                        list: navigationList
                    }, function (data) {
                    });
                }
            });
        });
    </script>
@stop
