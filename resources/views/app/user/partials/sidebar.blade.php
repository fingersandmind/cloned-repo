@if(Auth::check())
<!-- User menu -->

	<!-- Main sidebar -->
			<div class="sidebar sidebar-main ">
				<div class="sidebar-content">


					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left">

                 {{ Html::image(route('imagecache', ['template' => 'profile', 'filename' => $image]), 'User', array('class' => 'img-circle img-sm')) }}

               

                </a>
								<div class="media-body">
									<span class="media-heading text-semibold">  {{ Auth::user()->name }}</span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> {{$GLOBAL_PACAKGE}}
									</div>
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="#"><i class="icon-cog3"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
                  
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>								
								<li class="{{set_active('user/dashboard')}}">
                        <a href="{{url('user/dashboard')}}">                           
                            <i class="icon-home4"></i>
                            <span class="text" >{{trans('menu.dashboard')}}</span>
                        </a>
                       
                    </li>
                    <li class="navigation-header"><span>Users</span> <i class="icon-menu" title="Users"></i></li>
                    <li class="has-sub {{set_active('user/genealogy')}}{{set_active('user/sponsortree')}}{{set_active('user/activate')}}">
                        <a href="javascript:;">                           
                            <span class="badge pull-right"></span>
                            <i class="icon-tree7"></i> 
                            <span>{{trans('menu.genealogy')}}</span>
                        </a>
                         <ul class="sub-menu">

                            


                           
                            <li class="{{set_active('user/sponsortree')}}"><a href="{{url('user/sponsortree')}}">{{trans('menu.sponsor-genealogy')}}</a></li>
                            <li class="{{set_active('user/tree')}}"><a href="{{url('user/tree')}}">{{trans('menu.tree-genealogy')}}</a></li>
                            <li class="{{set_active('user/activate')}}"><a href="{{url('user/activate')}}">Approve users</a></li>
                           
                        </ul>
                    </li>
                    
                    <li class="{{set_active('user/incomereport')}}">
                        <a href="{{url('user/incomereport')}}">
                            <i class="fa fa-sticky-note"></i>
                            <span class="text"> {{trans('menu.income_report')}} </span>
                        </a>
                    </li>

                  

                       <li class="has-sub  {{set_active('user/ewallet')}}  {{set_active('user/creditfund')}} ">
                        <a href="javascript:;">
                            
                            <span class="badge pull-right"></span>
                            <i class="fa fa-credit-card"></i> 
                            <span>{{ trans('menu.my_ewallet')}} </span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{set_active('user/ewallet')}}"><a href="{{url('user/ewallet')}}">  {{ trans('menu.my_ewallet')}}  </a></li>
                            <!-- <li class="{{set_active('user/creditfund')}}"><a href="{{url('user/creditfund')}}">  {{ trans('menu.credit_ewallet')}}  </a></li> -->
                        </ul>
                    </li>
 
 
 



                    <li class="has-sub {{set_active('user/fund-transfer')}}{{set_active('user/my-transfer')}}">
                        <a href="javascript:;">
                            
                            <span class="badge pull-right"></span>
                            <i class="fa fa-credit-card"></i> 
                            <span>{{ trans('menu.fund_transfer')}}</span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{set_active('user/fund-transfer')}}"><a href="{{url('user/fund-transfer')}}">{{ trans('menu.fund_transfer')}}</a></li>
                            <li class="{{set_active('user/my-transfer')}}"><a href="{{url('user/my-transfer')}}">{{ trans('menu.my_transfer')}}</a></li>
                           
                        </ul>
                    </li>



                
                      <li class="has-sub {{set_active('user/productparchase')}}  ">
                        <a href="javascript:;">
                            
                            <span class="badge pull-right"></span>
                            <i class="fa fa-ticket"></i> 
                            <span> Product purchase</span>
                        </a>
                        <ul class="sub-menu">
                         <li class="{{set_active('user/productparchase')}}"><a href="{{url('user/productparchase')}}">Product purchase</a></li> 
                            <li class="{{set_active('user/product/producthistory')}}"><a href="{{url('user/product/producthistory')}}">{{ trans('menu.purchase_history')}}</a></li>
                            <li class="{{set_active('user/product/approverequest')}}"><a href="{{url('user/product/approverequest')}}">Approve purchase</a></li>
                            <li class="{{set_active('user/product/saleshistory')}}"><a href="{{url('user/product/saleshistory')}}">Sales history</a></li>
                           
                           
                        </ul>

                    </li>


                   


                     <li class="{{set_active('user/profile')}}">
                        <a href="{{url('user/profile')}}">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="text"> {{trans('menu.profile')}}</span>
                        </a>
                    </li>  
                     

                       <li class="{{set_active('user/compose')}}">
                        <a href="{{url('user/compose')}}">
                            <i class="fa fa-envelope"></i>
                            <span class="text"> {{ trans('menu.email')}}</span>
                        </a>
                    </li> 

                     <li class="{{set_active('user/helpdesk/tickets-dashboard')}}">
                        <a href="{{url('user/helpdesk/tickets-dashboard')}}">
                            <i class="fa fa-envelope"></i>
                            <span class="text"> {{trans('menu.ticket_center')}}</span>
                        </a>
                    </li> 
                    
                   
                   
                    <li class="has-sub  {{set_active('user/payoutrequest')}} {{set_active('user/allpayoutrequest')}}">
                        <a href="javascript:;">
                            
                            <i class="fa fa-money"></i>
                            <span class="text">{{trans('menu.payout')}} </span>
                        </a>
                        <ul class="sub-menu">
                            <li class="{{set_active('user/payoutrequest')}}" ><a href="{{url('user/payoutrequest')}}">{{trans('menu.request_payout')}}</a></li>
                            <li class="{{set_active('user/allpayoutrequest')}}"><a href="{{url('user/allpayoutrequest')}}">{{trans('menu.view_my_payout')}}</a></li>
                        </ul>
                    </li>
                    <li class="has-sub {{set_active('user/documentdownload')}}">
                        <a  href="javascript:;" >
                            
                            <i class="fa fa-wrench"></i>
                            <span class="text">{{ trans('menu.Tools')}}</span>
                        </a>
                        <ul class="sub-menu">
                            
                              <li class="{{set_active('user/documentdownload')}}"><a href="{{url('user/documentdownload')}}">{{ trans('menu.download')}}</a></li>
                            
                            
                      
                        </ul>
                        
                    </li> 
                    
                    


                     <li><a href="{{ url('/logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> Logout</a></li>
                    
								</ul>
						</div>
					</div>
					<!-- /main navigation -->
				</div>
			</div>
			<!-- /main sidebar -->

       
@endif


