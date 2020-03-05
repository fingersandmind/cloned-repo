
         <div class="row">
                        <div class="col-lg-3">

                            <div class="panel bg-indigo-400 has-bg-image">

                                <div class="panel-body"> 
                                    <h3 class="no-margin text-semibold">  {{(isset($incentives->package)) ? $incentives->package : '' }} {{(isset($incentives->level)) ? $incentives->level : 'NA'}} </h3>

                                       Incentives

                                     
                                </div>
                            </div>
                        </div>

                         

                       

                        <div class="col-lg-3"> 

                            <div class="panel bg-indigo-400 has-bg-image">

                                <div class="panel-body">

                                    <div class="heading-elements">
                                    </div>
                                    <h3 class="no-margin text-semibold">{{round($balance)}}</h3>

                                        {{trans('dashboard.total_income')}}

                                    <div class="text-muted text-size-small" style="visibility: hidden;"> {{trans('dashboard.total_income')}}</div>

                                </div>
 
                            </div>

                        </div>

                        <div class="col-lg-3">

                            <div class="panel bg-danger-400 has-bg-image">

                                <div class="panel-body">

                                    <h3 class="no-margin text-semibold"> {{$total_rs or 0}}</h3>

                                   {{trans('dashboard.total_fund_credit')}}

                                    <div class="text-muted text-size-small" style="visibility: hidden;" > {{trans('dashboard.total_fund_credit')}}</div>

                                </div>


 

                            </div>

                            <!-- /bar chart in colored panel -->



                        </div>



                        <div class="col-lg-3">



                            <!-- Line chart in colored panel -->

                            <div class="panel bg-blue-400 has-bg-image">

                                <div class="panel-body">

                                    <div class="heading-elements">

                                       

                                    </div>



                                    <h3 class="no-margin text-semibold">{{$total_bv or 0}}</h3>

                                    {{trans('dashboard.total_payout')}}

                                    <div class="text-muted text-size-small" style="visibility: hidden;"> {{trans('dashboard.total_payout')}}</div>

                                </div>



 
                            </div>

                            <!-- /line chart in colored panel -->



                        </div>



                          



                        

                </div>





                       