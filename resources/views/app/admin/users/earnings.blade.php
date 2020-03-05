
<!-- Quick stats boxes -->
<div class="row">

  
    <div class="col-lg-4">
        <!-- Today's revenue -->
        <div class="panel bg-blue-400">
                       <div class="panel-body">
                <div class="heading-elements">
                    <span class="heading-text badge bg-teal-800">
                       {{trans('users.balance')}}
                    </span>
                </div>
                <h3 class="no-margin">
                   $ {{number_format($balance,2)}}
                </h3>
                {{trans('users.balance')}}
                <div class="text-muted text-size-small">
                    
                </div>
            </div>
            
        </div>
        <!-- /today's revenue -->
    </div>

    <div class="col-lg-4">
        <!-- Today's revenue -->
        <div class="panel bg-blue-400">
                       <div class="panel-body">
                <div class="heading-elements">
                    <span class="heading-text badge bg-teal-800">
                       {{trans('users.total_payout')}}
                    </span>
                </div>
                <h3 class="no-margin">
                   $ {{number_format($total_payout,2)}}
                </h3>
                {{trans('users.total_payout')}}
                <div class="text-muted text-size-small">
                    
                </div>
            </div>
            
        </div>
        <!-- /today's revenue -->
    </div>


    <div class="col-lg-4">
        <!-- Today's revenue -->
        <div class="panel bg-blue-400">
                       <div class="panel-body">
                <div class="heading-elements">
                    <span class="heading-text badge bg-teal-800">
                       {{trans('users.incentives')}}
                    </span>
                </div>
                <h3 class="no-margin">
                    {{$incentives}}
                </h3>
                {{trans('users.incentives')}}
                <div class="text-muted text-size-small">
                    
                </div>
            </div>
            
        </div>
        <!-- /today's revenue -->
    </div>
</div>
<!-- /quick stats boxes -->


                