<div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header bg-costume">
        <h5 class="modal-title majoo">Detail Produk</h5>
        
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">

        <div class="row">
            <div class="col-sm-4 col-md-4">

                <?php if (empty($k->foto)) : ?>
                  <img class="img-thumbnail" width="170" src="<?= asset('assets') ?>/uploads/produk/not-available.png" alt="">
                <?php else : ?>
                    <img class="img-thumbnail" width="170" src="<?= asset('assets') ?>/uploads/produk/<?= $k->foto ?>" alt="">
                <?php endif ?>

            </div>
            <div class="col-sm-8 col-md-8">
                <h6 class="mt-2"><?= $k->nm_produk ?></h6>
                <h6 style="font-weight: bold; color: #00B7B5; font-size: 20px;">Rp. <?= number_format($k->harga) ?></h6>
                <p class="text-dark">Tersedia <?= $k->stok ?> Stok Barang</p>
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        <div class="form-group">
                            <label for="">Jumlah *</label>
                            <input type="number" id="cart_jumlah" min="1" max="<?= $k->stok ?>" name="jumlah"  class="form-control" value="1" required="">
                            <input  type="hidden" id="cart_id" name="id" value="<?= $k->id_produk ?>">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <input type="text" id="cart_satuan" name="satuan" value="<?= $k->satuan ?>" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <h5 style="font-size: 1rem;">DIJUAL OLEH</h5>
        <div class="buying-selling-group" id="buying-selling-group" data-toggle="buttons">
            

        </div>            

        <button type="submit" class="btn float-right  btn-costume"> SIMPAN</button>
        
    </div>
</div>