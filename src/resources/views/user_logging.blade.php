<div class="box">
	<div class="box-header">
	  <h3 class="box-title">{{ __('logging::logging.user_logging.title') }}</h3>

	  <div class="box-tools logging">

	      {{ $rows->appends($filters)->links() }}

	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">	
	  
		<table class="table">
			<tbody>
				<tr>

					@foreach ($translatedFields as $field)
						<th>{{ $field }}</th>
					@endforeach

					<th>{{ __('logging::logging.fields.properties') }}</th>

			    </tr>

				@foreach ($rows as $row)
					<tr>

						@foreach ($fields as $field)
							<td>{{ $row->{$field} }}</td>
						@endforeach

				      <td>

				      	@if (!is_null(\Ebola\Logging\Helpers\Properties::getProperties($row, 'attributes')))
				      		<div class="action-buttons dropdown logging-call_properties">
							    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
							    <ul class="dropdown-menu logging-dropdown_menu">
					              <li class="header logging-center_text">{{ __('logging::logging.properties.attributes_title') }}</li>
					              <li>
					              	<div class="logging-center_text">

					              		@foreach (\Ebola\Logging\Helpers\Properties::getProperties($row, 'attributes') ?? [] as $key => $value)
					              			<p style="margin: 0;">{{ $key }}</p>
					              			<p class="logging-value">{{ $value }}</p>
					              		@endforeach
					              		
					              	</div>
					              </li>
					              <li class="footer logging-center_text">{{--<a href="#">See All Messages</a>--}}</li>
					            </ul>
							</div>
						@endif

						@if (!is_null(\Ebola\Logging\Helpers\Properties::getProperties($row, 'old')))
							<div class="action-buttons dropdown logging-call_properties">
							    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
							    <ul class="dropdown-menu logging-dropdown_menu">
					              <li class="header logging-center_text">{{ __('logging::logging.properties.old_attributes_title') }}</li>
					              <li>
					              	<div class="logging-center_text">

					              		@foreach (\Ebola\Logging\Helpers\Properties::getProperties($row, 'old') ?? [] as $key => $value)
					              			<p style="margin: 0;">{{ $key }}</p>
					              			<p class="logging-value">{{ $value }}</p>
					              		@endforeach
					              		
					              	</div>
					              </li>
					              <li class="footer logging-center_text">{{--<a href="#">See All Messages</a>--}}</li>
					            </ul>
							</div>
						@endif

						@if (!is_null(\Ebola\Logging\Helpers\Properties::getPropertiesChanges($row)))
							<div class="action-buttons dropdown logging-call_properties">
							    <a class="btn btn-default btn-xs dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-external-link-square"></i></a>
							    <ul class="dropdown-menu logging-dropdown_menu">
					              <li class="header logging-center_text">{{ __('logging::logging.properties.changes_title') }}</li>
					              <li>
					              	<div class="logging-center_text">

					              		@foreach (\Ebola\Logging\Helpers\Properties::getPropertiesChanges($row) ?? [] as $value)
					              			<p class="logging-value">{{ $value }}</p>
					              		@endforeach
					              		
					              	</div>
					              </li>
					              <li class="footer logging-center_text">{{--<a href="#">See All Messages</a>--}}</li>
					            </ul>
							</div>
						@endif

				      </td>
				    </tr>
				@endforeach
				
				<tr>

					@foreach ($translatedFields as $field => $translate)
						<th>{!! \Ebola\Logging\Helpers\Filters::getFilter($field, $translate) ?? $translate !!}</th>
					@endforeach

					<th>{{ __('logging::logging.fields.properties') }}</th>

			    </tr>
			  
			</tbody>
		</table>

	</div>
<!-- /.box-body -->
</div>