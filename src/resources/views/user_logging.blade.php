<div class="box">
	<div class="box-header">
	  <h3 class="box-title">{{ __('logging::logging.user_logging.title') }}</h3>

	  <div id="pagination" class="box-tools logging">

	      @include('logging::_pagination')

	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">	
	  
		@include('logging::_table')

	</div>
<!-- /.box-body -->
</div>