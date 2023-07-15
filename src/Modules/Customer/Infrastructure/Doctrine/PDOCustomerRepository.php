<?php
declare(strict_types=1);

namespace App\Modules\Customer\Infrastructure\Doctrine;

use App\Kernel\Database\PDODriver;
use App\Modules\Customer\Contracts\CustomerRepository;
use App\Modules\Customer\Domain\Model\Entities\Customer;
use App\Modules\Customer\Domain\Model\ValueObjects\CustomerId;

class PDOCustomerRepository implements CustomerRepository
{
    private ?PDODriver $driver;

    public function __construct(?PDODriver $driver)
    {
        $this->driver = $driver;
    }

    public function byId(CustomerId $customerId): array
    {
        $sth = $this->driver->prepare('SELECT * FROM customer WHERE customer_id=:customer_id LIMIT 1');
        $sth->execute([':customer_id' => $customerId->getId()]);
        $result = $sth->fetch();

        return $result !== false ? $result : [];
    }

    public function all(): array
    {
        $sth = $this->driver->prepare(
            'SELECT *
            FROM customer
            JOIN address ON (address.customer_id = customer.customer_id)
            JOIN phone ON (phone.customer_id = customer.customer_id)'
        );
        $sth->execute();

        return $sth->fetchAll() ?: [];
    }

    public function create(Customer $customer): bool
    {
        $sth = $this->driver->prepare(
      'INSERT customer (customer_id, first_name, last_name, middle_name, status, created_at, updated_at)
             VALUES (:customer_id, :first_name, :last_name, :middle_name, :status, :created_at, :updated_at)'
        );
        $sth->execute([
            ':customer_id' => $customer->getId()->getId(),
            ':first_name' => $customer->getName()->getFirstName(),
            ':last_name' => $customer->getName()->getLastName(),
            ':middle_name' => $customer->getName()->getMiddleName(),
            ':status' => $customer->isActive(),
            ':created_at' => $customer->getCreateAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $customer->getUpdatedAt()->format('Y-m-d H:i:s'),
        ]);

        $result = (bool)$this->driver->lastInsertId();

        if ($result) {
            $customerId = $customer->getId()->getId();
            $sth = $this->driver->prepare(
             'INSERT address (customer_id, country, region, city, street, house)
                    VALUES (:customer_id, :country, :region, :city, :street, :house)'
            );
            $sth->execute([
                ':customer_id' => $customerId,
                ':country' => $customer->getAddress()->getCountry(),
                ':region' => $customer->getAddress()->getRegion(),
                ':city' => $customer->getAddress()->getCity(),
                ':street' => $customer->getAddress()->getStreet(),
                ':house' => $customer->getAddress()->getHouse(),
            ]);
            array_map(function ($phone) use ($customerId) {
                $sth = $this->driver->prepare(
                    'INSERT phone (customer_id, country, code, number)
                           VALUES (:customer_id, :country, :code, :number)'
                );
                $sth->execute([
                    ':customer_id' => $customerId,
                    ':country' => $phone->getCountry(),
                    ':code' => $phone->getCode(),
                    ':number' => $phone->getNumber(),
                ]);
            }, $customer->getPhones());
        }

        return $result;
    }

    public function update(string $customerId, Customer $customer): bool
    {
        $sth = $this->driver->prepare(
            'UPDATE customer
            SET first_name=:first_name,
                last_name=:last_name,
                middle_name=:middle_name,
                status=:status,
                updated_at=:updated_at
            WHERE customer_id=:customer_id'
        );
        $sth->execute([
            ':first_name' => $customer->getName()->getFirstName(),
            ':last_name' => $customer->getName()->getLastName(),
            ':middle_name' => $customer->getName()->getMiddleName(),
            ':status' => $customer->isActive(),
            ':updated_at' => $customer->getUpdatedAt()->format('Y-m-d H:i:s'),
            ':customer_id' => $customerId,
        ]);

        $result = (bool)$this->driver->rowCount();

//        if ($result) {
//            $sth = $this->driver->prepare(
//                'UPDATE address
//                   SET country=:country, region=:region, city=:city, street=:street, house=:house
//                   WHERE customer_id=:customer_id'
//            );
//            $sth->execute([
//                ':country' => $customer->getAddress()->getCountry(),
//                ':region' => $customer->getAddress()->getRegion(),
//                ':city' => $customer->getAddress()->getCity(),
//                ':street' => $customer->getAddress()->getStreet(),
//                ':house' => $customer->getAddress()->getHouse(),
//                ':customer_id' => $customerId,
//            ]);
//            array_map(function ($phone) use ($customerId) {
//                $sth = $this->driver->prepare(
//                    'UPDATE phone
//                    SET country=:country, code=:code, number=:number
//                    WHERE customer_id=:customer_id'
//                );
//                $sth->execute([
//                    ':country' => $phone->getCountry(),
//                    ':code' => $phone->getCode(),
//                    ':number' => $phone->getNumber(),
//                    ':customer_id' => $customerId,
//                ]);
//            }, $customer->getPhones());
//        }

        return $result;
    }

    public function remove(Customer $customer): void
    {
        $sth = $this->driver->prepare(
            'DELETE FROM customer, address, phone
            USING customer INNER JOIN address INNER JOIN phone
            WHERE customer.customer_id=address.customer_id
            AND address.customer_id=phone.customer_id
            AND customer.customer_id=:customer_id'
        );
        $sth->execute([':customer_id' => $customer->getId()->getId()]);
    }
}
