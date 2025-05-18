<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah_payment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" id="form_payment">
        <div class="modal-body">

          <div class="form-group">
            <label>Invoice Number</label>
            <input type="text" class="form-control" name="invoice_number" id="invoice_number">
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-invoice_number"></div>
          </div>

          <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-control">
              <option value="">-- Pilih Supplier --</option>
              @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->supplier }} - {{ $supplier->alamat }}</option>
              @endforeach
            </select>
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-supplier_id"></div>
          </div>

          <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" class="form-control" name="amount" id="amount">
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-amount"></div>
          </div>

          <div class="form-group">
            <label>Payment Method</label>
            <input type="text" class="form-control" name="payment_method" id="payment_method" placeholder="Cash, Transfer, dll">
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-payment_method"></div>
          </div>

          <div class="form-group">
            <label>Payment Date</label>
            <input type="date" class="form-control" name="payment_date" id="payment_date">
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-payment_date"></div>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="status" id="status" class="form-control">
              <option value="Pending">Pending</option>
              <option value="Paid">Paid</option>
              <option value="Cancelled">Cancelled</option>
            </select>
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-status"></div>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-description"></div>
          </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="store_payment">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
