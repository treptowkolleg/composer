<?php

namespace Core\Service;

class EncryptionService
{
// Konstante für Verschlüsselungsmethode
    const AES_256_CBC = 'aes-256-cbc';

    private string $_secret_key = 'gUkXp2s5v8y/B?E('; // hier einen sicheren Schlüssel einsetzen
    private string $_secret_iv  = 'u7x!A%D*G-KaPdSg'; // hier einen weiteren sicheren Schlüssel einsetzen
    private string $_encryption_key;
    private string $_iv;

    // im Konstruktor werden die Instanzvariablen initialisiert
    public function __construct()
    {
        $this->_encryption_key = hash('sha256', $this->_secret_key);
        $this->_iv             = substr(hash('sha256', $this->_secret_iv), 0, 16);
    }

    public function encryptString($data): string
    {
        return base64_encode(openssl_encrypt($data, self::AES_256_CBC, $this->_encryption_key, 0, $this->_iv));
    }

    public function decryptString($data): bool|string
    {
        return openssl_decrypt(base64_decode($data), self::AES_256_CBC, $this->_encryption_key, 0, $this->_iv);
    }

    public function setEncryptionKey($key): void
    {
        $this->_encryption_key = $key;
    }

    public function setInitVector($iv): void
    {
        $this->_iv = $iv;
    }
}