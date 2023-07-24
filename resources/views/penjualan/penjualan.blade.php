@extends('template.master')
@section('content')
<style>
    .img-thumbnail {
        padding: .25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        box-shadow: 0 1px 2px rgb(0 0 0 / 8%);
        max-width: 100%;
        height: 150px;
    }

    .tes {
        margin-top: -68px;
        margin-bottom: 53px;
        text-align: center;
        font-weight: bold;
        transform: rotate(45deg);
    }
</style>


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
                <div class="col-md-12">
                    <div id="cart_session"></div>
                </div>
                <?php
                $cart =  Cart::content();
                $total = 0;
                ?>
                <div class="col-sm-4 col-4">
                    <div class="card">
                        <div class="card-body">

                            <select name="boxes" id="kategori" class="form-control select boxselect">
                                <option value="all">ALL</option>
                                <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k->id_kategori ?>">
                                    <?= $k->nm_kategori; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-4">
                    <div class="card">
                        <div class="card-body">
                            <input type="text" id="search_field" class=" form-control" placeholder="Enter Keyword">
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-4">
                    <a href="{{ route('listPenjualan') }}">
                        <div class="card bg-costume">
                            <div class="card-body">
                                <h6 class="text-center majoo"><strong><i class="fa fa-cubes majoo"></i> List Penjualan
                                        Produk</strong></h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-8 col-md-8">
                    <div id="konten"></div>
                </div>
                <div class="col-sm-4 col-md-4" id="cart">

                </div>
            </div>
        </div>

</div>
<!--/. container-fluid -->
</section>
<!-- /.content -->
</div>

<form method="get" class="input_cart">

    <div class="modal fade modal-cart" id="myModal">
        <div class="modal-dialog modal-lg">
            <div id="getModal"></div>
        </div>
    </div>
</form>


<div class="modal" id="myModalp">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->


            <!-- Modal body -->
            <div class="modal-body">
                <center><br>
                    <img width="120" src="<?= asset('assets') ?>/uploads/icon/payment.png" alt="">
                </center><br>
                <h5 class="text-center"> Apakah anda yakin ?</h5>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a href="<?= route('payment') ?>" class="btn btn-primary"> Lanjutkan</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>

        </div>
    </div>
