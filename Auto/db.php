<?php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'car_db';
$DB_PORT = 3306;

class JsonResult
{
    public $num_rows;
    private $rows;
    private $index = 0;

    public function __construct(array $rows = [])
    {
        $this->rows = $rows;
        $this->num_rows = count($rows);
    }

    public function fetch_assoc()
    {
        if ($this->index >= count($this->rows)) {
            return null;
        }

        $row = $this->rows[$this->index];
        $this->index++;
        return $row;
    }
}

class JsonStatement
{
    private $connection;
    private $sql;
    private $params = [];
    private $result;
    public $insert_id = 0;

    public function __construct($connection, $sql)
    {
        $this->connection = $connection;
        $this->sql = trim($sql);
    }

    public function bind_param($types, &...$values)
    {
        $this->params = $values;
        return true;
    }

    public function execute()
    {
        $sql = strtolower($this->sql);

        if (strpos($sql, 'select id, fullname, email, password_hash from users where email = ?') !== false || strpos($sql, 'select id from users where email = ?') !== false) {
            $email = $this->params[0] ?? '';
            $user = $this->connection->findUserByEmail($email);
            $this->result = new JsonResult($user ? [$user] : []);
            return true;
        }

        if (strpos($sql, 'insert into users') !== false) {
            $newUser = [
                'fullname' => $this->params[0] ?? '',
                'email' => $this->params[1] ?? '',
                'phone' => $this->params[2] ?? '',
                'password_hash' => $this->params[3] ?? '',
            ];
            $this->insert_id = $this->connection->insertUser($newUser);
            $this->result = new JsonResult();
            return true;
        }

        $this->result = new JsonResult();
        return true;
    }

    public function get_result()
    {
        return $this->result;
    }
}

class JsonUserConnection
{
    private $storeFile;
    private $users = [];

    public function __construct()
    {
        $this->storeFile = __DIR__ . '/data/users.json';
        $this->ensureStore();
        $this->users = $this->loadUsers();
    }

    public function prepare($sql)
    {
        return new JsonStatement($this, $sql);
    }

    public function query($sql)
    {
        return true;
    }

    public function set_charset($charset)
    {
        return true;
    }

    public function select_db($db)
    {
        return true;
    }

    public function real_escape_string($value)
    {
        return str_replace(["\\", "'"], ["\\\\", "\\'"], $value);
    }

    public function findUserByEmail($email)
    {
        foreach ($this->users as $user) {
            if (($user['email'] ?? '') === $email) {
                return [
                    'id' => $user['id'],
                    'fullname' => $user['fullname'],
                    'email' => $user['email'],
                    'password_hash' => $user['password_hash'],
                ];
            }
        }

        return null;
    }

    public function insertUser(array $userData)
    {
        $this->users = $this->loadUsers();
        $nextId = 1;

        foreach ($this->users as $existingUser) {
            if (($existingUser['id'] ?? 0) >= $nextId) {
                $nextId = (int) $existingUser['id'] + 1;
            }
        }

        $user = [
            'id' => $nextId,
            'fullname' => $userData['fullname'] ?? '',
            'email' => $userData['email'] ?? '',
            'phone' => $userData['phone'] ?? '',
            'password_hash' => $userData['password_hash'] ?? '',
        ];

        $this->users[] = $user;
        $this->saveUsers();
        return $nextId;
    }

    public function ensureStore()
    {
        if (!is_dir(__DIR__ . '/data')) {
            mkdir(__DIR__ . '/data', 0777, true);
        }

        if (!file_exists($this->storeFile)) {
            file_put_contents($this->storeFile, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    private function loadUsers()
    {
        $content = file_get_contents($this->storeFile);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    private function saveUsers()
    {
        file_put_contents($this->storeFile, json_encode($this->users, JSON_PRETTY_PRINT));
    }
}

function getDbConnection()
{
    static $connection = null;

    if ($connection !== null) {
        return $connection;
    }

    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $connection = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS'], '', $GLOBALS['DB_PORT']);
        $connection->query("CREATE DATABASE IF NOT EXISTS `" . $connection->real_escape_string($GLOBALS['DB_NAME']) . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $connection->select_db($GLOBALS['DB_NAME']);
        $connection->set_charset('utf8mb4');
        return $connection;
    } catch (Throwable $e) {
        $connection = new JsonUserConnection();
        return $connection;
    }
}
