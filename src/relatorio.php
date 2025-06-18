<!DOCTYPE html>
<html>
    <head>
        <title>Relatório de Cálculos</title>
        <link rel="stylesheet" href="style.css">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            
            th {
                background-color: #f2f2f2;
            }
            
            tr:hover {
                background-color: #f5f5f5;
            }
            
            .approved {
                color: green;
                font-weight: bold;
            }
            
            .failed {
                color: red;
                font-weight: bold;
            }
            
            .back-link {
                margin-top: 20px;
                display: block;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Relatório de Todos os Cálculos</h2>
            
            <?php
            // Importar configurações de banco de dados
            require_once 'config/database.php';
            
            // Buscar todos os cálculos do banco de dados
            $conn = conectarBD();
            if ($conn) {
                try {
                    $stmt = $conn->query("SELECT * FROM calculos ORDER BY data_hora_do_calculo DESC");
                    $calculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (count($calculos) > 0) {
                        echo "<table>";
                        echo "<tr>
                                <th>Data/Hora</th>
                                <th>Nota do Semestre</th>
                                <th>Nota da Prova Final</th>
                                <th>Nota Final</th>
                                <th>Situação</th>
                              </tr>";
                        
                        foreach ($calculos as $calculo) {
                            $statusClass = ($calculo['situacao'] == 'Aprovado') ? 'approved' : 'failed';
                            
                            echo "<tr>";
                            echo "<td>" . $calculo['data_hora_do_calculo'] . "</td>";
                            echo "<td>" . number_format($calculo['nota_semestre'], 1) . "</td>";
                            echo "<td>" . number_format($calculo['nota_prova_final'], 1) . "</td>";
                            echo "<td>" . number_format($calculo['nota_final'], 1) . "</td>";
                            echo "<td class='$statusClass'>" . $calculo['situacao'] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</table>";
                    } else {
                        echo "<p>Nenhum cálculo encontrado.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p class='error'>Erro ao buscar cálculos: " . $e->getMessage() . "</p>";
                }
                $conn = null;
            }
            ?>
            
            <a href="index.php" class="back-link">Voltar para Calculadora</a>
        </div>
    </body>
</html>