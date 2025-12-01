<?php
class GeminiController {

    private $apiKey = 'AIzaSyC3frBmw4eXsbiDesEcsCJ1UgBiYU-Dp9c';

    public function gerarBuild() {
        // Validação moderna do input
        $eqp = $_GET['equipamento'] ?? 'Espada Longa';
        $eqp = htmlspecialchars($eqp, ENT_QUOTES, 'UTF-8');
        
        $prompt = "A sua função é fazer uma build com o equipamento $eqp de Dark Souls 1.
        Você precisa retornar todos os outros itens da build e os status ideais do personagem.
        você precisa interpretar o personagem Chapolin Colorado para dar a resposta, quero apenas a resposta da build não precisa de nada muito além disso, 
        da uma interpretada no personagem para responder e tal, como essa resposta vem para um usuário, quero apenas que fale como se fosse ele, 
        não fique dizendo coisas do tipo 'certo vou interpretar o Chapolin e responder ao seu usuario', pois vai ficar ruim a experiencia do usuario se fizer isso, então
        apenas sugira a build interpretando o Chapolin Colorado.
        O retorno deve ser apenas um JSON como string, seguindo este formato:
        {
        \"equipamentoBase\": \"Espada Longa\",
        \"build\": {\"armas\": [], \"escudos\": [], \"armaduras\": [], \"anel\": []},
        \"statusPersonagem\": {\"nivel\": 80, \"forca\": 50, \"destreza\": 30, \"vitalidade\": 40, \"resistencia\": 35, \"inteligencia\": 10, \"fe\": 10}
        }";

        $corpo = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";
        $header = [
            "Content-Type: application/json",
            "x-goog-api-key: {$this->apiKey}"
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($corpo));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Fecha a conexão cURL (NÃO É DEPRECATED)
        curl_close($ch);

        if ($error) {
            echo json_encode(['erro' => 'Erro na requisição: ' . $error]);
            exit;
        }

        if ($httpCode !== 200) {
            echo json_encode(['erro' => 'Erro HTTP: ' . $httpCode]);
            exit;
        }

        $result = json_decode($response, true);

        $textoGerado = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Erro ao gerar resposta';

        echo json_encode(['texto' => $textoGerado]);
    }
}
