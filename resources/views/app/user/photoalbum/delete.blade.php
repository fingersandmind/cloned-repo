@extends('app.admin.layouts.modal') @section('content')
<form id="deleteForm" class="form-horizontal" method="post"
	action="@if (isset($photoalbum)){{ URL::to('admin/photoalbum/' . $photoalbum->id . '/delete') }}@endif"
	autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input
		type="hidden" name="id" value="{{ $photoalbum->id }}" />
	<div class="form-group">
		<div class="controls">
			<p>{{ trans("modal.delete_message") }}</p>
			<element class="btn btn-warning btn-sm close_popup">
			<span class="glyphicon glyphicon-ban-circle"></span> {{
			trans("modal.cancel") }}</element>
			<button type="submit" class="btn btn-sm btn-danger">
				<span class="glyphicon glyphicon-trash"></span> {{
				trans("modal.delete") }}
			</button>
		</div>
	</div>
</form>
@stop
