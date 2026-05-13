<?php

/**
 * Handles all user-related database operations for the application.
 */
class User
{
    /**
     * Creates a new user record and returns its database id.
     *
     * @return string|false
     */
    public static function createUser(
        PDO $connection,
        string $firstName,
        string $secondName,
        string $email,
        string $password,
        string $businessName,
        string $craftName,
        string $city,
        string $phone,
        string $facebook,
        string $description,
        string $role,
        string $status = "pending"
    ) {
        $sql = "INSERT INTO user (
                    first_name,
                    second_name,
                    email,
                    password,
                    business_name,
                    craft_name,
                    city,
                    phone,
                    facebook,
                    description,
                    status,
                    role
                )
                VALUES (
                    :first_name,
                    :second_name,
                    :email,
                    :password,
                    :business_name,
                    :craft_name,
                    :city,
                    :phone,
                    :facebook,
                    :description,
                    :status,
                    :role
                )";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":first_name", $firstName, PDO::PARAM_STR);
        $stmt->bindValue(":second_name", $secondName, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":business_name", $businessName, PDO::PARAM_STR);
        $stmt->bindValue(":craft_name", $craftName, PDO::PARAM_STR);
        $stmt->bindValue(":city", $city, PDO::PARAM_STR);
        $stmt->bindValue(":phone", $phone, PDO::PARAM_STR);
        $stmt->bindValue(":facebook", $facebook, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Používateľ nebol pridaný.");
            }

            return $connection->lastInsertId();
        } catch (Exception $exception) {
            error_log("Chyba pri funkcii createUser\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Verifies login credentials for the supplied email address.
     */
    public static function autentication(PDO $connection, string $loginEmail, string $loginPassword): bool
    {
        $sql = "SELECT password
                FROM user
                WHERE email = :email";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":email", $loginEmail, PDO::PARAM_STR);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Overenie bolo neúspešné.");
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? password_verify($loginPassword, $user["password"]) : false;
        } catch (Exception $exception) {
            error_log("Chyba pri funkcii autentication\n", 3, "../errors/error.log");
            echo "Typ chyby: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Finds a user id by email address.
     */
    public static function getUserId(PDO $connection, string $email): ?int
    {
        $sql = "SELECT id
                FROM user
                WHERE email = :email";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);

        try {
            if (!$stmt->execute()) {
                throw new Exception("ID používateľa sa nepodarilo získať.");
            }

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? (int) $result["id"] : null;
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii getUserId\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return null;
        }
    }

    /**
     * Returns the role for the selected user id.
     */
    public static function getUseRole(PDO $connection, int $id): ?string
    {
        $sql = "SELECT role
                FROM user
                WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Rolu používateľa sa nepodarilo získať.");
            }

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result["role"] ?? null;
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii getUseRole\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return null;
        }
    }

    /**
     * Returns one user row, optionally limited to selected columns.
     */
    public static function getUser(PDO $connection, int $id, string $columns = "*"): ?array
    {
        $sql = "SELECT {$columns}
                FROM user
                WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Používateľa sa nepodarilo načítať.");
            }

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii getUser\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return null;
        }
    }

    /**
     * Returns all users together with their selected profile image.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getAllUsers(PDO $connection, bool $includeAdmin = false): array
    {
        $sql = "SELECT u.id,
                       u.first_name,
                       u.second_name,
                       u.business_name,
                       u.craft_name,
                       u.city,
                       u.status,
                       u.role,
                       p.file_name AS profile_photo_name
                FROM user u
                LEFT JOIN photos p
                    ON p.user_id = u.id
                   AND p.is_profile = 1";

        if (!$includeAdmin) {
            $sql .= " WHERE u.role <> 'admin'";
        }

        $sql .= " ORDER BY u.id ASC";

        $stmt = $connection->prepare($sql);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Používateľov sa nepodarilo načítať.");
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii getAllUsers\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return [];
        }
    }

    /**
     * Returns only approved public craftsmen.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getApprovedUsers(PDO $connection): array
    {
        $sql = "SELECT u.id,
                       u.first_name,
                       u.second_name,
                       u.business_name,
                       u.craft_name,
                       u.city,
                       u.status,
                       p.file_name AS profile_photo_name
                FROM user u
                LEFT JOIN photos p
                    ON p.user_id = u.id
                   AND p.is_profile = 1
                WHERE u.role = 'user'
                  AND u.status = 'approved'
                ORDER BY u.id ASC";

        $stmt = $connection->prepare($sql);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Schválených používateľov sa nepodarilo načítať.");
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii getApprovedUsers\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return [];
        }
    }

    /**
     * Returns one approved public user profile.
     */
    public static function getApprovedUser(PDO $connection, int $id): ?array
    {
        $sql = "SELECT *
                FROM user
                WHERE id = :id
                  AND role = 'user'
                  AND status = 'approved'";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Schváleného používateľa sa nepodarilo načítať.");
            }

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii getApprovedUser\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return null;
        }
    }

    /**
     * Updates editable profile fields for one user.
     */
    public static function updateUser(
        PDO $connection,
        int $id,
        string $firstName,
        string $secondName,
        string $email,
        string $businessName,
        string $craftName,
        string $city,
        string $phone,
        string $facebook,
        string $description
    ): bool {
        $sql = "UPDATE user
                SET first_name = :first_name,
                    second_name = :second_name,
                    email = :email,
                    business_name = :business_name,
                    craft_name = :craft_name,
                    city = :city,
                    phone = :phone,
                    facebook = :facebook,
                    description = :description
                WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":first_name", $firstName, PDO::PARAM_STR);
        $stmt->bindValue(":second_name", $secondName, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":business_name", $businessName, PDO::PARAM_STR);
        $stmt->bindValue(":craft_name", $craftName, PDO::PARAM_STR);
        $stmt->bindValue(":city", $city, PDO::PARAM_STR);
        $stmt->bindValue(":phone", $phone, PDO::PARAM_STR);
        $stmt->bindValue(":facebook", $facebook, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Používateľa sa nepodarilo upraviť.");
            }

            return true;
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii updateUser\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Deletes one user account.
     */
    public static function deleteUser(PDO $connection, int $id): bool
    {
        $sql = "DELETE FROM user
                WHERE id = :id";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        try {
            if (!$stmt->execute()) {
                throw new Exception("Používateľa sa nepodarilo vymazať.");
            }

            return $stmt->rowCount() > 0;
        } catch (Exception $exception) {
            error_log("Chyba vo funkcii deleteUser\n", 3, "../errors/error.log");
            echo "Druh chyby: " . $exception->getMessage();
            return false;
        }
    }
}