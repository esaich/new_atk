<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_customer">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" id="customer_id">
            <div class="form-group">
                <label>Nama Customer</label>
                <input type="text" class="form-control" name="customer" id="edit_customer">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-customer"></div>
            </div>
            <div class="form-group">
                <label>Nama Divisi</label>
                <textarea class="form-control" name="alamat" id="edit_alamat" rows="3"></textarea>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
            </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="update">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>



