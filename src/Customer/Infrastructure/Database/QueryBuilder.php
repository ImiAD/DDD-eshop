<?php
declare(strict_types=1);

namespace App\Customer\Infrastructure\Database;

class QueryBuilder
{
    private string $table;
    private array $fields = ['*'];
    private array $where = [];
    private array $params = [];
    private string $operand = '';
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

    public function select(...$item): static
    {
        if ($item) {
            $this->fields = (\count($item) !== \count($item, COUNT_RECURSIVE))
                ? \array_merge(...$item)
                : $item;
        }

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

    public function where(string $operand, array $condition, mixed ...$param): static
    {
        if (!$condition) {
            throw new \InvalidArgumentException('Недопустимый аргумент условия');
        }

        $this->params = (\count($param) !== \count($param, COUNT_RECURSIVE))
            ? \array_merge(...$param)
            : $param;
        $this->where[] = array_merge($condition, $this->params);

        if (!$operand) {
            throw new \InvalidArgumentException('Операнд нее передан!');
        }

        $this->operand = $operand;

        return $this;
    }

    // Нет ли тут логической ошибки?
    public function limit(int $limit = 0): static
    {
        $this->limit = $limit ?? $this->limit;

        return $this;
    }

    public function offset(int $offset = 0): static
    {
        $this->offset = $offset ?? $this->offset;

        return $this;
    }

    public function get()
    {
        $query = 'SELECT ' . \implode(', ', $this->fields);
        $query .= ' FROM ' . $this->table;

        if (!empty($this->where)) {
            $query .= ' WHERE ';
            $query .=  match (\mb_strtolower($this->operand)) {
                'and' => $this->andWhere(),
                'or' => $this->orWhere(),
                default => throw new \InvalidArgumentException('Что-то пошло не так c операндом!!!'),
            };
        }

        if (!empty($this->limit)) {
            $query .= ' LIMIT ' . $this->limit;
        }

        if (!empty($this->limit) && !empty($this->offset)) {
            $query .= ' OFFSET ' . $this->offset;
        }

        $sth = $this->dbh->prepare($query);
        $sth->execute($this->params);
//        return $sth->fetchAll();
        return $sth->fetchAll() ?: 'По вашему запросу ничего не найдено.';

        // А почему после return мы прописываем очистку полей, ведь return завершает выполнение функции?
        echo PHP_EOL;
        print_r($this->table);
        echo PHP_EOL;
        \print_r($this->fields);
        echo PHP_EOL;
        \print_r($this->where);
        echo PHP_EOL;
        echo $query;

        $this->table = '';
        $this->fields = [];
        $this->where = [];
        $this->limit = 0;
        $this->offset = 0;
        $this->params = [];
        $this->operand = '';

    }

    private function andWhere(): string
    {
        $q = '';

        foreach ($this->where as $item) {
            $q = " AND {$item[0]}{$item[1]}{$item[2]}";
        }

        return \ltrim($q, ' AND ');
    }

    private function orWhere(): string
    {
        $q = '';

        foreach ($this->where as $item) {
            $q = "{$item[0]}{$item[1]}{$item[2]} OR {$item[0]}{$item[1]}{$item[2]}";
        }

        return $q;
    }

}
