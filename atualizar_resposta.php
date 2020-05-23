<?php
	//comentários conforme arquivo atualizar.php
	include 'conexao.php';
	
	$id = $_POST['id'];
	$setor = $_POST['setor'];
	$txtcomentario = utf8_decode($_POST['comentario']);
	
	$post_photo = utf8_decode($_FILES["kaizen"]["name"]);
	$post_photo_tmp = $_FILES["kaizen"]["tmp_name"];
	// $type = $_FILES["kaizen"]["type"];
	// $size = $_FILES["kaizen"]["size"];
	// $error = $_FILES["kaizen"]["error"];

	$ext = pathinfo($post_photo, PATHINFO_EXTENSION);

	if ($ext=='png' || $ext=='PNG' ||
		$ext=='jpg' || $ext=='jpeg' ||
		$ext=='JPG' || $ext=='JPEG' ||
		$ext=='gif' || $ext=='GIF')
	{
		if ($ext=='jpg' || $ext=='jpeg' || $ext=='JPG' || $ext=='JPEG')
		{
			$src = imagecreatefromjpeg($post_photo_tmp);
		}
		if ($ext=='png' || $ext=='PNG')
		{
			$src = imagecreatefrompng($post_photo_tmp);
		}
		if ($ext=='gif' || $ext=='GIF')
		{
			$src = imagecreatefromgif($post_photo_tmp);
		}

		list($width_min, $height_min) = getimagesize($post_photo_tmp);
		$newwidth_min = 400;
		$newheight_min = ($height_min / $width_min) * $newwidth_min;
		$tmp_min = imagecreatetruecolor($newwidth_min, $newheight_min);
		imagecopyresampled($tmp_min, $src, 0, 0, 0, 0, $newwidth_min, $newheight_min, $width_min, $height_min);

		//SELECIONAR
		$selecao = "SELECT * FROM auditoria WHERE id='".$id."' ";
		$linhas = mysqli_query($conexao_db, $selecao);
		if($linhas):
			foreach ($linhas as $linha):
				extract($linha);
				$foto_db = utf8_encode($kaizen);
				if($foto_db != 'kaizen.jpg'):
					unlink("fotos/$foto_db");
				endif;
			endforeach;
		endif;

		//ATUALIZAR
		imagejpeg($tmp_min,"fotos/".$post_photo,85);

		$queryAtualizar = "UPDATE auditoria SET kaizen='".$post_photo."', data2=Now(), comentario='".$txtcomentario."'  WHERE id='".$id."' ";
		$atualizar = mysqli_query($conexao_db,$queryAtualizar);

		$link = 'http://musashi-mda.online/patrulha/index.php?input_valor='.$setor;
		$resposta = 'OK';

		if($atualizar):
			mysqli_close($conexao_db);
			include 'send.php';
			header("location: index.php?atualizado=ok");
		else:
			mysqli_close($conexao_db);
			header("location: index.php?atualizado=nok");
		endif;
	}
?>
