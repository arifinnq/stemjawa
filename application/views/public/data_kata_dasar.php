  
    <div class="container margin-b70">
      <div class="row">
        <div class="col-md-12">
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Data Kata Dasar</a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <!--ul class="nav navbar-nav">
                  <li><a href="<?php echo base_url() ?>administrasi/data_obat/add"><i class="fa fa-plus-circle"></i> Tambah Data</a></li>
                </ul-->
                
                </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
              </nav>
              
            </div>
          </div>
          <div class="table-responsive">
            <table id="table_data" class="table table-bordered table-striped table-admin">
            <thead><tr><th>No</th><th>Kata Dasar</th></tr></thead>
            <tbody>
            <?php 
            // var_dump($data_kata_dasar);die();
            $jumlah = count($data_kata_dasar);

              for( $a =0; $a < $jumlah; $a++){
              ?>
              <tr>
              <td><?=$a+1 ?></td>
              <td><?=$data_kata_dasar[$a]['teks'] ?></td>
              </tr>
            <?php } ?>
            </tbody>
            </table>

          </div>

        </div>
        
