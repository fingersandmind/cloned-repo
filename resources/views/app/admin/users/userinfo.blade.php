  <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-4">
                    <div class="content-group">
                                    <div class="panel-body bg-indigo-400 border-radius-top text-center" style="background-image: url(http://demo.interface.club/limitless/assets/images/bg.png); background-size: contain;">
                                        <div class="content-group-sm">
                                            <h6 class="text-semibold no-margin-bottom">
                                                  {{ $data->name }} {{ $data->lastname }}
                                            </h6>

                                            <span class="display-block">  {{ $data->username }} </span>
                                        </div>

                                        <a href="#" class="display-inline-block content-group-sm">
                                            <img src="{{ url('img/cache/profile',$data->profile_info->profile) }}" class="img-circle img-responsive" alt="" style="width: 110px; height: 110px;">
                                        </a>

                                        <ul class="list-inline list-inline-condensed no-margin-bottom">
                                            <li><a href="#" class="btn bg-indigo btn-rounded btn-icon"><i class="icon-google-drive"></i></a></li>
                                            <li><a href="#" class="btn bg-indigo btn-rounded btn-icon"><i class="icon-twitter"></i></a></li>
                                            <li><a href="#" class="btn bg-indigo btn-rounded btn-icon"><i class="icon-github"></i></a></li>
                                        </ul>
                                    </div>
                                   
                                </div>
                    
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-body no-border-top no-border-radius-top">
                                    <div class="form-group mt-5">
                                        <label class="text-semibold">Username:</label>
                                        <span class="pull-right-sm"> {{ $data->username }}</span>
                                    </div>
                                    <div class="form-group mt-5">
                                        <label class="text-semibold">Full name:</label>
                                        <span class="pull-right-sm">{{ $data->name }} {{ $data->lastname }}</span>
                                    </div>


                                      <div class="form-group mt-5">
                                        <label class="text-semibold">Gender:</label>
                                        <span class="pull-right-sm">{{ ($data->profile_info->gender == 'm') ? 'Male' : 'Female' }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-semibold">Phone number:</label>
                                        <span class="pull-right-sm">{{ $data->profile_info->mobile }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-semibold"> Email:</label>
                                        <span class="pull-right-sm"> {{ $data->email }}</span>
                                    </div>

                                     

                                     
                                </div>
                    
                </div>
                <div class="col-sm-4">
                     <div class="panel no-border-top no-border-radius-top">
                                        <ul class="navigation">
                                            <li class="navigation-header" style="color: #000;">Navigation</li>
                                            <li class="active"><a  target="blank" href="{{ url('admin/userprofiles',$data->username) }}"  ><i class="icon-files-empty"></i> Profile</a></li>
                                            <li class="active"><a  target="blank"href="{{ url('admin/incomedetails',$data->id) }}"><i class="icon-files-empty"></i> Income details</a></li>
                                            <li class="active"><a target="blank" href="{{ url('admin/referraldetails',$data->id) }}"><i class="icon-files-empty"></i> Referral details  </a></li>
                                            <li class="active"><a target="blank" href="{{url('admin/ewalletdetails',$data->id)}}"><i class="icon-files-empty"></i> Ewallet details</a></li>
                                            <li class="active"><a target="blank" href="{{url('admin/payoutdetails',$data->id)}}"><i class="icon-files-empty"></i> Released income details</a></li>
                                             
                                        </ul>
                                    </div>
                    
                </div>
            </div>
            
        </div>