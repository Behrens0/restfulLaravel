<div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCustomerModalLabel">Create Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createCustomerForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customerName">Name</label>
                                <input type="text" class="form-control @error('customerName') is-invalid @enderror" id="customerName" name="customerName" required>
                                @error('customerName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customerLastName">Last Name</label>
                                <input type="text" class="form-control @error('customerLastName') is-invalid @enderror" id="customerLastName" name="customerLastName" required>
                                @error('customerLastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customerDni">Dni</label>
                                <input type="text" class="form-control @error('customerDni') is-invalid @enderror" id="customerDni" name="customerDni" required>
                                @error('customerDni')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customerEmail">Email</label>
                                <input type="text" class="form-control @error('customerEmail') is-invalid @enderror" id="customerEmail" name="customerEmail" required>
                                @error('customerEmail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customerCommune">Commune</label>
                                <input type="text" class="form-control @error('customerCommune') is-invalid @enderror" id="customerCommune" name="customerCommune" required>
                                @error('customerCommune')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customerAddress">Address</label>
                                <input type="text" class="form-control @error('customerAddress') is-invalid @enderror" id="customerAddress" name="customerAddress" required>
                                @error('customerAddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveCustomerBtn">Save Customer</button>
            </div>
        </div>
    </div>
</div>