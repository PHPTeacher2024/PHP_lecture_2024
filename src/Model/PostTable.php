<?php
declare(strict_types=1);

require_once __DIR__ . '/Post.php';
require_once __DIR__ . '/PostInterface.php';

class PostTable
{
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private PDO $connection)
    {

    }

    public function add(PostInterface $post): int
    {
        $query = 'INSERT INTO post (title, subtitle, content) VALUES (:title, :subtitle, :content)';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':title' => $post->getTitle(),
            ':subtitle' => $post->getSubtitle(),
            ':content' => $post->getContent()
        ]);
        return (int)$this->connection->lastInsertId();
    }

    public function find(int $id): ?PostInterface
    {
        $query = "SELECT id, title, subtitle, content, posted_at  FROM post WHERE id = $id";
        $statement = $this->connection->query($query);
        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $this->createPostFromRow($row);
        }
        return null;
    }

    private function createPostFromRow(array $row): Post
    {
        return new Post(
            (int)$row['id'],
            $row['title'],
            $row['subtitle'],
            $row['content'],
            $this->parseDateTime($row['posted_at'])
        );
    }

    private function parseDateTime(string $value): DateTimeImmutable
    {
        $result = DateTimeImmutable::createFromFormat(self::MYSQL_DATETIME_FORMAT, $value);
        if (!$result)
        {
            throw new InvalidArgumentException("Invalid datetime value '$value'");
        }
        return $result;
    }

}