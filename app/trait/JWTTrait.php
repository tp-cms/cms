<?php

namespace app\trait;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

// github https://github.com/firebase/php-jwt

// 密钥生成
// 1.
// $randomString = bin2hex(random_bytes(16)); // 16 字节 = 32 个字符
// 2.
// $randomString = bin2hex(openssl_random_pseudo_bytes(16)); // 16 字节 = 32 个字符
// 3.
// $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// $randomString = substr(str_shuffle($characters), 0, 32);
// 4.
// $randomString = md5(uniqid(mt_rand(), true)); // 生成 32 字符长的字符串

trait JWTTrait
{
    private string $secret;
    private string $alg = 'HS256';

    // 生成 jwt
    public function encodeJWT(array $payload, int $expires): ?string
    {
        $issuedAt = time();
        $expiresAt = $issuedAt + $expires;  // 计算过期时间

        $payload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expiresAt,
        ]);

        $secret = env('jwt.secret', '');
        if (strlen($secret) < 32) {
            return null;
        }
        return JWT::encode($payload, $secret, $this->alg);
    }

    // 解码 jwt
    public function decodeJWT(string $jwt): ?object
    {
        try {
            $secret = env('jwt.secret', '');
            if (strlen($secret) < 32) {
                return null;
            }
            return JWT::decode($jwt, new Key($secret, $this->alg));
        } catch (Exception $e) {
            return null;
        }
    }

    // 验证 jwt
    public function validateJWT(string $jwt): bool
    {
        try {
            $secret = env('jwt.secret', '');
            if (strlen($secret) < 32) {
                throw new Exception("密钥最短为32字符");
            }
            JWT::decode($jwt, new Key($secret, $this->alg));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
