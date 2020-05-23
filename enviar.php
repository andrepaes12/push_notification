<?php 
	include 'conexao.php';

	$nome = utf8_decode($_POST['nome']);
	$setor = utf8_decode($_POST['setor']);
	$observacao = utf8_decode($_POST['observacao']);

	$post_photo = utf8_decode($_FILES["foto"]["name"]);;
	$post_photo_tmp = utf8_decode($_FILES["foto"]["tmp_name"]);

	$ext = pathinfo($post_photo, PATHINFO_EXTENSION); //getting image extension

	if ($ext=='png' || $ext=='PNG' ||
		$ext=='jpg' || $ext=='jpeg' ||
		$ext=='JPG' || $ext=='JPEG' ||
		$ext=='gif' || $ext=='GIF') //checking image extension
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

		//pegar tamanho original da imagem
		list($width_min, $height_min) = getimagesize($post_photo_tmp);
		//definir limite de tamanho (largura)
		$newwidth_min = 400;
		//definir a altura proporcial a largura recém definida
		$newheight_min = ($height_min / $width_min) * $newwidth_min;
		//criar o frame para comprimir a imagem
		$tmp_min = imagecreatetruecolor($newwidth_min, $newheight_min);
		//comprimir a imagem
		imagecopyresampled($tmp_min, $src, 0, 0, 0, 0, $newwidth_min, $newheight_min, $width_min, $height_min);
		
		if(!empty($_POST['nome']) && !empty($_POST['setor']) && !empty($_POST['observacao'])){
			//salvar o arquivo na pasta destino, copiando a imagem
			imagejpeg($tmp_min,"fotos/".$post_photo,85);

			//QUERY para INCLUIR dados no BD
			$queryIncluir = "INSERT INTO auditoria (nome, setor, observacao, foto, data1, kaizen, data2, comentario) VALUES ('".$nome."','".$setor."', '".$observacao."', '".$post_photo."', Now(), 'kaizen.jpg', Now(), '')";
			$incluido = mysqli_query($conexao_db,$queryIncluir);
			
			//gerar link para envio do e-mail
			$link = 'http://musashi-mda.online/patrulha/index.php?input_valor='.$setor;

			if($incluido):
				mysqli_close($conexao_db);
				//enviar o e-mail
				include 'send.php';
				//retornar a página inicial com mensagem de sucesso
				header("location: index.php?enviado=ok");
				else:
					mysqli_close($conexao_db);
					//retornar a página inicial com mensagem de erro
					header("location: index.php?enviado=nok");
			endif;
		} else {
			mysqli_close($conexao_db);
			//retornar a página inicial com mensagem de erro (campos obrigatórios não preenchidos)
			header("location: index.php?campos=nok");
		}
	}
?>
