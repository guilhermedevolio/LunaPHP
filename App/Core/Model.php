<?php

namespace Gui\Mvc\Core;

abstract class Model
{
    public string $query;
    public bool $first;
    public string $limit;
    public string $order;
    public string $offset;
    public $params;
    public array $data;

    public function __construct()
    {
        $this->first = false;
        $this->limit = " LIMIT 100";
        $this->order = " ORDER BY id DESC";
        $this->offset = 0;
        $this->data = [];
    }

    public function first()
    {
        $this->first = true;

        return $this;
    }

    public function limit(int $limit)
    {
        $this->limit = " LIMIT $limit";

        return $this;
    }

    public function order(string $columns, string $order)
    {
        $this->order = " ORDER BY $columns $order";

        return $this;
    }

    public function offset(int $offset)
    {
        $this->offset = " OFFSET {$offset}";

        return $this;
    }

    public function find(string $terms = null, string $params = null, string $columns = '*')
    {
        $this->query = "SELECT {$columns} FROM {$this->table} WHERE {$terms}";
        parse_str($params, $this->params);

        return $this;
    }

    public function all(string $columns = '*')
    {
        $this->query = "SELECT {$columns} FROM {$this->table}";

        return $this;
    }


    public function fetch()
    {

        $stmt = Database::connect()->prepare($this->query . $this->order . $this->limit . $this->offset);
        $stmt->execute($this->params);

        if (!$stmt->rowCount()) {
            return null;
        }

        if ($this->first) {
            $this->data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->protected();
        }

        $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->protected();
    }

    public function create(array $data)
    {
        $data_fillabled = $this->fillabled($data);

        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Database::connect()->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");
            $stmt->execute($data_fillabled);

            return $this->first()->find('id = :id', 'id=' . Database::connect()->lastInsertId())->fetch();
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public function update(array $data, string $terms, string $params): ?bool
    {
        try {
            $dateSet = [];

            foreach ($data as $bind => $value) {
                if (is_null($value)) {
                    unset($data[$bind]);
                }

                $dateSet[$bind] = "{$bind} = :{$bind}";

                if (!in_array($bind, $this->fillable)) {
                    unset($dateSet[$bind]);
                    unset($data[$bind]);
                }
            }


            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);


            $stmt = Database::connect()->prepare("UPDATE {$this->table} SET {$dateSet} WHERE {$terms}");
            $stmt->execute(array_merge($data, $params));
            return true;

        } catch (\PDOException $exception) {
            return false;
        }
    }

    public function delete(string $terms, string $params): bool
    {
        try {
            $stmt = Database::connect()->prepare("DELETE FROM {$this->table} WHERE {$terms}");
            if ($params) {
                parse_str($params, $params);
                $stmt->execute($params);
                return true;
            }

            $stmt->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    public function protected(): ?array
    {
        $protected = (array)$this->protected;

        if (isset($this->data[0])) {
            foreach ($this->data as $dataKey => $data) {
                foreach ($protected as $key => $unset) {
                    unset($this->data[$dataKey][$unset]);
                }
            }

            return $this->data;
        }

        foreach ($protected as $key => $unset) {
            unset($this->data[$unset]);
        }

        return $this->data;
    }

    public function fillabled(array $data): ?array
    {
        $dataFillabled = [];

        foreach ($this->fillable as $fillable) {
            if (!isset($data[$fillable])) {
                $data[$fillable] = null;
            }

            $dataFillabled[$fillable] = $data[$fillable];
        }

        return $dataFillabled;
    }

}
