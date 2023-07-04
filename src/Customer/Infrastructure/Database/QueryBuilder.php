<?php
declare(strict_types=1);

namespace App\Customer\Infrastructure\Database;

class QueryBuilder
{
    private array $select = [];
    private string $table;
    private array $where = [
        'where' => [],
        'orWhere' => [],
    ];
    private int $limit;
    private int $offset = 0;
    private array $orderBy = [];
    private array $join = [];

    private \PDO $dbh;

    public function __construct()
    {
        try {
            $this->dbh = new \PDO(
                'mysql:host=localhost;dbname=db-tt;charset=utf8mb4',
                'root',
                '',
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
                ],
            );
        } catch (\PDOException $e) {
            dump($e->getMessage());
        }
    }

    // "кавычки" пока не понятно зачем этот метод нужен
    protected function quote(mixed $value): mixed
    {
        return $value;
    }

    public function select(array|string $columns = ['*']): static
    {
        $args = is_array($columns) ? $columns : func_get_args();
        $this->select = $args;

        return $this;
    }

    public function from(string $table): static
    {
        if (empty($table)) {
            throw new \InvalidArgumentException("Недопустимый аргумент {$table}");
        }

        $this->table = $table;

        return $this;
    }

    public function where($callable): static
    {
        if (is_callable($callable)) {
            $callable($this);
        } else {
            $args = is_array($callable) ? $callable : func_get_args();
            $this->addWhere($args);
        }

        return $this;
    }

//    public function orWhere(array|string $columns = []): static
//    {
//        $args = is_array($columns) ? $columns : func_get_args();
//
//        return $this;
//    }

    public function addWhere(string $key, array $args): void
    {
        $this->where[$key][] = [
            'column' => $args[0],
            'operator' => empty($args[2]) ? '=' : $args[1],
            'value' => $args[2] ?? $args[1],
        ];
    }

//    public function limit(int $limit = 0): static
//    {
//        $this->limit = $limit;
//
//        return $this;
//    }
//
//    public function offset(int $offset = 0): static
//    {
//        $this->offset = $offset;
//
//        return $this;
//    }

    public function get()
    {
        print_r($this->select);
        print_r($this->table);
        print_r($this->where);
    }
}
