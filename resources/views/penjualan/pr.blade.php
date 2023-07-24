<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="semua" role="tabpanel"
        aria-labelledby="pills-home-tab">
        <div class="row" id="demonames">
            <?php foreach ($produk as $p) : ?>
            <div class="col-sm-6 col-md-4 col-lg-3 box all <?= $p->id_kategori ?>">
                <?php if ($p->stok == '0') : ?>
                <a style="color: #787878;" type="button">
                    <div class="card" style="background: rgba(0, 0, 0, 0.3);">
                        <div class="card-body">
                            <?php if (empty($p->foto)) : ?>
                            <img src="" alt="">
                            <?php else : ?>
                            <img class="img-thumbnail" loading=”lazy” width="170"
                                style="opacity: 0.5;"
                                src="<?= asset('assets') ?>/uploads/produk/{{$p->foto}}" alt="">
                            <?php endif ?>
                            <h4 class="tes text-danger">Stok Habis</h4>
                            <h6 class="mt-2 text-sm demoname">
                                <?= $p->nm_produk ?>
                            </h6>
                            <h6 style="font-weight: bold;">Rp .
                                <?= number_format($p->harga) ?>
                            </h6>
                        </div>
                    </div>
                </a>
                <?php else : ?>

                <a href="" id_produk="{{$p->id_produk}}" style="color: #787878;" type="button"
                    data-toggle="modal" data-target="#myModal" class="open-product btnInput">

                    <div class="card">
                        <div class="card-body">
                            <?php if (empty($p->foto)) : ?>
                            <img src="" alt="">
                            <?php else : ?>
                            <img class="img-thumbnail" loading=”lazy” width="170"
                                src="<?= asset('assets') ?>/uploads/produk/{{$p->foto}}" alt="">
                            <?php endif ?>
                            <h6 class="mt-2 text-sm demoname">
                                <?= $p->nm_produk ?>
                            </h6>
                            <h6 style="font-weight: bold;">Rp .
                                <?= number_format($p->harga) ?>
                            </h6>
                        </div>
                    </div>
                </a>


                <?php endif ?>
            </div>


            <?php endforeach ?>
        </div>
    </div>
</div>
{{-- {{ $produk->links() }} --}}