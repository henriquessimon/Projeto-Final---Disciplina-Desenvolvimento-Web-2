<?php
class GeminiController {

    private $apiKey = 'AIzaSyAMOERVxWCB5y2UEkPJDUMtdjJUbZQDX5E';

    public function gerarBuild() {
        // Validação moderna do input
        $eqp = $_GET['equipamento'] ?? 'Espada Longa';
        $eqp = htmlspecialchars($eqp, ENT_QUOTES, 'UTF-8');
        
        $prompt = "
        A sua função é criar uma build completa para Dark Souls 1 a partir do equipamento fornecido: $eqp.
        Você deve interpretar o personagem Chapolin Colorado, usando o estilo dele em todas as descrições.
        O retorno **deve ser apenas um JSON**, sem explicações adicionais, comentários, ou qualquer texto fora do JSON.
        O formato do JSON deve ser exatamente assim:

        {
            \"nome_build\": \"string\",
            \"equipamento\": {
                \"arma_principal\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"arma_secundaria\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"escudo\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"anel_1\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"anel_2\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"cabeca\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"peitoral\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"luvas\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"pernas\": { \"nome\": \"string\", \"descricao\": \"string\" },
                \"feitiços_piromancias\": [
                    { \"nome\": \"string\", \"descricao\": \"string\" },
                    { \"nome\": \"string\", \"descricao\": \"string\" }
                ]
            },
            \"status_ideais\": {
                \"nivel_inicial\": \"string\",
                \"vitalidade\": { \"valor\": numero, \"descricao\": \"string\" },
                \"memoria\": { \"valor\": numero, \"descricao\": \"string\" },
                \"resistencia\": { \"valor\": numero, \"descricao\": \"string\" },
                \"forca\": { \"valor\": numero, \"descricao\": \"string\" },
                \"destreza\": { \"valor\": numero, \"descricao\": \"string\" },
                \"resistencia_fisica\": { \"valor\": \"string\", \"descricao\": \"string\" },
                \"inteligencia\": { \"valor\": \"string\", \"descricao\": \"string\" },
                \"fe\": { \"valor\": \"string\", \"descricao\": \"string\" }
            }
        }

        **IMPORTANTE:** 
        - Não repita o prompt no JSON. 
        - Não adicione explicações. 
        - Tudo deve seguir o tom e estilo do Chapolin Colorado.
        - Sempre retorne **valores válidos** para cada campo, como números ou strings apropriadas.
        ";

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
