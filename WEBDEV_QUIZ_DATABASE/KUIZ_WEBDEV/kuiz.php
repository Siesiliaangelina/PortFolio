<!DOCTYPE html>
<?php
    include "includes/config.php";

    if(isset($_POST['simpan']))
    {
        if(isset($_REQUEST['kodearea']))
        {
            $areakode = $_REQUEST['kodearea'];
        }
        if (!empty($areakode))
        {
            $areakode = $_POST['kodearea'];
        }
        else {
           die("anda harus memasukan kodenya");
        }
        $namaarea = $_POST['namaarea'];
        $areawilayah = $_POST['areawilayah'];
        $keterangan = $_POST['areaket'];
        $provinsiID = $_POST['ProvinsiID'];
        $provinsiname = $_POST['Provinsiname'];
        $provinsitgl = $_POST['ProvinsiTGL'];

        mysqli_query($connection, "insert into area values ('$areakode', '$namaarea', '$areawilayah', '$keterangan', '$provinsiID')");
        mysqli_query($connection, "insert into provinsi values ('$provinsiID', '$provinsiname', '$provinsitgl')");
        header("location:kuiz.php");
    }

    $datawilayah = mysqli_query($connection, "select * from wilayah");
    $dataarea = mysqli_query($connection, "select * from area");


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUIS PHP</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-10">
<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Input Area Wisata</h1>
                </div>
</div> <!-- penutup jumbotron -->
  <form method="POST">
  <div class="form-group row">
    <label for="kodearea" class="col-sm-2 col-form-label">Kode Area</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="kodearea" name="kodearea" placeholder="kode area" maxlength="4">
    </div>
  </div>

  <div class="form-group row">
    <label for="namaarea" class="col-sm-2 col-form-label">Nama Area</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="namaarea" name="namaarea" placeholder="nama area">
    </div>
  </div>

  <div class="form-group row">
    <label for="areawilayah" class="col-sm-2 col-form-label">Wisata</label>
    <div class="col-sm-10">
    <select  class="form-control" name="areawilayah">
        <option>Wisata</option>
        <?php while($row = mysqli_fetch_array($datawilayah)) {
            ?>
        <option  value="<?php echo $row["WilayahName"] ?>">
            <?php echo $row["WilayahName"]?>
        </option>
        <?php } ?>
    </select>
    </div>
    </div>

    <div class="form-group row">
    <label for="areaket" class="col-sm-2 col-form-label">Keterangan</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="areaket" name="areaket" placeholder="Keterangan">
    </div>
  </div>

  <div class="form-group row">
    <label for="provinsiID" class="col-sm-2 col-form-label">Provinsi ID</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="provinsiID" name="ProvinsiID" placeholder="Provinsi ID">
    </div>
    </div>

    <div class="form-group row">
    <label for="provinsiname" class="col-sm-2 col-form-label">Nama Provinsi</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="provinsiname" name="Provinsiname" placeholder="Nama Provinsi">
    </div>
    </div>

    <div class="form-group row">
    <label for="provinsiTGL" class="col-sm-2 col-form-label">Tanggal Berdiri</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="provinsiTGL" name="ProvinsiTGL" placeholder="Tanggal berdiri">
    </div>
    </div>

  <div class="form-group row">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
    <input style="background-color: red;" type="submit" class="btn btn-primary" value="simpan" name="simpan"></button>
    <input type="reset" class="btn btn-secondary" value="batal" name="batal"></button>
</form>
</div>
<div class="col-sm-1"></div>
</div> <!-- penutup class row -->

<!-- memulai dengan menampilkan data -->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Lokasi Wisata</h1>
                    <h2>Hasil Entri data</h2>
                </div>
            </div> <!-- penutup jumbotron -->

            <form method="POST">
                <div class="form-group row mb-2">
                    <label for="search" class="col-sm-3">Nama Area</label>
                    <div class="col-sm-6">
                        <input type="text" name="search" class="form-control" id="search" 
                               value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" placeholder="Cari Nama Area">
                    </div>
                    <input type="submit" name="kirim" class="col-sm-1 btn btn-primary" value="Search">
                </div>
            </form>

            <table class="table table-hover table-danger">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Area</th>
                        <th>Nama Area</th>
                        <th>AWilayah Area</th>
                        <th>Keterangan Area</th>
                        <th>Provinsi ID</th>
                        <th>Nama Provinsi</th>
                        <th>Tgl Berdiri</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                if(isset($_POST["kirim"]))
                    {
                        $query = mysqli_query($connection, "select area.*, provinsi.provinsiNama, provinsi.provinsiTglBerdiri
                                                            from area, provinsi where areanama like '%".$search."%' AND area.provinsiID = provinsi.provinsiID");
                    }
                else{
                        $query = mysqli_query($connection, "select area.*, provinsi.provinsiNama, provinsi.provinsiTglBerdiri 
                                                            from area, provinsi WHERE area.provinsiID = provinsi.provinsiID");
                    }
                   
                    $nomor = 1;
                    while ($row = mysqli_fetch_array($query))
                    { ?>
                        <tr>
                            <td><?php echo $nomor;?></td>
                            <td><?php echo $row['areaID'];?></td>
                            <td><?php echo $row['areanama'];?></td>
                            <td><?php echo $row['areawilayah'];?></td>
                            <td><?php echo $row['areaketerangan'];?></td>
                            <td><?php echo $row['provinsiID'];?></td>
                            <td><?php echo $row['provinsiNama'];?></td>
                            <td><?php echo $row['provinsiTglBerdiri'];?></td>
                        </tr>
            <?php $nomor = $nomor+1; ?>
            <?php   } ?>

                </tbody>


            </table>
        </div>
        <div class="col-sm-1"></div>
    </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script> 
<script>
            $( function() {
            $( "#provinsiTGL" ).datepicker({
                dateFormat: "yy-mm-dd"
                });
            } );
        </script>
</body>
</html>