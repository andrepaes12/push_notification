<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>[Patrulha da Qualidade]</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<style>
	body {
		margin: 25px;
	}
</style>

<body>

<legend>
	<a href="index.php">
		Patrulha da Qualidade [Quality Patrol - &#21697;&#36074;&#12497;&#12488;&#12525;&#12540;&#12523;]</a></legend>

<?php 
	//ESCONDE MENSAGENS PHP
	ini_set('display_errors', 0 );
	error_reporting(0);

	//VERIFIÇÃO
	if($_GET['enviado'] == 'ok'){
		$msg = 'OCORRÊNCIA CADASTRADA! UM E-MAIL FOI ENVIADO AO GESTOR DA ÁREA.';
		$typemsg = 'success';
	}else if($_GET['enviado'] == 'nok'){
		$msg = 'ERROR: USUÁRIO NÃO CADASTRADO.';
		$typemsg = 'danger';
	}else if($_GET['campos'] == 'nok'){
		$msg = 'ATENÇÃO: TODOS OS CAMPOS DEVEM SER PREENCHIDOS.';
		$typemsg = 'alert';
	}else if($_GET['formatoImg'] == 'nok'){
		$msg = "ERROR: FORMATO DE IMAGEM INVÁLIDO.";
		$typemsg = 'danger';
	}else if($_GET['enviadoPasta'] == 'nok'){
		$msg = "ERROR: ARQUIVO NÃO ENVIADO.";
		$typemsg = 'danger';
	}else if($_GET['tamanhoFoto'] == 'nok'){
		$msg = 'ATENÇÃO: ARQUIVO EXCEDE AO TAMANHO PERMITIDO (2Mb)!';
		$typemsg = 'alert';
	}else if($_GET['atualizado'] == 'nok'){
		$msg = 'ERROR: NÃO HOUVE ATUALIZAÇÃO DA AÇÃO CORRETIVA!';
		$typemsg = 'danger';
	}else if($_GET['atualizado'] == 'ok'){
		$msg = 'AÇÃO CORRETIVA REGISTRADA COM SUCESSO!';
		$typemsg = 'success';
	}else{
		$msg = '';
	}

	if($msg!=''){
		echo "<div class='alert alert-$typemsg role='alert'>
		$msg</div>";
	}
?>

<form action="enviar.php" method="POST" enctype="multipart/form-data">
<fieldset>
	<div class="form-group row">
		<label for="nome" class="col-sm-2 col-form-label" style="color: darkblue">
			NOME DO AUDITOR: </label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nome" placeholder="AUDITOR" required />
		</div>
	</div>
	
	<div class="form-group row">
		<label for="setor" class="col-sm-2 col-form-label" style="color: darkblue">
			SETOR AUDITADO: </label>
		<div class="col-sm-10">
			<select name="setor" class="form-control" required>
				<option value="">Escolha o setor auditado</option>
				<option value="forjaria">Forjaria</option>
				<option value="eixo">Usinagem de Eixos</option>
				<option value="balanceiro">Eixo Balanceiro</option>
				<option value="biela">Biela</option>
				<option value="comando">Comando</option>
				<option value="tambor">Tambor Seletor</option>
				<option value="gear">Engrenagem</option>
				<option value="t3">Tratamento Térmico</option>
				<option value="retifica">Retífica</option>
				<option value="brunimento">Brunimento</option>
				<option value="assy">Montagem</option>
				<option value="recebimento">Recebimento</option>
				<option value="coali">COALI</option>
				<option value="expedicao">Expedição</option>
				<option value="outros">Outros</option>
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label for="observacao" class="col-sm-2 col-form-label" style="color: darkblue">
			DESCRIÇÃO DA OCORRÊNCIA: 
			<small class="" style="color: red">
				Informar também: máquina, peça/modelo.</small></label>
		<div class="col-sm-10">
			<textarea name="observacao" class="form-control" placeholder="OCORRÊNCIA DA AUDITORIA" required></textarea>
		</div>
	</div>

	<div class="form-group row">
	<!-- MAX_FILE_SIZE deve preceder o campo input -->
		<label for="observacao" class="col-sm-2 col-form-label" style="color: darkblue">
			FOTO DA OCORRÊNCIA: 
			<small class="" style="color: red">
				Tamanho máximo: 2Mb.</small></label>
			<div class="col-sm-10">
				<input for="foto" type="hidden" name="MAX_FILE_SIZE" value="30720000" />
				<input type="file" class="form-control-file" name="foto" required/>
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
					FINALIZAR</button>
			</div>
		</div>
	
	</fieldset>
</form>


<hr style="border: 1px solid red">


<?php
	//MENSAGEM DELETADO COM SUCESSO
	if($_GET['deletado'] == 'ok'){
		echo 'REGISTRO DELETADO COM SUCESSO!';
		} else if($_GET['deletado'] == 'nok'){
		echo "ERROR: REGISTRO NÃO DELETADO.";
		} else{}

	//MENSAGEM DE ATUALIZADO COM SUCESSO
	// if($_GET['atualizado'] == "ok"){ 
	// 	echo "REGISTRO ATUALIZADO COM SUCESSO!";
	// 	}else if($_GET['atualizado'] == "nok"){
	// 	echo "ERROR: REGISTRO NÃO ATUALIZADO.";
	// 	}else{}
?>


<!-- SELECIONAR DO DB -->
<form class="form-inline" action="index.php" method="GET">
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-search"></i></span>
  <input class="form-control" type="text" name="input_valor" placeholder="O QUE VOCÊ PROCURA?">
</div>
  <button type="submit" class="btn btn-info">PESQUISAR</button>
</form>


<hr style="border-top: 1px dashed red">


<?php
	//PEGANDO VALOR DO CAMPO BUSCA
	$valor = utf8_decode($_GET['input_valor']);
	echo "<strong style='color: darkblue'>
		VOCÊ PESQUISOU POR: </strong>
		<strong style='text-transform: uppercase; color: red'>" 
		. utf8_encode($valor) . "</strong><br /><br />";

	//SELECIONAR
	$selecao = "SELECT * FROM tb_usuarios WHERE
	nome LIKE '".$valor."%' OR
	email LIKE '".$valor."%' OR
	observacao LIKE '%".$valor."%' OR
	foto LIKE '".$valor."%' OR
	data LIKE '".$valor."%' ORDER BY id desc";
?>


<table>
<?php
	$linhas = mysqli_query($conexao_db, $selecao);
	if($linhas):
		foreach ($linhas as $linha): ?>		
			<tr style="border: 3px solid #dddddd;">
				<td style="padding: 5px">
					<?php
						extract($linha);
						echo 'ID: '.$id.' - ';
						echo 'Auditor: <b style="text-transform: uppercase; color: blue;">'.utf8_encode($nome).'</b> - ';
						echo 'Data: <b>'.date('d-m-Y', strtotime($data)).'</b> - ';
						echo 'Setor Auditado: <b style="text-transform: uppercase; color: blue;">'.utf8_encode($email).'</b><br>';
						echo 'Ocorrência: <b style="text-transform: uppercase; color: red;">'.utf8_encode($observacao).'</b><br>';
						echo "<img src='fotos/".utf8_encode($foto)."' width='400'><br>";
					?>
				</td>
				<td style="padding: 5px">
					<?php
						echo "<img src='fotos/".utf8_encode($kaizen)."' width='400'><br>";
						echo 'Cometário: <b style="text-transform: uppercase; color: blue;">'.utf8_encode($comentario).'</b><br>';				
						echo 'Data: <b>'.date('d-m-Y', strtotime($data2)).'</b> - ';
						echo "<a href='editar_resposta.php?&id=".$id."'>INFORMAR KAIZEN </a>";
					?>
				</td>
			</tr>
				<?php
		endforeach;
	else:
		echo 'Erro ao buscar: '.mysqli_erro($conexao_db);
	endif;
?>
</table>

</body>
</html>
