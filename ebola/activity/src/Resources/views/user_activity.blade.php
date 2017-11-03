<div class="box">
	<div class="box-header">
	  <h3 class="box-title">{{ __('admin.activity.user_activity.title') }}</h3>

	  <div class="box-tools">

	      {{ $rows->links() }}

	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">	
	  <table class="table">
	    <tbody>
	    	<tr>
		      <th style="width: 10px">{{ __('admin.activity.fields.id') }}</th>
		      <th>{{ __('admin.activity.fields.log_name') }}</th>
		      <th>{{ __('admin.activity.fields.subject_id') }}</th>
		      <th>{{ __('admin.activity.fields.subject_type') }}</th>
		      <th>{{ __('admin.activity.fields.causer_id') }}</th>
		      <th>{{ __('admin.activity.fields.causer_type') }}</th>
		      <th>{{ __('admin.activity.fields.description') }}</th>
		      <th>{{ __('admin.activity.fields.created_at') }}</th>
		      <th style="width: 10px">{{ __('admin.activity.fields.properties') }}</th>
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

			      	@if (!is_null(\App\Components\ActivityRender::getProperties($row, 'attributes')))
			      		<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ __('admin.activity.properties.attributes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (\App\Components\ActivityRender::getProperties($row, 'attributes') ?? [] as $key => $value)
				              			<p style="margin: 0;">{{ $key }}</p>
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

					@if (!is_null(\App\Components\ActivityRender::getProperties($row, 'old')))
						<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ __('admin.activity.properties.old_attributes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (\App\Components\ActivityRender::getProperties($row, 'old') ?? [] as $key => $value)
				              			<p style="margin: 0;">{{ $key }}</p>
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

					@if (!is_null(\App\Components\ActivityRender::getPropertiesChanges($row)))
						<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ __('admin.activity.properties.changes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (\App\Components\ActivityRender::getPropertiesChanges($row) ?? [] as $value)
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