<div class="modal fade " id="newClientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog big-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="clientModalLabel"> New Client </h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmClient" name="frmClient" class="form-horizontal" novalidate="">
                             <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        </form>
                        
                        <div class="frmModule-footer"></div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary" id="btn-save-client" value="add">Save changes</button>
                        <input type="hidden" id="package_id" name="client_id" value="0">
                    </div>
                </div>
            </div>
        </div>

<!--Existing Client form-->

<div class="modal fade " id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
            <div class="modal-dialog big-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="clientModalLabel"> Existing  Client </h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmAddClient" name="frmAddClient" class="form-horizontal" novalidate="">
                             

                        <div class="form-group{{ $errors->has('emails') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Addresses In Comma separated format</label>

                            <div class="col-md-6">
                                <input id="emails" type="text" class="form-control" name="emails" value="{{ old('email') }}" required>

                               
                            </div>
                        </div>

                        

                        </form>
                        
                        <div class="frmModule-footer"></div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary" id="btn-save-addclient" value="add">Save changes</button>
                        <input type="hidden" id="package_id" name="package_id" value="0">
                    </div>
                </div>
            </div>
        </div>

@section('script')
     @parent
   
    @endsection