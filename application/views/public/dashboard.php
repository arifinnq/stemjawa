    
    <div class="container margin-b50 margin-t50">

        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="well">
            <form class="form-horizontal" role="form" method="post" action="<?= base_url()?>">
                
                <div class="form-group">
                  <label for="inputth" class="col-sm-3 control-label">Pilih Dokumen Uji</label>
                  <div class="col-sm-6">
                    <select name="dokumenid" class="select2" required>
                      <?php foreach ($dokumen as $row): ?>
                          <option value="<?=$row['id']?>"> Dokumen Uji - <?=$row['id']?> </option>
                      <?php endforeach ?>
                    </select>
                  </div>
                
                <div class="col-sm-3 form-check">
                  <input type="checkbox" class="form-check-input" id="tokenizing" name="tokenizing">
                  <label class="form-check-label" for="tokenizing"><i>Tokenizing</i></label>
                </div>
              
              </div>

                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" class="btn btn-primary bold"><i class="fa fa-save"></i> Proses </button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>

        <?php if ($_POST) { ?>
        <div class="row">
          <div class="col-md-12">
            <div class="well">
              <div class="page-header">
                <strong><h2>Dokumen Uji - <?=$_POST['dokumenid'];?></h2></strong>
              </div>
              <div class="page-header">
                <h2>Teks Asli</h2>
              </div>
              <?= $teks;?> 
              <hr class="hr1">

              <div class="page-header">
                <h2>Hasil Stemming</h2>
              </div>
              <?= $stemming;?> 
              <hr class="hr1">
              <span style="background:red;color:white">Tidak Terstem</span>
              <span style="background:green;color:white">Terstem</span><br><br>
              <?php echo "total teks : ".$jumlah."<br><br>";
              echo "total stem : ".$totalstem." // ".($totalstem/$jumlah*100)." %<br><br>";
              echo "tidak terstem : ".$nostem." // ".($nostem/$jumlah*100)." %<br><br>";
              ?>
            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. </p>
            </div>
          </div>
        </div>
        <?php } ?>

      </div>