<div class="modal fade " id="questionsModel" tabindex="-1" role="dialog" aria-labelledby="add_questionLabel" aria-hidden="true">
    <div class="modal-dialog big-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="add_questionLabel"> Documents</h4>
            </div>
            <div class="modal-body">
                <h3>Questions</h3>

                                    <table class="table">
                                    <thead>
                                        <tr>
    <!--                                        <th>ID</th>-->
                                            <th>S.No</th>
                                            <th>Questions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="que-list" name="que-list">

                                    </tbody>
                                </table>
                            </div>


                   


            
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>-->
                <!--<input type="hidden" id="module_id" name="module_id" value="0">-->
            </div>
        </div>
    </div>
</div>


              <h3>New </h3>

                            <form action="{{ url('questions/upload') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                <div class="row">

                                    <div class="form-group">
                                        <label for="inputDetail" class="col-sm-3 control-label">Question</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="question" name="question" ></textarea>
                                        </div>
                                    </div>


                                    <input type="hidden" id="que_module_id" name="que_module_id" value="0">
                                    
                                </div>
                            </form>   


@section('script')
@parent
<script src="{{asset('js/question.js')}}"></script>
@endsection