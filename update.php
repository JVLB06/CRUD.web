<?php
//Conectar a DB
$hostname = "localhost";
$db = "crud";
$user = "root";
$senha = "2006";

// Criação do objeto de conexão
$mysql = new mysqli($hostname, $user, $senha, $db);

// Condição para retornar erro de conexão com a DB
if ($mysql->connect_errno) {
    echo "Falha ao conectar: (" . $mysql->connect_errno . ") " . $mysql->connect_error;
}

// Obtém o ID do registro a ser editado (passado pela URL)
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'Não definido';
$sql = "SELECT * FROM basic";
$pesquisa = $mysql->query($sql);
if ($pesquisa->num_rows > 0) {
    while ($row = $pesquisa->fetch_assoc()) {
        if ($row['id'] === $id){
            $name = $result['nome'];
            $email = $result['email'];
            $nasce = $result['born'];
            $nasce = date($nasce);
            $job = $result['job'];
            $fone = $result['fone'];
            $celular = $result['celular'];
            $zap = $result['zap'] ?? '';
            $zap = boolval($zap);
            $sms = $result['sms'] ?? '';
            $sms = boolval($sms);
            $lmail = $result['libera_email'] ?? '';
            $lmail = boolval($lmail);
        }
    }
}
// Insere o comando
$sql = "UPDATE basic SET nome=?, nasce=?, email=?, job=?, fone=?, celular=?, zap=?, sms=?, email_livre=? WHERE id=?";
// Formata para o envio do comando
$stmt = $mysql->prepare($sql);
$stmt->bind_param("ssssssiiii", $name, $nasce, $email, $job, $fone, $celular, $zap, $sms, $lmail, $id);
// Executa o comando
$stmt->execute();
$stmt->close();
$mysql->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" type="text/css" href="update.css"/>
    <meta charset="UTF-8">
</head>
<body>
    <header>
        <div class="container">
            <a href="#" class="logo">
            <img src="logo1.png" alt="logo">
            </a>
            <nav>Editar Registro</nav>
            </a href="#">
            </div>
    </header>
    <form action="update.php" method="POST" class="form-container">
                <div class="form-group">
                    <label for="nome" class="form-label"><strong>Nome completo</strong></label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Letícia Pacheco dos Santos" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label"><strong>Email</strong></label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Ex: leticia@gmail.com" rquired>
                </div>
                <div class="form-group">
                    <label for="born" class="form-label"><strong>Data de nascimento</strong></label>
                    <input type="date" id="born" name="born" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="job" class="form-label"><strong>Profissão</strong></label>
                    <input type="text" id="job" name="job" class="form-control" placeholder="Ex: Desenvolvedor" required>
                </div>
                <div class="form-group">
                    <label for="fone" class="form-label"><strong>Telefone</strong></label>
                    <input type="text" id="fone" name="fone" class="form-control" placeholder="Ex: 41 98493 2039" required>
                </div>
                <div class="form-group">
                    <label for="celular" class="form-label"><strong>Celular</strong></label>
                    <input type="text" id="celular" name="celular" class="form-control" placeholder="Ex: 41 4033 2019" required>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="zap" name="zap" class="form-check-input">
                    <label class="form-check-label" for="zap">Número de celular tem Whatsapp</label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="sms" name="sms" class="form-check-input">
                    <label class="form-check-label" for="sms">Número de celular tem SMS</label>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="libera_email" name="libera_email" class="form-check-input">
                    <label class="form-check-label" for="libera_email">Enviar notificações por Email</label>
                </div>
                <div class="text-center">
                    <button type="submit" name="ação" value="cadastrar" class="btn btn-primary">Atualizar</button>
                </div>
        </form>
    </div>
</body>
</html>
