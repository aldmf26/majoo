@extends('template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">List Penjualan</h3>

                            <button data-toggle="modal" data-target="#modal-view" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-eye majoo"></i> View</button>
				            <button data-toggle="modal" data-target="#modal-summary" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-print majoo"></i> Summary</button>
				            <button data-toggle="modal" data-target="#modal-excel" class="btn btn-sm btn-costume float-right ml-2"><i class="fas fa-file-download"></i> Download</button><br><br>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
										<th>Lokasi</th>
										<th>Jam</th>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($list as $p) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d-m-Y', strtotime($p->tanggal)) ?></td>
                                            <td><a href="<?= route('detail_invoice', ['invoice' => $p->no_nota]); ?>"><?= $p->no_nota; ?></a></td>
                                            <td><?= $p->lokasi ?></td>
											<td><?= date('H:i', strtotime($p->tgl_input)) ?></td>
											<td><?= $p->nm_produk ?></td>											
                                            <td><?= $p->jumlah ?></td>
                                            <td><?= $p->satuan ?></td>
                                            <td><?= number_format($p->harga, 0) ?></td>
                                            <td><?= number_format($p->total, 0) ?></td>
                                            <td><?= $p->nama ?></td>
                                           
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>
<!--/. container-fluid -->
</section>
<!-- /.content -->
</div>

<form action="" method="GET">
					<div class="modal fade" id="modal-view">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header btn-costume">
									<h4 class="modal-title text-light">View Data</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="row form-group">
                                    <div class="col-lg-6">
                                        <label for="">Dari</label>
                                        <input required type="date" name="tgl1" class="form-control">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Sampai</label>
                                        <input type="date" name="tgl2" class="form-control">
                                    </div>
									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-costume" >Lanjutkan</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>

				<form action="<?= route('summary_penjualan_produk'); ?>" method="GET">
					<div class="modal fade" id="modal-summary">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header btn-costume">
									<h4 class="modal-title majoo">Export Summary</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="">Dari</label>
                                            <input required type="date" name="tgl1" class="form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Sampai</label>
                                            <input type="date" name="tgl2" class="form-control">
                                        </div>
                                      
									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-costume majoo">Lanjutkan</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<form action="<?= route('excel_penjualan_produk'); ?>" method="GET">
					<div class="modal fade" id="modal-excel">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header btn-costume">
									<h4 class="modal-title majoo">Export Summary</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="row form-group">
                                        <div class="col-lg-6">
                                            <label for="">Dari</label>
                                            <input required type="date" name="tgl1" class="form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Sampai</label>
                                            <input type="date" name="tgl2" class="form-control">
                                        </div>
                                      
									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-costume majoo">Lanjutkan</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>

@endsection