<?php

/**
 * Provides photo-related database and filesystem helpers.
 */
class Image
{
    /**
     * Removes database records that point to files missing from disk.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function filterValidImages(int $userId, array $images): array
    {
        $validImages = [];

        foreach ($images as $image) {
            if (empty($image["file_name"])) {
                continue;
            }

            $imagePath = __DIR__ . "/../uploads/{$userId}/{$image['file_name']}";

            if (!file_exists($imagePath)) {
                continue;
            }

            $validImages[] = $image;
        }

        return $validImages;
    }

    /**
     * Stores a newly uploaded image record.
     */
    public static function insertImage(PDO $connection, int $userId, string $imageName): bool
    {
        $sql = "INSERT INTO photos (user_id, file_name)
                VALUES (:user_id, :image_name)";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":image_name", $imageName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Returns all valid images for a user, newest first.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getImagesByUserId(PDO $connection, int $userId): array
    {
        $sql = "SELECT id, file_name, is_profile
                FROM photos
                WHERE user_id = :user_id
                ORDER BY id DESC";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();

        return self::filterValidImages($userId, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Returns the current profile image or null when none is set.
     */
    public static function getProfileImageByUserId(PDO $connection, int $userId): ?array
    {
        $sql = "SELECT id, file_name, is_profile
                FROM photos
                WHERE user_id = :user_id
                  AND is_profile = 1
                LIMIT 1";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();

        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$image) {
            return null;
        }

        $validImages = self::filterValidImages($userId, [$image]);

        return $validImages[0] ?? null;
    }

    /**
     * Marks one image as the active profile photo and resets the others.
     */
    public static function setProfileImage(PDO $connection, int $userId, int $imageId): bool
    {
        try {
            $resetSql = "UPDATE photos
                         SET is_profile = 0
                         WHERE user_id = :user_id";
            $resetStmt = $connection->prepare($resetSql);
            $resetStmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
            $resetStmt->execute();

            $setSql = "UPDATE photos
                       SET is_profile = 1
                       WHERE id = :image_id
                         AND user_id = :user_id";
            $setStmt = $connection->prepare($setSql);
            $setStmt->bindValue(":image_id", $imageId, PDO::PARAM_INT);
            $setStmt->bindValue(":user_id", $userId, PDO::PARAM_INT);

            return $setStmt->execute();
        } catch (Exception $exception) {
            echo "Chyba: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Deletes an image file from disk.
     */
    public static function deletePhotoFromDirectory(string $path): bool
    {
        try {
            if (!file_exists($path)) {
                throw new Exception("Súbor neexistuje.");
            }

            if (!unlink($path)) {
                throw new Exception("Pri vymazávaní došlo k chybe.");
            }

            return true;
        } catch (Exception $exception) {
            echo "Chyba: " . $exception->getMessage();
            return false;
        }
    }

    /**
     * Deletes one image record for the selected user.
     */
    public static function deletePhotoFromDatabase(PDO $connection, string $imageName, int $userId): bool
    {
        $sql = "DELETE FROM photos
                WHERE file_name = :image_name
                  AND user_id = :user_id";

        $stmt = $connection->prepare($sql);

        try {
            $stmt->bindValue(":image_name", $imageName, PDO::PARAM_STR);
            $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception("Obrázok sa nepodarilo vymazať.");
            }

            return true;
        } catch (Exception $exception) {
            echo "Chyba: " . $exception->getMessage();
            return false;
        }
    }
}