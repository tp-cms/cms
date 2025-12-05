<?php

namespace app\admin\trait;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

// github https://github.com/firebase/php-jwt


trait JWTTrait
{
    private string $secret;
    private string $alg = 'HS256';

    // 生成 jwt
    public function encodeJWT(array $payload, int $expires): string
    {
        $issuedAt = time();
        $expiresAt = $issuedAt + $expires;  // 计算过期时间

        $payload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expiresAt,
        ]);

        $secret = env('jwt.secret', 'tp-cms');
        return JWT::encode($payload, $secret, $this->alg);
    }

    // 解码 jwt
    public function decodeJWT(string $jwt): object
    {
        try {
            $secret = env('jwt.secret', 'tp-cms');
            return JWT::decode($jwt, new Key($secret, $this->alg));
        } catch (Exception $e) {
            throw new Exception("JWT 解码失败: " . $e->getMessage());
        }
    }

    // 验证 jwt
    public function validateJWT(string $jwt): bool
    {
        try {
            $secret = env('jwt.secret', 'tp-cms');
            JWT::decode($jwt, new Key($secret, $this->alg));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
