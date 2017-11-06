<div class="box">
	<div class="box-header">
	  <h3 class="box-title">{{ __('admin.logging.user_logging.title') }}</h3>

	  <div class="box-tools">

	      {{ $rows->links() }}

	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">	
	  <table class="table">
	    <tbody>
	    	<tr>
		      <th style="width: 10px">{{ __('admin.logging.fields.id') }}</th>
		      <th>{{ __('admin.logging.fields.log_name') }}</th>
		      <th>{{ __('admin.logging.fields.subject_id') }}</th>
		      <th>{{ __('admin.logging.fields.subject_type') }}</th>
		      <th>{{ __('admin.logging.fields.causer_id') }}</th>
		      <th>{{ __('admin.logging.fields.causer_type') }}</th>
		      <th>{{ __('admin.logging.fields.description') }}</th>
		      <th>{{ __('admin.logging.fields.created_at') }}</th>
		      <th style="width: 10px">{{ __('admin.logging.fields.properties') }}</th>
		    </tr>

	    	@foreach ($rows as $row)
	    		<tr>
	    		  <td>{{ $row->id }}</td>
			      <td>{{ $row->log_name }}</td>
			      <td>{{ $row->subject_id }}</td>
			      <td>{{ $row->subject_type }}</td>
			      <td>{{ $row->causer_id }}</td>
			      <td>{{ $row->causer_type }}</td>
			      <td>{{ $row->description }}</td>
			      <td>{{ $row->created_at }}</td>
			      <td>

			      	@if (!is_null(Properties::getProperties($row, 'attributes')))
			      		<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ __('admin.logging.properties.attributes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (Properties::getProperties($row, 'attributes') ?? [] as $key => $value)
				              			<p style="margin: 0;">{{ $key }}</p>
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

					@if (!is_null(Properties::getProperties($row, 'old')))
						<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ __('admin.logging.properties.old_attributes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (Properties::getProperties($row, 'old') ?? [] as $key => $value)
				              			<p style="margin: 0;">{{ $key }}</p>
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

					@if (!is_null(Properties::getPropertiesChanges($row)))
						<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ __('admin.logging.properties.changes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (Properties::getPropertiesChanges($row) ?? [] as $value)
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

			      </td>
			    </tr>
	    	@endforeach
	      
	    </tbody>
	  </table>
	</div>
<!-- /.box-body -->
</div>