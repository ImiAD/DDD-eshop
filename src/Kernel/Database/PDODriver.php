<?php
declare(strict_types=1);

namespace App\Kernel\Database;

class PDODriver
{
    private static ?PDODriver $instance = null;
    private ?object $dbh = null;
    private ?object $sth = null;

    private function __construct()
    {
        try {
            $this->dbh = new \PDO(
                'mysql:host=localhost;dbname=db-eshop;charset=utf8mb4',
                'root',
                '',
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
                ]
            );
        } catch (\PDOException $e) {
            throw new \PDOException("Internal server error: {$e->getMessage()}");
        }
    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function prepare(string $query): object
    {
        $this->sth = $this->dbh->prepare($query);

        return $this;
    }

    public function query(string $query)
    {
        return $this->dbh->query($query);
    }

    public function exec(string $query)
    {
        return $this->dbh->exec($query);
    }

    public function execute(array $binds = []): object
    {
        $this->sth->execute($binds);

        return $this;
    }

    public function fetch()
    {
        $result = $this->sth->fetch();
        $this->sth = null;

        return $result;
    }

    public function fetchAll()
    {
        $result = $this->sth->fetchAll();
        $this->sth = null;

        return $result;
    }

    public function lastInsertId(): int
    {
        return (int)$this->dbh->lastInsertId();
    }

    public function rowCount(): int
    {
        return (int)$this->sth->rowCount();
    }
}
