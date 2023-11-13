@extends('layouts.frontend')
@section('content')
<div class="card-header">
            <h3 class="card-title">Select2 (Default Theme)</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div style="display: block;" data-select2-id="30" class="card-body">
            <div data-select2-id="29" class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Minimal</label>
                  <select aria-hidden="true" tabindex="-1" data-select2-id="1" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                    <option data-select2-id="3" selected="selected">Alabama</option>
                    <option data-select2-id="38">Alaska</option>
                    <option data-select2-id="39">California</option>
                    <option data-select2-id="40">Delaware</option>
                    <option data-select2-id="41">Tennessee</option>
                    <option data-select2-id="42">Texas</option>
                    <option data-select2-id="43">Washington</option>
                  </select><span style="width: 100%;" data-select2-id="2" dir="ltr" class="select2 select2-container select2-container--default select2-container--below"><span class="selection"><span aria-labelledby="select2-r6l6-container" aria-disabled="false" tabindex="0" class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false"><span title="Alabama" aria-readonly="true" role="textbox" id="select2-r6l6-container" class="select2-selection__rendered">Alabama</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Disabled</label>
                  <select aria-hidden="true" tabindex="-1" data-select2-id="4" class="form-control select2 select2-hidden-accessible" disabled="" style="width: 100%;">
                    <option data-select2-id="6" selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select><span style="width: 100%;" data-select2-id="5" dir="ltr" class="select2 select2-container select2-container--default select2-container--disabled"><span class="selection"><span aria-labelledby="select2-avn0-container" aria-disabled="true" tabindex="-1" class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false"><span title="Alabama" aria-readonly="true" role="textbox" id="select2-avn0-container" class="select2-selection__rendered">Alabama</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Multiple</label>
                  <select aria-hidden="true" tabindex="-1" data-select2-id="7" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" style="width: 100%;">
                    <option>Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select><span style="width: 100%;" data-select2-id="8" dir="ltr" class="select2 select2-container select2-container--default"><span class="selection"><span aria-disabled="false" tabindex="-1" class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input style="width: 450px;" placeholder="Select a State" class="select2-search__field" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" type="search"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Disabled Result</label>
                  <select aria-hidden="true" tabindex="-1" data-select2-id="9" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
                    <option data-select2-id="11" selected="selected">Alabama</option>
                    <option data-select2-id="45">Alaska</option>
                    <option data-select2-id="46" disabled="disabled">California (disabled)</option>
                    <option data-select2-id="47">Delaware</option>
                    <option data-select2-id="48">Tennessee</option>
                    <option data-select2-id="49">Texas</option>
                    <option data-select2-id="50">Washington</option>
                  </select><span style="width: 100%;" data-select2-id="10" dir="ltr" class="select2 select2-container select2-container--default select2-container--below"><span class="selection"><span aria-labelledby="select2-u96e-container" aria-disabled="false" tabindex="0" class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false"><span title="Alabama" aria-readonly="true" role="textbox" id="select2-u96e-container" class="select2-selection__rendered">Alabama</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <h5>Custom Color Variants</h5>
            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Minimal (.select2-danger)</label>
                  <select aria-hidden="true" tabindex="-1" data-select2-id="12" class="form-control select2 select2-danger select2-hidden-accessible" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option data-select2-id="14" selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select><span style="width: 100%;" data-select2-id="13" dir="ltr" class="select2 select2-container select2-container--default"><span class="selection"><span aria-labelledby="select2-4bn5-container" aria-disabled="false" tabindex="0" class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false"><span title="Alabama" aria-readonly="true" role="textbox" id="select2-4bn5-container" class="select2-selection__rendered">Alabama</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Multiple (.select2-purple)</label>
                  <div class="select2-purple">
                    <select aria-hidden="true" tabindex="-1" data-select2-id="15" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                      <option>Alabama</option>
                      <option>Alaska</option>
                      <option>California</option>
                      <option>Delaware</option>
                      <option>Tennessee</option>
                      <option>Texas</option>
                      <option>Washington</option>
                    </select><span style="width: 100%;" data-select2-id="16" dir="ltr" class="select2 select2-container select2-container--default"><span class="selection"><span aria-disabled="false" tabindex="-1" class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input style="width: 450px;" placeholder="Select a State" class="select2-search__field" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" type="search"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div style="display: block;" class="card-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin.
          </div>
@endsection
