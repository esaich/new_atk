<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID Pembayaran, primary key, auto increment
            $table->string('invoice_number', 50); // Nomor Invoice Pembayaran
            $table->unsignedBigInteger('supplier_id'); // Relasi ke tabel suppliers
            $table->decimal('amount', 15, 2); // Jumlah Pembayaran
            $table->string('payment_method', 50); // Metode Pembayaran
            $table->date('payment_date'); // Tanggal Pembayaran
            $table->enum('status', ['Paid', 'Pending', 'Cancelled'])->default('Pending'); // Status Pembayaran
            $table->text('description')->nullable(); // Keterangan Pembayaran (boleh kosong)
            $table->timestamps();

            // Foreign key constraint ke tabel suppliers
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
