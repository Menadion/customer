<?php

function smtpReadResponseLine($socket) {
    $line = fgets($socket, 515);
    if ($line === false) {
        return false;
    }
    return rtrim($line, "\r\n");
}

function smtpReadResponse($socket, &$fullResponse) {
    $fullResponse = '';
    $lastLine = '';

    while (true) {
        $line = smtpReadResponseLine($socket);
        if ($line === false) {
            return false;
        }

        $fullResponse .= $line . "\n";
        $lastLine = $line;

        if (strlen($line) < 4) {
            break;
        }

        if (isset($line[3]) && $line[3] === ' ') {
            break;
        }
    }

    return $lastLine;
}

function smtpExpect($socket, $expectedCodes, &$error) {
    $response = '';
    $lastLine = smtpReadResponse($socket, $response);
    if ($lastLine === false) {
        $error = 'SMTP server did not respond.';
        return false;
    }

    $code = (int)substr($lastLine, 0, 3);
    if (!in_array($code, $expectedCodes, true)) {
        $error = 'SMTP error: ' . trim($response);
        return false;
    }

    return true;
}

function smtpSendCommand($socket, $command) {
    return fwrite($socket, $command . "\r\n") !== false;
}

function sendSmtpEmail($recipientEmail, $subject, $body, &$error = '') {
    $error = '';
    $configPath = __DIR__ . '/mail_config.php';

    if (!file_exists($configPath)) {
        $error = 'mail_config.php is missing';
        return false;
    }

    $config = include $configPath;
    $host = $config['host'] ?? '';
    $port = (int)($config['port'] ?? 587);
    $secure = strtolower((string)($config['secure'] ?? 'tls'));
    $username = (string)($config['username'] ?? '');
    $password = (string)($config['password'] ?? '');
    $fromEmail = (string)($config['from_email'] ?? '');
    $fromName = (string)($config['from_name'] ?? 'D.H AZADA TIRE SUPPLY');
    $timeout = (int)($config['timeout'] ?? 20);

    if ($host === '' || $username === '' || $password === '' || $fromEmail === '') {
        $error = 'SMTP config is incomplete';
        return false;
    }

    $transportHost = $host;
    if ($secure === 'ssl') {
        $transportHost = 'ssl://' . $host;
    }

    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
            'allow_self_signed' => false
        ]
    ]);

    $socket = @stream_socket_client(
        $transportHost . ':' . $port,
        $errno,
        $errstr,
        $timeout,
        STREAM_CLIENT_CONNECT,
        $context
    );

    if (!$socket) {
        $error = 'Could not connect to SMTP server: ' . $errstr;
        return false;
    }

    stream_set_timeout($socket, $timeout);

    if (!smtpExpect($socket, [220], $error)) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, 'EHLO localhost') || !smtpExpect($socket, [250], $error)) {
        fclose($socket);
        return false;
    }

    if ($secure === 'tls') {
        if (!smtpSendCommand($socket, 'STARTTLS') || !smtpExpect($socket, [220], $error)) {
            fclose($socket);
            return false;
        }

        $tlsEnabled = stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        if ($tlsEnabled !== true) {
            fclose($socket);
            $error = 'Failed to enable TLS encryption';
            return false;
        }

        if (!smtpSendCommand($socket, 'EHLO localhost') || !smtpExpect($socket, [250], $error)) {
            fclose($socket);
            return false;
        }
    }

    if (!smtpSendCommand($socket, 'AUTH LOGIN') || !smtpExpect($socket, [334], $error)) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, base64_encode($username)) || !smtpExpect($socket, [334], $error)) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, base64_encode($password)) || !smtpExpect($socket, [235], $error)) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, 'MAIL FROM:<' . $fromEmail . '>') || !smtpExpect($socket, [250], $error)) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, 'RCPT TO:<' . $recipientEmail . '>') || !smtpExpect($socket, [250, 251], $error)) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, 'DATA') || !smtpExpect($socket, [354], $error)) {
        fclose($socket);
        return false;
    }

    $headers = [];
    $headers[] = 'From: ' . $fromName . ' <' . $fromEmail . '>';
    $headers[] = 'To: <' . $recipientEmail . '>';
    $headers[] = 'Subject: ' . $subject;
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: text/plain; charset=UTF-8';
    $headers[] = 'Content-Transfer-Encoding: 8bit';
    $headers[] = '';

    $messageData = implode("\r\n", $headers) . "\r\n" . $body;
    $messageData = str_replace("\r\n.", "\r\n..", $messageData);

    if (fwrite($socket, $messageData . "\r\n.\r\n") === false || !smtpExpect($socket, [250], $error)) {
        fclose($socket);
        return false;
    }

    smtpSendCommand($socket, 'QUIT');
    fclose($socket);

    return true;
}

function sendVerificationEmail($recipientEmail, $verificationLink, &$error = '') {
    $subject = 'Verify your D.H Azada Tire Supply account';
    $body = "Hello,\r\n\r\nPlease verify your account by clicking the link below:\r\n" .
        $verificationLink .
        "\r\n\r\nIf you did not create this account, you can ignore this email.";

    return sendSmtpEmail($recipientEmail, $subject, $body, $error);
}

function sendPasswordResetEmail($recipientEmail, $resetLink, &$error = '') {
    $subject = 'Reset your D.H Azada Tire Supply password';
    $body = "Hello,\r\n\r\nWe received a request to reset your password.\r\n" .
        "Click this link to reset it:\r\n" .
        $resetLink .
        "\r\n\r\nThis link will expire in 1 hour.\r\n" .
        "If you did not request this, you can ignore this email.";

    return sendSmtpEmail($recipientEmail, $subject, $body, $error);
}
?>
