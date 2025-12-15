<?php
session_start();

if (!isset($_SESSION["historico"])) {
    $_SESSION["historico"] = [];
}

$data = [];
$webhook = "https://mathiasdev.app.n8n.cloud/webhook/2a07c8ae-5be5-40c4-9f11-2c64caad0acc";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["acao"]) && $_POST["acao"] === "limpar") {
        $_SESSION["historico"] = [];
        header("Location: ../index.php");
        exit;
    }

    $json_data = file_get_contents("php://input");
    $data_json = json_decode($json_data, true);

    if (isset($data_json)) {
        array_push($_SESSION["historico"], $data_json);
    } else {
        $data = $_POST;
        $user_message = $data["prompt"];
        $user_historico = [
            "role" => "user",
            "message" => $user_message
        ];
        array_push($_SESSION["historico"], $user_historico);
        $ch = curl_init($webhook);

        $request_data = ["prompt" => $user_message];
        $payload = json_encode($request_data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                "Content-Type: application/json",
                "Content-Length: " . strlen($payload)
            ]
        );

        $response = curl_exec($ch);

        if ($response !== false) {
            $response_data = json_decode($response, true);

            // Se for um array válido (JSON), usa ele
            if ($response_data && is_array($response_data)) {
                $_SESSION["historico"][] = $response_data;
            } else {
                // Se não for JSON, cria o array manualmente
                $_SESSION["historico"][] = [
                    "role" => "assistant",
                    "message" => $response
                ];
            }
        }

        curl_close($ch);
    }
    header("Location: ../index.php");
    exit;
}





