<?php
if(isset($_REQUEST['submit'])!=""){
  $name=$_FILES['photo']['name'];
  $size=$_FILES['photo']['size'];
  $type=$_FILES['photo']['type'];
  $temp=$_FILES['photo']['tmp_name'];
	
	if(	 move_uploaded_file($temp,"_videos/".$name)	)
	{
	echo "upload of".$name." successfull";
	}
	else
	{
	echo "upload of".$name." unsuccessfull";
	}
}
?>

<!-- Creates zip file-->
<?php
	$error = "";		//error holder
	if(isset($_POST['createpdf'])){
		$post = $_POST;		
		$file_folder = "_videos/";	// folder to load files
		if(extension_loaded('zip')){	// Checking ZIP extension is available
			if(isset($post['files']) and count($post['files']) > 0){	// Checking files are selected
				$zip = new ZipArchive();			// Load zip library	
				$zip_name = "SSP".time().".zip";			// Zip name
				if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){		// Opening zip file to load files
					$error .=  "* Sorry ZIP creation failed at this time<br/>";
				}
				foreach($post['files'] as $file){				
					$zip->addFile($file_folder.$file);			// Adding files into zip
				}
				$zip->close();
				if(file_exists($zip_name)){
					// push to download the zip
					header('Content-type: application/zip');
					header('Content-Disposition: attachment; filename="'.$zip_name.'"');
					readfile($zip_name);
					// remove zip file is exists in temp path
					unlink($zip_name);
				}
				
			}else
				$error .= "* Please select file to zip <br/>";
		}else
			$error .= "* You dont have ZIP extension<br/>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
		<title>SSP files</title>
	
</head>	
<body>
<center>
	<h1>SSP ZIP file Downloader</h1>
		
		<div style="border:1px solid #aaa; width:371px; padding:10px;">
			<form enctype="multipart/form-data" action="ZipDownloader.php" name="form" method="post">
				Select File
					<input type="file" name="photo" id="photo" /></td>
					<input type="submit" name="submit" id="submit" value="Submit" />
			</form>
		</div>
		<br>
	<form name="zips" method="post">
		<?php if(!empty($error)) { ?>
			<p style=" border:#C10000 1px solid; background-color:#FFA8A8; color:#B00000;padding:8px; width:588px; margin:0 auto 10px;"><?php echo $error; ?></p>
		<?php } ?>
				<table cellpadding="8" cellspacing="1" border="1" width="500">
						<thead>
							<tr>
								<th width="4%" align="center">*</th>
								<th width="80%">File Name</th>
							</tr>
						</thead>
						</tbody>
							<?php
	foreach(glob("_videos/*.*") as $filessp){
			if(   ( substr($filessp, (strlen($filessp)-strlen(".mp4")), strlen($filessp)) === ".mp4" )    )
			{
			$video_name = substr( $filessp, (strlen("_videos/")), strlen($filessp) );
							?>
							<tr>
								<td align="center">
									<input type="checkbox" name="files[]" value="<?php echo $video_name; ?>" />
								</td>
				
								<td>
									&nbsp;<?php echo $video_name ;?>
								</td>
							</tr>
							<?php
			}
		else
			{
			$video_name = substr( $filessp, (strlen("_videos/")), strlen($filessp) );
							?>
							<tr>
								<td align="center">
									<input type="checkbox" name="files[]" value="<?php echo $video_name; ?>" />
								</td>
				
								<td>
									&nbsp;<?php echo $video_name ;?>
								</td>
							</tr>
							<?php
			}
	}
		?>
							<tr>
								<td colspan="3" align="center">
									<input type="submit" name="createpdf" value="Download as ZIP file" style="background:#A70F58; border-radius:10px; padding:15px; font-weight:bold; color:#fff;" />
								</td>
							</tr>
							
						</tbody>
				</table>
	
	</form>
</center>
</body>
</html>