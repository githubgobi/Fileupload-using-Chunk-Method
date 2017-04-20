<?php


// It work if file upload or not - by gobi
/*
if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
    echo 'No upload';
    exit();
}
else
{
  echo "Uploaded";
  exit();
}*/

// It work if file upload or not - by gobi


$target_path = 'upload/';

$tmp_name = $_FILES['file']['tmp_name'];
$filename = $_FILES['file']['name'];
$target_file = $target_path.$filename;
$num = $_POST['num'];
$num_chunks = $_POST['num_chunks'];

move_uploaded_file($tmp_name, $target_file.$num);

// count ammount of uploaded chunks
$chunksUploaded = 0;
for ( $i = 1; $i <= $num; $i++ ) {
  usleep(50);
    if ( file_exists( $target_file.$i ) ) {
         ++$chunksUploaded;
    }
}


// and THAT's what you were asking for
// when this triggers - that means your chunks are uploaded
if ($chunksUploaded == $num_chunks) {

    /* here you can reassemble chunks together */
    for ($i = 1; $i <= $num_chunks; $i++) {

      $file = fopen($target_file.$i, 'rb');
      $buff = fread($file, 2097152);
      fclose($file);
      if($i==1)
      {
        $final = fopen($target_file, 'w+');
        $write = fwrite($final, $buff);
        fclose($final);
      }else
      {
        $final = fopen($target_file, 'ab');
        $write = fwrite($final, $buff);
        fclose($final);
      }
      

      unlink($target_file.$i);
    }
    echo "SUCCESS LAST";
    return;
}
else
{
  if ($num != $num_chunks)
  {
    echo "SUCCESS FIRST";
    return;  
  }
  else
  {
     echo "FAIL FIRST";
      return;
  }
 
}
return FALSE;
?>
