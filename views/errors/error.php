<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = 404;
}
$errors_desc = [
    100 => 'Continue',
    101 => 'Switching Protocols',
    102 => 'Processing', // WebDAV; RFC 2518
    103 => 'Early Hints', // RFC 8297
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information', // since HTTP/1.1
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content', // RFC 7233
    207 => 'Multi-Status', // WebDAV; RFC 4918
    208 => 'Already Reported', // WebDAV; RFC 5842
    226 => 'IM Used', // RFC 3229
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found', // Previously "Moved temporarily"
    303 => 'See Other', // since HTTP/1.1
    304 => 'Not Modified', // RFC 7232
    305 => 'Use Proxy', // since HTTP/1.1
    306 => 'Switch Proxy',
    307 => 'Temporary Redirect', // since HTTP/1.1
    308 => 'Permanent Redirect', // RFC 7538
    400 => 'Złe zapytanie',
    401 => 'Brak autoryzacji. Zaloguj się.', // RFC 7235
    402 => 'Payment Required',
    403 => 'Akcja zabroniona.',
    404 => 'Strona nie istnieje lub została usunięta.',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required', // RFC 7235
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed', // RFC 7232
    413 => 'Payload Too Large', // RFC 7231
    414 => 'URI Too Long', // RFC 7231
    415 => 'Unsupported Media Type', // RFC 7231
    416 => 'Range Not Satisfiable', // RFC 7233
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot', // RFC 2324, RFC 7168
    421 => 'Misdirected Request', // RFC 7540
    422 => 'Unprocessable Entity', // WebDAV; RFC 4918
    423 => 'Locked', // WebDAV; RFC 4918
    424 => 'Failed Dependency', // WebDAV; RFC 4918
    425 => 'Too Early', // RFC 8470
    426 => 'Upgrade Required',
    428 => 'Precondition Required', // RFC 6585
    429 => 'Too Many Requests', // RFC 6585
    431 => 'Request Header Fields Too Large', // RFC 6585
    451 => 'Unavailable For Legal Reasons', // RFC 7725
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates', // RFC 2295
    507 => 'Insufficient Storage', // WebDAV; RFC 4918
    508 => 'Loop Detected', // WebDAV; RFC 5842
    510 => 'Not Extended', // RFC 2774
    511 => 'Network Authentication Required', // RFC 6585
];
if (array_key_exists(intval($id), $errors_desc)) {
    $desc = $errors_desc[intval($id)];
} else {
    $id = 404;
    $desc = $errors_desc[$id];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Błąd <?= $id ?> - GetPet.pl </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        body {
            background-color: #f7f7f9;
            font-family: 'Open Sans';
        }

        .face {
            width: 300px;
            height: 300px;
            border: 4px solid #383a41;
            border-radius: 10px;
            background-color: #fff;
            margin: 0 auto;
            margin-top: 100px;
        }

        @media screen and (max-width: 400px) {
            .face {
                margin-top: 40px;
                transform: scale(0.8);
            }
        }

        .face .band {
            width: 350px;
            height: 27px;
            border: 4px solid #383a41;
            border-radius: 5px;
            margin-left: -25px;
            margin-top: 50px;
        }

        .face .band .red {
            height: calc(100% / 3);
            width: 100%;
            background-color: #eb6d6d;
        }

        .face .band .white {
            height: calc(100% / 3);
            width: 100%;
            background-color: #fff;
        }

        .face .band .blue {
            height: calc(100% / 3);
            width: 100%;
            background-color: #5e7fdc;
        }

        .face .band:before {
            content: "";
            display: inline-block;
            height: 27px;
            width: 30px;
            background-color: rgba(255, 255, 255, 0.3);
            position: absolute;
            z-index: 999;
        }



        .face .eyes {
            width: 128px;
            margin: 0 auto;
            margin-top: 40px;
        }

        .face .eyes:before {
            content: "";
            display: inline-block;
            width: 30px;
            height: 15px;
            border: 7px solid #383a41;
            margin-right: 20px;
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
            border-bottom: 0;
        }

        .face .eyes:after {
            content: "";
            display: inline-block;
            width: 30px;
            height: 15px;
            border: 7px solid #383a41;
            margin-left: 20px;
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
            border-bottom: 0;
        }

        .face .dimples {
            width: 180px;
            margin: 0 auto;
            margin-top: 15px;
        }

        .face .dimples:before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 80px;
            border-radius: 50%;
            background-color: rgba(235, 109, 109, 0.4);
        }

        .face .dimples:after {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-left: 80px;
            border-radius: 50%;
            background-color: rgba(235, 109, 109, 0.4);
        }

        .face .mouth {
            width: 40px;
            height: 5px;
            border-radius: 5px;
            background-color: #383a41;
            margin: 0 auto;
            margin-top: 25px;
        }

        h1 {
            font-weight: 800;
            color: #383a41;
            text-align: center;
            font-size: 2.5em;
            padding-top: 20px;
        }

        @media screen and (max-width: 400px) {
            h1 {
                padding-left: 20px;
                padding-right: 20px;
                font-size: 2em;
            }
        }

        .errorsection {
            padding-bottom: 100px;
        }
    </style>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
</head>

<body>
    <div class="errorsection">
        <div class="face">
            <div class="band">
                <div class="red"></div>
                <div class="white"></div>
                <div class="blue"></div>
            </div>
            <div class="eyes"></div>
            <div class="dimples"></div>
            <div class="mouth"></div>
        </div>
        <div class="text-center">
            <h1 class="text-danger">ERROR <?= $id ?></h1>
            <h3><?= $desc ?></h3>

            <a href="/">
                <div class="btn btn-primary btn-lg text-uppercase mt-3">Powrót na stronę główną</div>
            </a>
        </div>
    </div>

    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
</body>

</html>