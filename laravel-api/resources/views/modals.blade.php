
<div class="modal fade" id="createRegionModal" tabindex="-1" role="dialog" aria-labelledby="createRegionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRegionModalLabel">Create Region</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createRegionForm">
                    <div class="form-group">
                        <label for="regionName">Region Name</label>
                        <input type="text" class="form-control" id="regionName" name="regionName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveRegionBtn">Save Region</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createCommuneModal" tabindex="-1" role="dialog" aria-labelledby="createCommuneModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCommuneModalLabel">Create Commune</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createCommuneForm">
                    <div class="form-group">
                        <label for="communeName">Commune Name</label>
                        <input type="text" class="form-control" id="communeName" name="communeName" required>
                    </div>
                    <div class="form-group">
                        <label for="communeReg">Region ID</label>
                        <input type="text" class="form-control" id="communeReg" name="communeReg" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveCommuneBtn">Save Commune</button>
            </div>
        </div>
    </div>
</div>