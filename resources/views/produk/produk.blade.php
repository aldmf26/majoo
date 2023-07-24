@extends('template.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Daftar Produk</h3>
                            <a href="#" class="btn btn-costume btn-sm float-right" data-toggle="modal"
                                data-target="#tambah"><i class="fa fa-plus"></i> Produk</a>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table" id="table">
                                            <thead>
                                                <tr style="font-weight: bold;">
                                                    <td>No</td>
                                                    <td>Nama Produk</td>
                                                    <td>SKU</td>
                                                    <td>Kategori</td>
                                                    <td>Qty</td>
                                                    <td>Satuan</td>
                                                    <td>Harga Jual</td>
                                                    <td>Komisi</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no = 1;
                                                @endphp
                                                @foreach ($produk as $p)
                                                <tr>
                                                    <td>
                                                        <?= $no++ ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->nm_produk ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->sku ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->nm_kategori ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->stok ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->satuan ?>
                                                    </td>
                                                    <td>
                                                        <?= number_format($p->harga, 0) ?>
                                                    </td>
                                                    <td>
                                                        <?= $p->komisi ?>%
                                                    </td>
                                                    <td>
                                                        <a href="" data-toggle="modal"
                                                            data-target="#edit<?= $p->id_produk  ?>"
                                                            class="btn btn-xs btn-costume"><i
                                                                class="fas text-light fa-edit"></i></a>
                                                        <a href="{{ route('hapusProduk', ['id_produk' => $p->id_produk]) }}"
                                                            onclick="return confirm('Apakah anda yakin ?')"
                                                            class="btn btn-xs btn-danger"><i
                                                                class="fas text-light fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>


{{-- tambah --}}
<form action="{{ route('tambahProduk') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Tambah Produk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row form-group ">
                        <div class="col-sm-4 ol-md-6 col-xs-12 mb-2">
                            <label for="">Masukkan Gambar</label>
                            <input type="file" class="dropify form-control" data-height="150" name="image"
                                placeholder="Image">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <input type="hidden" name="id_lokasi" value="<?= $id_lokasi ?>">
                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Nama Produk</dt>
                                    </label>
                                    <input type="text" name="nm_produk" class="form-control" placeholder="Nama Produk"
                                        required>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Kategori</dt>
                                    </label>
                                    <select name="id_kategori" class="form-control select" required>
                                        <option value="">-Pilih Kategori-</option>
                                        <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k->id_kategori ?>">
                                            <?= $k->nm_kategori ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Satuan</dt>
                                    </label>
                                    <select name="id_satuan" class="form-control select" id="" required>
                                        <option value="">-Pilih Satuan-</option>
                                        <?php foreach ($satuan as $s) : ?>
                                        <option value="<?= $s->id_satuan ?>">
                                            <?= $s->satuan ?>
                                        </option>
                                        <?php endforeach ?>

                                    </select>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Stok</dt>
                                    </label>
                                    <input type="text" class="form-control" name="stok" placeholder="cth : 1" required>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Harga Modal</dt>
                                    </label>
                                    <input type="text" class="form-control" name="harga_modal" placeholder="cth : 5000"
                                        required>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Harga Jual</dt>
                                    </label>
                                    <input type="text" class="form-control" name="harga" placeholder="cth : 5000"
                                        required>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Komisi</dt>
                                    </label>
                                    <select name="komisi" class="form-control select" id="" required>
                                        <option value="5">5%</option>
                                        <option value="2.5">2.5%</option>
                                        <option value="0">0%</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
</form>
</div>
</div>
<!-- /.modal-content -->
</div>
</form>

{{-- edit --}}
@foreach ($produk as $p)
<form action="{{ route('editProduk') }}" method="post">
    @csrf
    <div class="modal fade" id="edit{{$p->id_produk}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Edit Produk</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="id_produk" value="{{$p->id_produk}}">
                <div class="modal-body">
                    <div class="row form-group ">
                        <div class="col-sm-4 ol-md-6 col-xs-12 mb-2">
                            <label for="">Masukkan Gambar</label>
                            <input type="file" class="dropify form-control" data-height="150" name="image"
                                placeholder="Image">
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <input type="hidden" name="id_lokasi" value="<?= $id_lokasi ?>">
                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Nama Produk</dt>
                                    </label>
                                    <input type="text" name="nm_produk" value="{{ $p->nm_produk }}" class="form-control"
                                        placeholder="Nama Produk" required>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Kategori</dt>
                                    </label>
                                    <select name="id_kategori" class="form-control select" required>
                                        <option value="">-Pilih Kategori-</option>
                                        <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k->id_kategori ?>" {{ $k->id_kategori == $p->id_kategori ?
                                            'selected' : '' }}>
                                            <?= $k->nm_kategori ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Satuan</dt>
                                    </label>
                                    <select name="id_satuan" class="form-control select" id="" required>
                                        <option value="">-Pilih Satuan-</option>
                                        <?php foreach ($satuan as $s) : ?>
                                        <option value="<?= $s->id_satuan ?>" {{ $s->id_satuan == $p->id_satuan ?
                                            'selected' : '' }}>
                                            <?= $s->satuan ?>
                                        </option>
                                        <?php endforeach ?>

                                    </select>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Stok</dt>
                                    </label>
                                    <input type="text" value="{{ $p->stok }}" class="form-control" name="stok"
                                        placeholder="cth : 1" required>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Harga Modal</dt>
                                    </label>
                                    <input type="text" value="{{ $p->harga_modal }}" class="form-control"
                                        name="harga_modal" placeholder="cth : 5000" required>
                                </div>

                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Harga Jual</dt>
                                    </label>
                                    <input type="text" value="{{ $p->harga }}" class="form-control" name="harga"
                                        placeholder="cth : 5000" required>
                                </div>
                                <div class="col-lg-4 mb-2">
                                    <label for="">
                                        <dt>Komisi</dt>
                                    </label>
                                    <select name="komisi" class="form-control select" id="" required>
                                        <option {{ $p->komisi == 5 ? 'selected' : '' }} value="5">5%</option>
                                        <option {{ $p->komisi == 2.5 ? 'selected' : '' }} value="2.5">2.5%</option>
                                        <option {{ $p->komisi == 0 ? 'selected' : '' }} value="0">0%</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-costume">Save</button>
                </div>
</form>
</div>
</div>
<!-- /.modal-content -->
</div>
</form>
@endforeach
{{-- --------------------- --}}



@endsection
@section('script')
@if (Session::get('sukses'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        icon: 'success',
        title: "{{Session::get('sukses')}}"
    });
</script>
@endif
@if (Session::get('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        icon: 'error',
        title: "{{Session::get('error')}}"
    });
</script>
@endif
@endsection