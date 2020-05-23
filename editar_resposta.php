<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>[Ação Corretiva]</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<style>
  body {
	margin: 25px;
}
</style>

<body>

	<legend><h3>
		Registrar Ação Corretiva</h3></legend>

	<form action="atualizar_resposta.php" method="POST" enctype="multipart/form-data">

	<?php
  	include 'conexao.php';
		$id = $_GET['id'];
		$queryLinha = "SELECT * FROM auditoria WHERE id='".$id."'";
		$linhas = mysqli_query($conexao_db,$queryLinha);
		if($linhas):
			foreach ($linhas as $linha):
				extract($linha);
				$id;
				utf8_encode($nome);
				utf8_encode($setor);
				utf8_encode($observacao);
				utf8_encode($foto);
			endforeach;
		else:
			echo 'Erro ao trazer os resultados: '.mysqli_error($conexao_db);
		endif; 
	?>

	<fieldset>
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="setor" value="<?php echo $setor; ?>" />
	  <div class="form-group row">
			<label class="col-sm-2 col-form-label" style="color: black">
				NOME DO AUDITOR: </label>
			<div class="col-sm-10">
				<label class="col-sm-2 col-form-label" 
					style="text-transform: uppercase; color: darkblue">
					<?php echo utf8_encode($nome); ?></label>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" style="color: black">
				SETOR AUDITADO: </label>
			<div class="col-sm-10">
				<label class="col-sm-2 col-form-label" 
					style="text-transform: uppercase; color: darkblue">
					<?php echo utf8_encode($setor); ?></label>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" style="color: black">
				NÃO CONFORMIDADE: </label>
			<div class="col-sm-10">
				<label class="col-sm-2 col-form-label" 
					style="text-transform: uppercase; color: darkblue">
					<?php echo utf8_encode($observacao); ?></label>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" style="color: black">
				EVIDÊNCIA (FOTO): </label>
				<?php echo "<img src='fotos/".utf8_encode($foto)."' width='200'><br><br>"; ?>
		</div>
		
		<div class="form-group row">
			<label for="comentario" class="col-sm-2 col-form-label" style="color: darkblue">
				AÇÃO CORRETIVA: </label>
			<div class="col-sm-10">
				<textarea name="comentario" class="form-control" placeholder="AÇÃO CORRETIVA"></textarea>
			</div>
		</div>
		
		<div class="form-group row">
			<!-- MAX_FILE_SIZE deve preceder o campo input -->
			<label for="kaizen" class="col-sm-2 col-form-label" style="color: darkblue">
				FOTO DA MELHORIA: </br>
				<small class="" style="color: red">
					Tamanho máximo: 2Mb.</small></label>
			<div class="col-sm-10">
				<input for="kaizen" type="hidden" name="MAX_FILE_SIZE" value="30720000" />
				<input type="file" class="form-control-file" name="kaizen" required/>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label" style="color: darkblue">
				DATA: </label>
			<div class="col-sm-10">
				<?php
					date_default_timezone_set("America/Manaus");
					$data=date("d/m/Y");
				?>
				<input type="text" readonly class="form-control" value="<?php echo $data ?>">
			</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label" style="color: darkblue">
					ENVIAR DADOS: </label>
			<div class="col-sm-10">
				<button type="submit" class="btn btn-primary">
					ENVIAR RESPOSTA</button>
			</div>
		</div>
		
	</fieldset>
</form>

<a href="index.php?input_valor=<?php echo $setor?>"><< Voltar</a>
		
</body>
</html>
