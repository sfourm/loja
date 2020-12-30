<?php 
@session_start();
include('../../conexao.php');

//$conn = $pdo;

//VERIFICAR SE USUÁRIO ESTÁ VERIFICADO
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";
    exit();
}

//LER AS TABELAS
$result_tabela = "SHOW TABLES";
$resultado_tabela = mysqli_query($conn, $result_tabela);
while($row_tabela = mysqli_fetch_row($resultado_tabela)){
    $tabelas[] = $row_tabela[0];
}
//var_dump($tabelas);

$result = "";
foreach($tabelas as $tabela){
    //PESQUISAR NOME DAS COLUNAS
    $result_colunas = "SELECT * FROM " . $tabela;
    $resultado_colunas = mysqli_query($conn, $result_colunas);
    $num_colunas = mysqli_num_fields($resultado_colunas);
    //echo "Quantidade de colunas na tabela: ". $tabela. " - " . $num_colunas . "<br>";
    
    //CRIAR INSTRUÇÃO PARA APAGAR A TABELA CASO A MESMA EXISTA NO BD
    $result .= 'DROP TABLE IF EXISTS '.$tabela.';';
    
    //PESQUISAR COMO A COLUNA É CRIADA
    $result_cr_col = "SHOW CREATE TABLE " . $tabela;
    $resultado_cr_col = mysqli_query($conn, $result_cr_col);
    $row_cr_col = mysqli_fetch_row($resultado_cr_col);
    //var_dump($row_cr_col);
    $result .= "\n\n" . $row_cr_col[1] . ";\n\n";
    //echo $result;
    
    //PERCORRER O ARRAY DAS COLUNAS
    for($i = 0; $i < $num_colunas; $i++){
        //LER O VALOR DE CADA COLUNA NO BANCO DE DADOS
        while($row_tp_col = mysqli_fetch_row($resultado_colunas)){
            //var_dump($row_tp_col);
            //CRIAR INSTRUÇÃO DA QUERY PARA INSERIR OS DADOS
            $result .= 'INSERT INTO ' . $tabela . ' VALUES(';
            
            //LER OS DADOS DA TABELA
            for($j = 0; $j < $num_colunas; $j++){
                //addslashes — ADICIONA AS BARRAS INVERTIDAS NA STRING
                $row_tp_col[$j] = addslashes($row_tp_col[$j]);
                //str_replace —  SUBSTITUI TODAS AS OCORRÊNCIAS DA STRING \n PELA \\n
                $row_tp_col[$j] = str_replace("\n", "\\n", $row_tp_col[$j]);
                
                if(isset($row_tp_col[$j])){
                    if(!empty($row_tp_col[$j])){
                        $result .= '"' . $row_tp_col[$j].'"';
                    }else{
                        $result .= 'NULL';
                    }
                }else{
                    $result .= 'NULL';
                }
                
                if($j < ($num_colunas - 1)){
                    $result .=',';
                }               
            }
            $result .= ");\n";
        }
    }
    $result .= "\n\n";
    //echo $result;
}

//CRIAR DIRETÓRIO BACKUP
$diretorio = 'backup/';
if(!is_dir($diretorio)){
    mkdir($diretorio, 0777, true);
    chmod($diretorio, 0777);
}

//NOME DO ARQUIVO BACKUP
$data = date('Y-m-d-h-i-s');
$nome_arquivo = $diretorio . "db_backup_".$data;
//echo $nome_arquivo;

$handle = fopen($nome_arquivo . '.sql', 'w+');
fwrite($handle, $result);
fclose($handle);

//MONTAGEM DO ARQUIVO BACKUP
$download = $nome_arquivo . ".sql";

//ADICIONAR HEADER PARA DOWNLOAD
if(file_exists($download)){
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=\"" . basename($download) . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($download));
    readfile($download);
    
    $_SESSION['msg'] = "<span style='color: green;'>Exportado BD com sucesso</span>";
}else{
    $_SESSION['msg'] = "<span style='color: red;'>Erro ao exportar o BD</span>";
}
?>