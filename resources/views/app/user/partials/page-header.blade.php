<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">{{$title}}</span>  </h4>
		</div>
		<div class="heading-elements">
			<div class="heading-btn-group">

			</div>
				<div class='time-frame'>

				    <div class="time-parts" id='icon'><i class="icon-watch"></i>&nbsp;</div>
				    <div class="time-parts" id='year-part'></div>
				    <div class="time-parts" id='month-part'></div>
				    <div class="time-parts" id='date-part'></div>
				    <div class="time-parts" id='day-part'></div>
				    <div class="time-parts" id='time-part'></div>
				    <div class="time-parts" id='ampm-part'></div>
				</div>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{url('user/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">{{$method}}</li>
		</ul>
		<ul class="breadcrumb-elements">
			<li><a href="{{url('user/helpdesk/tickets-dashboard')}}"><i class="icon-comment-discussion position-left"></i> Support</a></li>
			<li class="dropdown">
				<a href="{{url('admin/settings')}}" class="dropdown-toggle" data-toggle="dropdown">
					<i class="icon-gear position-left"></i>
					Settings
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="{{url('admin/userprofile')}}"><i class="icon-user-lock"></i> View Profile</a></li>
					<li class="divider"></li>
					<li><a href="{{url('user/compose#/u/mail/inbox')}}"><i class="icon-gear"></i> All emails</a></li>
				</ul>
			</li>
		</ul>
	</div>
	

</div>