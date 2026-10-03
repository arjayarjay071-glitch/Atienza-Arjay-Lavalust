<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * AuthController
 * Login, Register, Logout, Refresh token (JWT) gamit ang LavaLust Api library.
 */
class ApiAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    // POST /api/register
    public function register()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();

        $username = trim($input['username'] ?? '');
        $email    = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            $this->api->respond_error('username, email at password ay required.', 422);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('Hindi valid ang email.', 422);
        }
        if (strlen($password) < 6) {
            $this->api->respond_error('Dapat at least 6 characters ang password.', 422);
        }

        $stmt = $this->db->raw(
            'SELECT id FROM users WHERE username = ? OR email = ?',
            [$username, $email]
        );
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->api->respond_error('Existing na ang username o email.', 409);
        }

        $this->db->raw(
            'INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())',
            [$username, $email, password_hash($password, PASSWORD_BCRYPT), 'user']
        );

        $this->api->respond(['message' => 'User created'], 201);
    }

    // POST /api/login
    public function login()
    {
        $this->api->require_method('POST');
        $input    = $this->api->body();
        $username = trim($input['username'] ?? '');
        $password = $input['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->api->respond_error('Ilagay ang username at password.', 422);
        }

        $stmt = $this->db->raw('SELECT * FROM users WHERE username = ?', [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $tokens = $this->api->issue_tokens([
                'id'   => $user['id'],
                'role' => $user['role'],
            ]);
            $this->api->respond($tokens);
        }

        $this->api->respond_error('Invalid credentials', 401);
    }

    // POST /api/logout
    public function logout()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();
        $this->api->revoke_refresh_token($input['refresh_token'] ?? '');
        $this->api->respond(['message' => 'Logged out']);
    }

    // POST /api/refresh
    public function refresh()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();
        $this->api->refresh_access_token($input['refresh_token'] ?? '');
    }
}