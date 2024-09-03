<?php
include "Visual.html";
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

// Receber informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['ação']) ? $_POST['ação'] : '';
    
    // Cadastrar informações
    if ($action === 'cadastrar') {
        // Recebe variáveis do HTML e formata
        $name = $_POST['nome'];
        $email = $_POST['email'];
        $nasce = $_POST['born'];
        $nasce = date($nasce);
        $job = $_POST['job'];
        $fone = $_POST['fone'];
        $celular = $_POST['celular'];
        $zap = $_POST['zap'] ?? '';
        $zap = boolval($zap);
        $sms = $_POST['sms'] ?? '';
        $sms = boolval($sms);
        $lmail = $_POST['libera_email'] ?? '';
        $lmail = boolval($lmail);
        // Insere o comando
        $sql = "INSERT INTO basic (nome, nasce, email, job, fone, celular, zap, sms, email_livre) VALUES (?,?,?,?,?,?,?,?,?)";
        // Formata para o envio do comando
        $stmt = $mysql->prepare($sql);
        $stmt->bind_param("ssssssiii", $name, $nasce, $email, $job, $fone, $celular, $zap, $sms, $lmail);
        // Executa o comando
        $stmt->execute();
    }

    // Deletar informações
    if (strpos($action, 'delete_') !== false) {
        $id = str_replace('delete_', '', $action);
        // Exclui o registro com o id correspondente
        $sql = "DELETE FROM basic WHERE id = ?";
        $stmt = $mysql->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    //Editar informações
    if (strpos($action, 'editar_' !== false)) {
        //Formulário de atualização
        $id = str_replace('editar_', '', $action);
    }
}
echo "<style>
/* Estilo geral da tabela */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: rgb(7,142,208);
    color: white;
}

/* Botões de ação */
.btn-primary {
    background-color: rgb(255,255,255);
    border: none;
    padding: 20px 20px;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    margin: 0 5px;
}

.btn-primary img {
    height: 14px;
    vertical-align: middle;
}

.btn-primary:hover {
    background-color: rgb(255,255,255);
}
</style>
";
// Recebe da DB
$sql = "SELECT * FROM basic";
$pesquisa = $mysql->query($sql);

if ($pesquisa->num_rows > 0) {
    // Cria a tabela e o cabeçalho
    echo "<table border='1' cellspacing='0' cellpadding='10'>";
    echo "<tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Nascimento</th>
            <th>Telefone</th>
            <th>Ações</th>
          </tr>";

    // Itera sobre os resultados e cria uma linha para cada registro
    while ($row = $pesquisa->fetch_assoc()) {
        $id = str_replace('editar_', '', $action);
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nasce']) . "</td>";
        echo "<td>" . htmlspecialchars($row['celular']) . "</td>";
        echo "<td>";
        echo "<form action='update.php' method='GET' style='display:inline;'>";
        echo "<input type='hidden' name='id' value='<?php echo htmlspecialchars($id); ?>''>";
        echo "<button type='submit' name='ação' value='editar_{$row['id']}' class='btn btn-primary'><img src='editar.png'></button>";
        echo "</form> ";
        echo "<form method='POST' style='display:inline;'>";
        echo "<button type='submit' name='ação' value='delete_{$row['id']}' class='btn btn-primary'><img src='excluir.png'><></button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>"; // Fecha a tabela
}
?>
