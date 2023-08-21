<?php
  try {
    require_once("config.php");
  } catch (Exception $e) {
    echo $e;
  }
  
  //FUNÇÕES QUE O CÓDIGO PERMITE REALIZAR
  // $produto1 = new Produtos();
  // echo $produto1->postProduto("Smartphone","https:/google.com");
  // echo Produtos::getProdutoById(19);
  // echo Produtos::getProdutos();
  // echo $produto1->putThisProduto("Fone de ouvido","ttt",1);
  // echo Produtos::putProdutoById(9,"Troca","llll",1);
  // echo Produtos::deleteProduto(19);
  // echo $produto1;

  function createTr(){
    $produtos = json_decode(Produtos::getProdutos(),true);
    $response = "";
    foreach ($produtos as $produto) {
      $response .=
      '<tr>
        <td>'. $produto["nome"]. '</td>
        <td><a href='. $produto["link"]. 'target="_blank">'. $produto["link"].'</a></td>
        <td>'. $produto["data_adicao"] . '</td>
        <td>
            <a href="editar_produto.php?id=1">Editar</a> |
            <button onclick="excluirProduto(1)">Excluir</button>
        </td>
      </tr>';
    };
    return $response;
  }
  $response = createTr();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de desejos</title>
</head>
<body>
  <h1>Lista de desejos</h1>
  <table border="1" id="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Link</th>
                <th>Data de Adição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="bodyTable">
        <?php echo $response; ?>
        </tbody>
    </table>
</body>
</html>

