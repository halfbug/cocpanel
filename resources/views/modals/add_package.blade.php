<!-- Styles -->
<link href="{{ asset('css/bootstrap-formhelpers.min.css') }}" rel="stylesheet">
<div class="modal fade " id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="addPackageModalLabel"> Package</h4>
            </div>
            <div class="modal-body">
                <form id="frmPackage" name="frmPackage" class="form-horizontal" novalidate="">
                    <div class="form-group error">
                        <label for="inputName" class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="title" name="title" placeholder="Package title" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" ></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control has-error" id="price" name="price" placeholder="0.00" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Currency </label>
                        <div class="col-sm-9">
                            <select class="form-control has-error input-medium bfh-currencies" id="currency" name="currency" placeholder="select"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Payment Frequency </label>
                        <div class="col-sm-9">
                            @foreach ($epackage->getPaymentsFrequencies() as $pfre)
                            <div class="radio-inline">
                                <input type="radio" name="paymnent_frequency" value="{{$pfre}}">{{$pfre }}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-payment_frequency" class="col-sm-3 control-label">Module Release Schedule </label>
                        <div class="col-sm-9">
                            @foreach ($epackage->getReleaseSchedule() as $rsch)
                            <div class="radio">
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="release_schedule" value="{{$rsch}}">{{$rsch}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                     <div class="form-group error">
                         <label for="facebook_group" class="col-sm-3 control-label"><i class="fa fa-facebook-square"></i>Facebook Group</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="facebook_group" name="facebook_group" placeholder="" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-available_modules" class="col-sm-3 control-label">Select Modules </label>
                        <div class="col-sm-9">
                            Drag and drop to select modules.
                            <!--start multi select--> 
                            <div class="row">
                                <div class="col-xs-5 panel panel-default">
                                    <label class="">Available Modules</label>
                                    <ol class="available-modules list-unstyled list-group ">
                                        @foreach ($live_modules as $module)
                                        <li value="{{ $module->id }}" id="{{ $module->id}}" style="cursor:move" ><i class="fa fa-fw fa-folder"></i>{{ $module->title }}</li>
                                        @endforeach
                                    </ol>


                                </div>

                                <div class="col-xs-1">
                                    <br>
                                    <br>
                                    <!--<button type="button" id="right_All_1" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>-->
                                    <!--<button type="button" id="right_Selected_1" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>-->
                                    <!--<button type="button" id="left_Selected_1" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>-->
                                    <!--<button type="button" id="left_All_1" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>-->
                                </div>
                                
                                <div class="col-xs-5 panel panel-default">
                                    <label>Selected Modules</label>
                                    <ol class="selected-modules list-unstyled list-group" style="cursor:move">

                                    </ol>
                                </div>
                            </div>

                            <!--<div id="serialize_output2">testing</div>-->

                            <!-- end multi select -->
                        </div>
                    </div>
                </form>

                <div class="frmModule-footer"></div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-primary" id="btn-save-package" value="add">Save changes</button>
                <input type="hidden" id="package_id" name="package_id" value="0">
            </div>
        </div>
    </div>
</div>

@section('script')
@parent
<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: 'textarea',
    height: 300,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'undo redo | insert | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    content_css: '//www.tinymce.com/css/codepen.min.css'
});
</script>
<script src="js/bootstrap-formhelpers.js"></script>
<script src="js/bootstrap-formhelpers-currencies.js"></script>
<script src="{{ asset('js/jquery-sortable.js') }}"></script>
<script>
$("ol.available-modules").sortable({
  group: 'no-drop',
//  drop: false
});
var group =$("ol.selected-modules").sortable({
  group: 'no-drop',
//  handle: 'i.icon-move',
  pullPlaceholder:true,
//  onDragStart: function ($item, container, _super) {
//    // Duplicate items of the no drop area
//    if(!container.options.drop)
//      $item.clone().insertAfter($item);
//    _super($item, container);
//    console.log('ondrag');
//  },
  onDrop: function ($item, container, _super) {
    var data = group.sortable("serialize").get();

    var jsonString = JSON.stringify(data, null, ' ');
console.log('inside');
    $('#serialize_output2').text(jsonString);
console.log(jsonString);
    _super($item, container);
  }
});
//var group = $("ol.selected-modules").sortable({
//  group: 'selected-modules',
//  isValidTarget: function  ($item, container) {
//    if($item.is(".highlight"))
//      return true;
//    else
//      return $item.parent("ol")[0] === container.el[0];
//  },
//  onDrop: function ($item, container, _super) {
//  //  $('#serialize_output').text(
//     console.log( group.sortable("serialize").get().join("\n"));
//    _super($item, container);
//  },
//  serialize: function (parent, children, isContainer) {
//    return isContainer ? children.join() : parent.text();
//  },
//  tolerance: 6,
//  distance: 10
//});

console.log("group");
</script>

<!--<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script>
$('.sortable').sortable({
  update: function(){
     console.log('sortable updated'); 
  }
});
</script>-->
@endsection