</div>
<style>
    /* card active */
    .buying-selling.active {
        background-image: linear-gradient(to right, #00B7B5 0%, #00B7B5 19%, #019392 60%, #04817F 100%);
    }

    .option1 {
        display: none;
    }

    .buying-selling {
        width: 123px;
        padding: 10px;
        position: relative;
    }

    .buying-selling-word {
        font-size: 10px;
        font-weight: 600;
        margin-left: 35px;
    }

    .radio-dot:before,
    .radio-dot:after {
        content: "";
        display: block;
        position: absolute;
        background: #fff;
        border-radius: 100%;
    }

    .radio-dot:before {
        width: 20px;
        height: 20px;
        border: 1px solid #ccc;
        top: 10px;
        left: 16px;
    }

    .radio-dot:after {
        width: 12px;
        height: 12px;
        border-radius: 100%;
        top: 14px;
        left: 20px;
    }

    .buying-selling.active .buying-selling-word {
        color: #fff;
    }

    .buying-selling.active .radio-dot:after {
        background-image: linear-gradient(to right, #00B7B5 0%, #00B7B5 19%, #019392 60%, #04817F 100%);
    }

    .buying-selling.active .radio-dot:before {
        background: #fff;
        border-color: #699D17;
    }

    .buying-selling:hover .radio-dot:before {
        border-color: #adadad;
    }

    .buying-selling.active:hover .radio-dot:before {
        border-color: #699D17;
    }


    /* .buying-selling.active .radio-dot:after {
        background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);
    } */

    /* dot */
    .buying-selling:hover .radio-dot:after {
        background-image: linear-gradient(to right, #00B7B5 0%, #00B7B5 19%, #019392 60%, #04817F 100%);
    }

    /* .buying-selling.active:hover .radio-dot:after {
        background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);

    } */

    @media (max-width: 400px) {

        .mobile-br {
            display: none;
        }

        .buying-selling {
            width: 49%;
            padding: 10px;
            position: relative;
        }

    }
</style>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var url = "{{ route('tabelProduk') }}?page=1"
        getSearch(url)
        function getSearch(url){
            $("#konten").load(url, "data", function (response, status, request) {
                this; // dom element  
                      
            });
        }
        $(document).on('keyup', '#search_field', function(){
            var s = this.value
            console.log(s)
            var url = "{{ route('tabelProduk') }}?search="+s
            getSearch(url)
        });


        getPage(1)
        $(document).on('click', '.page-link', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getPage(page)
        });

        function getPage(page){
            $("#konten").load("{{ route('tabelProduk') }}?page="+page, "data", function (response, status, request) {
                this; // dom element  
                      
            });
        }
        load_cart();
    
        function load_cart() {
          $.ajax({
            method: "GET",
            url: "{{route('get_cart')}}",
            success: function(hasil) {
              $('#cart').html(hasil);
            }
          });
        }


        $(document).on('click', '.btnInput', function(event) {
          var id_produk = $(this).attr("id_produk");
          $.ajax({
            method: "GET",
            url: "{{route('get_modal')}}?id_produk="+id_produk,
            success: function(hasil) {
              $('#getModal').html(hasil);
                $.ajax({
                    url: "{{route('get_karyawan')}}",
                    method: "GET",
                
                    success: function(data) {
            
                    $('.buying-selling-group').html(data);
            
                    }
                });
            }
          });
        });
    
        $(document).on('submit', '.input_cart', function(event) {
          event.preventDefault();
          var id = $("#cart_id").val();
          var jumlah = $("#cart_jumlah").val();
          var satuan = $("#cart_satuan").val();
          var catatan = $("#cart_catatan").val();
        //   var kd_karyawan = $('.cart_id_karyawan').val();
        var kode = []
          var kd_karyawan = $('input[name^="kd_karyawan"]:checked').each(function() {
                kode.push($(this).val())
                
            });
          $.ajax({
            url: "{{route('cart')}}",
            method: 'get',
            data:{
                id : id,
                jumlah : jumlah,
                satuan : satuan,
                catatan : catatan,
                kd_karyawan : kode,
            },
            success: function(data) {
              if (data == 'kosong') {
                Swal.fire({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  icon: 'error',
                  title: 'Stok tidak cukup'
                });
              }else if (data == 'null'){
                Swal.fire({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  icon: 'error',
                  title: 'Data penjual belum diisi'
                });  
              }else{
                $('#cart_session').html(data);
                $('.modal-cart').modal('hide');
                load_cart();
              }
              
            }
          });
        });
    
        $(document).on('click', '.delete_cart', function(event) {
          var rowid = $(this).attr("id");
          $.ajax({
            url: "{{route('delete_cart')}}",
            method: "GET",
            data: {
              rowid: rowid
            },
            success: function(data) {
              Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: 'Item dihapus dari keranjang'
              });
              $('#cart_session').html(data);
              load_cart();
            }
          });
        });
    
        $(document).on('click', '.min_cart', function(event) {
          var rowid = $(this).attr("id");
          var qty = $(this).attr("qty");
          $.ajax({
            url: "{{route('min_cart')}}",
            method: "GET",
            data: {
              rowid: rowid,
              qty: qty
            },
            success: function(data) {
              // $('#cart_session').html(data); 
              load_cart();
            }
          });
        });
    
        $(document).on('click', '.plus_cart', function(event) {
          var rowid = $(this).attr("id");
          var qty = $(this).attr("qty");
          var id_produk = $(this).attr("id_produk");
        //   alert(id_produk);
          $.ajax({
            url: "{{route('plus_cart')}}",
            method: "GET",
            data: {
              rowid: rowid,
              qty: qty,
              id_produk: id_produk
            },
            success: function(data) {
              if (data) {
                Swal.fire({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  icon: 'error',
                  title: ' Stok tidak cukup'
                });
              }else{
                load_cart();
              }
              
            }
          });
        });
    
        
      });
      var btsearch = {
        init: function(search_field, searchable_elements, searchable_text_class) {
      $(search_field).keyup(function(e) {
        e.preventDefault();
        var query = $(this).val().toLowerCase();
        if (query) {
          // loop through all elements to find match
          $.each($(searchable_elements), function() {
            var title = $(this).find(searchable_text_class).text().toLowerCase();
            if (title.indexOf(query) == -1) {
              $(this).hide();
            } else {
              $(this).show();
            }
          });
        } else {
          // empty query so show everything
          $(searchable_elements).show();
        }
      });
    }
  }

  $(function() {
    // USAGE: btsearch.init(('search field element', 'searchable children elements', 'searchable text class');
    btsearch.init('#search_field', '#demonames div', '.demoname');
  });

  $(document).ready(function(event) {
    $('.boxselect').change(function() {
      $this = $(this);
      $('.box').hide();
      $('.' + $this.val()).show();
      console.log("showing " + $this.val() + " boxes");
    });
  });
    
    
</script>
@endsection