@extends('layouts.app')

@include('payments.create')

@section('content')
<div class="section-header">
  <h1>Data Payments</h1>
  <div class="ml-auto">
    <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_payment">
      <i class="fa fa-plus"></i> Payment
    </a>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="table_payments" class="display" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Invoice Number</th>
                <th>Supplier</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Description</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Inisialisasi DataTable
  let table = $('#table_payments').DataTable({
  paging: true,
  order: [[1, 'asc']],
  columns: [
    { 
      data: null, 
      render: function (data, type, row, meta) {
        // meta.row = index baris (dimulai dari 0)
        return meta.row + 1;
      }
    }, // No
    { data: 'invoice_number' },
    { data: 'supplier_name' },
    { data: 'amount', render: $.fn.dataTable.render.number(',', '.', 2) },
    { data: 'payment_method' },
    { data: 'payment_date' },
    { data: 'status' },
    { data: 'description' },
    {
      data: null,
      orderable: false,
      searchable: false,
      render: function(data, type, row) {
        return `
          <a href="javascript:void(0)" id="button_edit_payment" data-id="${row.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i></a>
          <a href="javascript:void(0)" id="button_hapus_payment" data-id="${row.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i></a>
        `;
      }
    }
  ]
});


  // Load data payments dari server
  function loadPayments() {
    $.ajax({
      url: "/payments/get-data",
      type: "GET",
      dataType: 'JSON',
      success: function(response) {
        table.clear();
        let counter = 1;
        $.each(response.data, function(key, value) {
          value.no = counter++;
          table.row.add(value);
        });
        table.draw();
      }
    });
  }

  loadPayments();

  // Tampilkan modal tambah payment
  $('#button_tambah_payment').on('click', function() {
    $('#modal_tambah_payment form')[0].reset();
    $('.alert').addClass('d-none').removeClass('d-block').html('');
    $('#modal_tambah_payment').modal('show');
  });

  // Simpan data payment baru
  $('#store_payment').on('click', function(e) {
    e.preventDefault();

    // Reset alert error
    $('.alert').addClass('d-none').removeClass('d-block').html('');

    let formData = new FormData($('#modal_tambah_payment form')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
      url: '/payments',
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,

      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: response.message,
          showConfirmButton: true,
          timer: 2000
        });

        $('#modal_tambah_payment').modal('hide');
        loadPayments();
      },

      error: function(xhr) {
        if (xhr.status === 422) { // Validation error
          let errors = xhr.responseJSON;
          for (let key in errors) {
            let alertId = '#alert-' + key;
            if ($(alertId).length) {
              $(alertId).removeClass('d-none').addClass('d-block').html(errors[key][0]);
            }
          }
        } else {
          // Debug error: tampilkan di console dan swal popup pesan error lengkap
          console.error('Server Error:', xhr.status, xhr.responseText);

          let message = 'Terjadi kesalahan server';
          try {
            let json = JSON.parse(xhr.responseText);
            if (json.message) message = json.message;
            else if (json.error) message = json.error;
          } catch(e) {
            message = xhr.responseText || message;
          }

          Swal.fire({
            icon: 'error',
            title: 'Error ' + xhr.status,
            html: '<pre style="text-align:left;white-space:pre-wrap;">' + message + '</pre>',
            showConfirmButton: true,
            width: 600,
          });
        }
      }
    });
  });
  // Hapus data payment
$('body').on('click', '#button_hapus_payment', function() {
  let payment_id = $(this).data('id');
  let token = $('meta[name="csrf-token"]').attr('content');

  Swal.fire({
    title: 'Apakah Kamu Yakin?',
    text: "Data payment akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Batal',
    confirmButtonText: 'Ya, Hapus!',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: `/payments/${payment_id}`,
        type: 'DELETE',
        data: {
          _token: token,
        },
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
          loadPayments();
        },
        error: function(xhr) {
          console.error('Delete Error:', xhr.status, xhr.responseText);

          let message = 'Terjadi kesalahan server saat menghapus data';
          try {
            let json = JSON.parse(xhr.responseText);
            if (json.message) message = json.message;
            else if (json.error) message = json.error;
          } catch(e) {
            message = xhr.responseText || message;
          }

          Swal.fire({
            icon: 'error',
            title: 'Error ' + xhr.status,
            html: '<pre style="text-align:left;white-space:pre-wrap;">' + message + '</pre>',
            showConfirmButton: true,
            width: 600,
          });
        }
      });
    }
  });
});


});
</script>
@endsection
