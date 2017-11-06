<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">{{ __('admin.logging.download_logging_title') }}</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">

    {{ Form::open([
      'method' => 'get',
    ]) }}
      <div class="row">
        <div class="col-xs-6 col-md-4 col-lg-4 form-group {{ $errors->has('date_start') ? 'has-error' : '' }}">
          <label>{{ __('admin.logging.udate_start') }}</label><br>
          {{ Form::date('date_start', null, ['class' => 'form-control', 'id' => 'date_start']) }}
          <span class="help-block error">{{ $errors->first('date_start') }}</span>
        </div>
        <div class="col-xs-6 col-md-4 col-lg-4 form-group {{ $errors->has('date_end') ? 'has-error' : '' }}">
          <label>{{ __('admin.logging.date_end') }}</label><br>
          {{ Form::date('date_end', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date_end']) }}
          <span class="help-block error">{{ $errors->first('date_end') }}</span>
        </div>
        <div class="col-xs-6 col-md-4 col-lg-4 form-group">
          <label>&nbsp;</label><br>
          <button type="submit" class="btn btn-primary generate-subscribed" >{{ __('admin.logging.download_logging') }}</button>
        </div>
      </div>
    {{ Form::close() }}

  </div>
</div>