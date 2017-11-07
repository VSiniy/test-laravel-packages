<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">{{ trans_choice($pathToTranslations . '.download_logging.title', 'logging::logging.download_logging.title') }}</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">

    {{ Form::open([
      'method' => 'get',
    ]) }}
      <div class="row">
        <div class="col-xs-6 col-md-4 col-lg-4 form-group {{ $errors->has('date_start') ? 'has-error' : '' }}">
          <label>{{ trans_choice($pathToTranslations . '.download_logging.date_start', 'logging::logging.download_logging.date_start') }}</label><br>
          {{ Form::date('date_start', null, ['class' => 'form-control', 'id' => 'date_start']) }}
          <span class="help-block error">{{ $errors->first('date_start') }}</span>
        </div>
        <div class="col-xs-6 col-md-4 col-lg-4 form-group {{ $errors->has('date_end') ? 'has-error' : '' }}">
          <label>{{ trans_choice($pathToTranslations . '.download_logging.date_end', 'logging::logging.download_logging.date_end') }}</label><br>
          {{ Form::date('date_end', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date_end']) }}
          <span class="help-block error">{{ $errors->first('date_end') }}</span>
        </div>
        <div class="col-xs-6 col-md-4 col-lg-4 form-group">
          <label>&nbsp;</label><br>
          <button type="submit" class="btn btn-primary generate-subscribed" >{{ trans_choice($pathToTranslations . '.download_logging.download_button', 'logging::logging.download_logging.download_button') }}</button>
        </div>
      </div>
    {{ Form::close() }}

  </div>
</div>