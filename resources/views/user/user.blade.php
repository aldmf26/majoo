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
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="float-left">Data User</h3>
                            <a href="#" class="btn btn-costume btn-sm float-right" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> User</a>
                        </div>
                        <div class="card-body">
                            <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table" id="table"> 
                                            <thead>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Nama</td>
                                                    <td>Role</td>
                                                    <td>Join</td>
                                                    <td>Status</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($user as $k)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $k->nama }}</td>
                                                        <?php if ($k->role_id == 1) : ?>
                                                        <td>Presiden</td>
                                                    <?php elseif ($k->role_id == 3) : ?>
                                                        <td>Head</td>  
                                                    <?php else : ?>
                                                        <td>Kasir</td>
                                                    <?php endif; ?>
                                                        <td>{{ date('d-m-y', strtotime($k->created_at)) }}</td>
                                                        <?php if ($k->is_active == 1) : ?>
                                                        <td class="text-success">Aktif</td>
                                                    <?php else : ?>
                                                        <td class="text-danger">Non Aktif</td>
                                                    <?php endif; ?>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-warning permission" id_user="<?= $k->id_user ?>" data-toggle="modal" data-target="#akses">
                                                            <i class="fa fa-key majoo"></i></button>
                                                            <button type="button" id="<?= $k->id_user ?>" class="btn btn-sm btn-costume edit_user" data-toggle="modal" data-target="#edit<?= $k->id_user ?>"><i style="color: white;" class="fa fa-edit"></i></button>
                                                            <a href="{{ route('hapusUser', ['id_user' => $k->id_user]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ?')" ><i class="fas fa-trash text-light"></i></a>
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


{{-- tambah kategori --}}
<form action="{{ route('tambahUser') }}" method="post">
    @csrf
    <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Tambah User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body">

                    <div class="row">
          
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Nama</label>
                          <input class="form-control" type="text" name="nama" id="nama" required>
                        </div>
          
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Username</label>
                          <input class="form-control" type="text" name="username" id="username" required>
                        </div>
          
                      </div>
          
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Password</label>
                          <input class="form-control" type="password" name="password" id="password" required>
                        </div>
          
                      </div>
          
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Role</label>
                          <select name="role_id" id="role_id" class="form-control" required="">
                            <option value="2">Kasir</option>
                            <option value="3">Head</option>
                            <option value="1">Presiden</option>
                          </select>
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

{{-- edit --}}
@foreach ($user as $u)
<form action="{{ route('editUser') }}" method="post">
    @csrf
    <div class="modal fade" id="edit{{$u->id_user}}">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h4 class="modal-title majoo">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="{{ $u->id_user }}">
                    <div class="row">
          
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Nama</label>
                          <input class="form-control" value="{{ $u->nama }}" type="text" name="nama" id="nama" required>
                        </div>
          
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Role</label>
                          <select name="role_id" id="role_id" class="form-control" required>
                            <?php if ($u->role_id == 1) : ?>
                              <option value="1" selected>Presiden</option>
                              <option value="2">Kasir</option>
                            <?php else : ?>
                              <option value="1">Presiden</option>
                              <option value="2" selected>Kasir</option>
                            <?php endif; ?>
                          </select>
                        </div>
                      </div>
        
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="list_kategori">Status</label>
                          <select name="is_active" id="is_active" class="form-control" required>
                             <?php if ($u->role_id == 1) : ?>
                              <option value="1" selected>Presiden</option>
                              <option value="3">Head</option>
                              <option value="2">Kasir</option>
                            <?php elseif ($u->role_id == 3) : ?>
                              <option value="1">Presiden</option>
                              <option value="3" selected>Head</option>
                              <option value="2">Kasir</option>
                            <?php else : ?>
                              <option value="1">Presiden</option>
                              <option value="3">Head</option>
                              <option value="2" selected>Kasir</option>
                            <?php endif; ?>
                          </select>
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
{{-- ------------------- --}}

<form action="<?= route('updatePermission') ?>" method="post">
  @csrf
  <!-- Modal -->
  <div class="modal fade" id="akses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header btn-costume">
          <h5 class="modal-title majoo" id="exampleModalLabel">Permission</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <input type="hidden" name="id_user" id="id_user">
        
          <div class="row justify-content-center">
                <div class="form-group col-md-3">
                  <label for="list_kategori">Permission</label>
                </div>
              </div>

              <div class="row data_permission">
               
                
            </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-costume">Save/Edit</button>
        </div>
      </div>
    </div>
  </div>

</form>

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
<script>      

  $(document).ready(function(){
    $('.permission').click(function(){
      var id_user = $(this).attr('id_user');
      $('#id_user').val(id_user);

      $(".data_permission").load("{{route('get_permission')}}?id_user="+id_user, "data", function (response, status, request) {
        this; // dom element
        
      });
  

    });
  });

</script>
@endsection
