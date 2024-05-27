	<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
	</head>
	</body>
		<?php
			include_once("../../controllers/conexaoimg.php");

			session_start();

			if(isset($_SESSION['email'])) {
				$email = $_SESSION['email'];
			} else {
				$email = "usuário";
			}
			



				
			$arquivo 	= $_FILES['arquivo']['name'];
			
			//Pasta onde o arquivo vai ser salvo
			$_UP['pasta'] = 'foto/';
			
			//Tamanho máximo do arquivo em Bytes
			$_UP['tamanho'] = 1024*1024*100; //5mb
			
			//Array com a extensões permitidas
			$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
			
			//Renomeiar
			$_UP['renomeia'] = false;
			
			//Array com os tipos de erros de upload do PHP
			$_UP['erros'][0] = 'Não houve erro';
			$_UP['erros'][1] = 'O arquivo no upload é maior que o limite do PHP';
			$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
			$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
			$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
			
			//Verifica se houve algum erro com o upload. Sem sim, exibe a mensagem do erro
			if($_FILES['arquivo']['error'] != 0){
				die("Não foi possivel fazer o upload, erro: <br />". $_UP['erros'][$_FILES['arquivo']['error']]);
				exit; //Para a execução do script
			}
			
			//Faz a verificação da extensao do arquivo
	
			
			//Faz a verificação do tamanho do arquivo
			else if ($_UP['tamanho'] < $_FILES['arquivo']['size']){
				echo "
					<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/ArenaRental/land/page1.php'>
					<script type=\"text/javascript\">
						alert(\"Arquivo muito grande.\");
					</script>
				";
			}
			
			//O arquivo passou em todas as verificações, hora de tentar move-lo para a pasta foto
		
				//Primeiro verifica se deve trocar o nome do arquivo
			else{
					//mantem o nome original do arquivo
					$nome_final = $_FILES['arquivo']['name'];
				}

				//Verificar se é possivel mover o arquivo para a pasta escolhida

				$query_delete = mysqli_query($conn, "DELETE FROM imagem WHERE email_user = '$email'");


				if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta']. $nome_final)){

		
					$query = mysqli_query($conn, "INSERT INTO imagem (
						nome_imagem, email_user) VALUES('$nome_final', '$email')");
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/ArenaRental/views/html/tela1.php'>
						<script type=\"text/javascript\">
							alert(\"Imagem de perfil alterada com sucesso.\");
						</script>
					";	
					
				}else{
					//Upload não efetuado com sucesso, exibe a mensagem
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/ArenaRental/views/html/tela1.php'>
						<script type=\"text/javascript\">
							alert(\"Imagem não foi cadastrada com Sucesso.\");
						</script>
					";
				}
			
			
			
		?>
		
	</body>
</html>