<div class="box">
	<div class="box-header">
	  <h3 class="box-title">{{ trans_choice($pathToTranslations . '.user_logging.title', 'logging::logging.user_logging.title') }}</h3>

	  <div class="box-tools">

	      {{ $rows->links() }}

	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">	
	  <table class="table">
	    <tbody>
	    	<tr>
		      <th style="width: 10px">{{ trans_choice($pathToTranslations . '.fields.id', 'logging::logging.fields.id') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.log_name', 'logging::logging.fields.log_name') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.subject_id', 'logging::logging.fields.subject_id') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.subject_type', 'logging::logging.fields.subject_type') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.causer_id', 'logging::logging.fields.causer_id') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.causer_type', 'logging::logging.fields.causer_type') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.description', 'logging::logging.fields.description') }}</th>
		      <th>{{ trans_choice($pathToTranslations . '.fields.created_at', 'logging::logging.fields.created_at') }}</th>
		      <th style="width: 10px">{{ trans_choice($pathToTranslations . '.fields.properties', 'logging::logging.fields.properties') }}</th>
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

			      	@if (!is_null(\Ebola\Logging\Helpers\Properties::getProperties($row, 'attributes')))
			      		<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ trans_choice($pathToTranslations . '.properties.attributes_title', 'logging::logging.properties.attributes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (\Ebola\Logging\Helpers\Properties::getProperties($row, 'attributes') ?? [] as $key => $value)
				              			<p style="margin: 0;">{{ $key }}</p>
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

					@if (!is_null(\Ebola\Logging\Helpers\Properties::getProperties($row, 'old')))
						<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ trans_choice($pathToTranslations . '.properties.old_attributes_title', 'logging::logging.properties.old_attributes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (\Ebola\Logging\Helpers\Properties::getProperties($row, 'old') ?? [] as $key => $value)
				              			<p style="margin: 0;">{{ $key }}</p>
				              			<p style="display: inline-block; width:100%;">{{ $value }}</p>
				              		@endforeach
				              		
				              	</div>
				              </li>
				              <li class="footer" style="text-align: center">{{--<a href="#">See All Messages</a>--}}</li>
				            </ul>
						</div>
					@endif

					@if (!is_null(\Ebola\Logging\Helpers\Properties::getPropertiesChanges($row)))
						<div class="action-buttons dropdown" style="float: left; padding: 3px;">
						    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
						    <ul class="dropdown-menu">
				              <li class="header" style="text-align: center">{{ trans_choice($pathToTranslations . '.properties.changes_title', 'logging::logging.properties.changes_title') }}</li>
				              <li>
				              	<div style="text-align: center;">

				              		@foreach (\Ebola\Logging\Helpers\Properties::getPropertiesChanges($row) ?? [] as $value)
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