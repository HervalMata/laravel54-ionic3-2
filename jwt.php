<?php

//um token composto de 3 partes

// 1 - header: Qual o tipo do token e algoritmo da assinatura
// 2 - payload(corpo do token): quem eh o emissor do token, expiracao, email,
// name
// 3 - assinatura: documento

//chave: composicao do header + payload

$cabecalho = [
    'alg' => 'HS256', // HMAC - criptografia sha256
    'typ' => 'JWT'
];

$corpoDaAplicacao = [
    'nome' => 'Carlos Anders',
    'email' => 'carlosanders@gmail.com',
    'role' => 'admin',
];

$cabecalho = json_encode($cabecalho);
$corpoDaAplicacao = json_encode($corpoDaAplicacao);

echo "Cabeçalho JSON: $cabecalho";
echo "\n";
echo "Corpo da informação JSON: $corpoDaAplicacao";
echo "\n\n";

$cabecalho = base64_encode($cabecalho);
$corpoDaAplicacao = base64_encode($corpoDaAplicacao);

echo "Cabeçalho Base64: $cabecalho";
echo "\n";
echo "Corpo da informação Base64: $corpoDaAplicacao";
echo "\n\n";

echo "Junção das 2 primeiras partes:\n";
echo "$cabecalho.$corpoDaAplicacao";
echo "\n\n";

$chave = "asdfsadfasdfasdfasdfasdfasdf";

$assinatura = hash_hmac(
    'sha256',
    "$cabecalho.$corpoDaAplicacao",
    $chave,
    true);

echo "Assinatura RAW: $assinatura";
echo "\n\n";
$assinatura = base64_encode($assinatura);
echo "Assinatura Base64: $assinatura";
echo "\nJWT: $cabecalho.$corpoDaAplicacao.$assinatura";