<?php
include("../conn/conn.php");

$page = $_GET['page_guru'];
if( !isset($_GET['page_guru']) )
{
   $page = 1;
}
else
{
   $page = $_GET['page_guru'];
}
$rec_limit= 10;
$offset = ($rec_limit * $page) - $rec_limit;

$id = $_GET['id'];
$query = mysql_query("select *from guru where No = '$id'");
if($_SESSION["admin"]){
?>
<script type="text/javascript">
  var idList = ";"
  document.getElementById('textbox1').value = idList;

  function dell(cek, id) {

    if (cek.checked == 1) {
      idList = idList + id + ";"
      document.getElementById('textbox1').value = idList;
    }

    if (cek.checked == 0) {
      var v;
      v = ";" + id + ";"
      idList = idList.replace(v, ";");
      document.getElementById('textbox1').value = idList;
    }

    if (idList == ";") {
      document.getElementById('submit2').disabled = true;
    } else {
      document.getElementById('submit2').disabled = false;
    }

  }

</script>
<body>
			<!-- CONTENT BOXES -->
			<div class="content-box">
				<div class="box-header clear">
					<ul class="tabs clear">
						<li><a href="#table">Table Guru</a></li>
						<li><a href="#forms">Input Data Guru</a></li>
						
					</ul>
					
					<h2>Master Guru</h2>
				</div>
				
				<div class="box-body clear">
					<!-- TABLE -->
					<div id="table">					
					<!------------------------------------------------------------------------->
							<form method="GET" action="index.php">	
							<input type='hidden' name='page' value='Master_Guru'>
							<input type="text" class="text fl" name="txt_search" value='<?php print $txt_search;?>' maxlength='5'/>&nbsp;
								<select name="jenis_search">
									<option value="nip">NIP</option>
									<option value="id_finger">Finger</option>
									<option value="nama">Nama</option>
								</select>&nbsp;
								<input type="submit" class="submit" value="Search"/>
							</form>	<p>
					<!------------------------------------------------------------------------->
						<form method="post" action="master/proses/delete_all.php">
						<div class="dataTables_wrapper">
						<table>
							<thead>
								<tr>
									<th>NIP</th>
									<th>Finger</th>
									<th>Nama</th>
									
									
									<th>Foto</th>
									<th>Tindakan</th>
								</tr>
							</thead>
							
							<tbody>
							
							<?php
							$txt_search = $_GET["txt_search"];
							if( $txt_search==""){
							$txt_search="";
							}
							else{
							$txt_search=$txt_search;
							}
							$jenis_search = $_GET["jenis_search"];
							
							if(!empty($txt_search)){
								$q = mysql_query("select *from guru where $jenis_search like '%$txt_search%' order by No limit $offset, $rec_limit");
								$qc = mysql_query("select count(*) as tot3 from guru where $jenis_search like '%$txt_search%'");
							}else{
								$q = mysql_query("select *from guru order by No limit $offset, $rec_limit");
								$qc = mysql_query("select count(*) as tot3 from guru");
							}
							$apake = 1 ;
							while($row = mysql_fetch_array($q)){
							?>
						
								<tr>
									
									
									<td><?php print $row["nip"];?></td>
									<td><?php print $row["id_finger"];?></td>
									<td><?php print $row["nama"];?></td>
									<td><?php if($row["foto"] == "") {print"no image";} else{?><img src="master/foto/<?php print $row['foto'];?>" width="30" height="30"></img><?php }?></td>
									<td>
										<a href="?page=Edit_Master_Guru&id=<?php print $row['No'];?>"><img src="UniAdmin_files/ico_edit_16.png" class="icon16 fl-space2" alt="" title="edit" /></a>
										<a href="master/proses/Master_Guru.php?id=<?php print $row['No']?>&delete=delete" onclick="return confirm('Apakah anda ingin menghapus <?php echo $row["nama"]; ?> ?')"><img src="UniAdmin_files/ico_delete_16.png" class="icon16 fl-space2" alt="" title="delete" /></a>
									</td>
								</tr>
								<input type='hidden' id='textbox1' value=''/>
							<?php
								$apake++;}
							?>
							</tbody>
						</table>
						</form>
						<div class="dataTables_paginate paging_full_numbers">
							<span>
								<?
									$tot = mysql_fetch_array($qc);
									$jumhal = ceil($tot["tot3"] / $rec_limit);
									if(!empty($txt_search)){
										for($i=1;$i<=$jumhal;$i++){
											?>
											<a href="index.php?page=Master_Guru&txt_search=<?php echo $txt_search; ?>&jenis_search=<?php echo $jenis_search; ?>&page_guru=<?php echo $i; ?>"><span class="paginate_button"><?=$i?></span></a>
											
											<?php
										}
									}else{
										for($i=1;$i<=$jumhal;$i++){
											?>
											<a href="index.php?page=Master_Guru&page_guru=<?php echo $i; ?>"><span class="paginate_button"><?=$i?></span></a>
											<?php
										}
									}
									
								?>
							
							</span>
						
						</div>
						</div>
						
						
						
						
					</div><!-- /#table -->
					
					<!-- Custom Forms -->
						<div id="forms">
					`		<form action="master/proses/Master_Guru.php" method="post" class="form"  enctype="multipart/form-data">
								<div class="form-field clear">
									<label for="textfield" class="form-label fl-space2">NIP: <span class="required">*</span></label>
									<input type="text" id="textfield" class="text fl" name="nip" /><span class="required">&nbsp; (Tidak bisa diubah / diedit)</span>
								
								</div>
								
								<div class="form-field clear">
									<label for="id_finger" class="form-label fl-space2">Finger ID: <span class="required">*</span></label>
									<input type="text" id="id_finger" class="text fl" name="id_finger"  maxlength='5'/><span class="required">&nbsp; (Tidak bisa diubah / diedit)</span>
								</div><!-- /.form-field -->
								
								<div class="form-field clear">
									<label for="textfield" class="form-label fl-space2">Nama: <span class="required">*</span></label>
									<input type="text" id="textfield" class="text fl" name="nama" value='<?php echo $row['nama'];?>' maxlength='22'/>
								</div><!-- /.form-field -->
							
								
							
								<div class="form-field clear">
									<label for="textfield" class="form-label fl-space2">Password: <span class="required">*</span></label>
									<input type="password" id="textfield" class="text fl" name="pass" />
								
								</div><!-- /.form-field -->
							
								<?php /*<div class="form-field clear">
									<label for="textfield" class="form-label fl-space2">Mata Pelajaran: <span class="required">*</span></label>
									<input type="text" id="textfield" class="text fl" name="pass" />
								
									</div><!-- /.form-field -->*/
								?>
								<div class="form-field clear">
									<label for="file" class="form-label fl-space2">Unggah Foto:</label>
									<input type="file" id="file" class="form-file fl" name="foto" />
								</div><!-- /.form-field -->							
								<div class="form-field clear">
									<input type="submit" class="submit fr" value="Submit" />
								</div><!-- /.form-field -->																								
							</form>
							<!-- /#forms -->
						</div> <!-- end of box-body -->
				</div>
			</div> <!-- end of content-box -->			
</body>
<?php
}
else {
								include("home.php");
							}
?>
