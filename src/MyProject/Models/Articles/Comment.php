<?php

namespace MyProject\Models\Articles;

use MyProject\Models\{
    Users\User,
    ActiveRecordEntity
};
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $userId;
    protected $articleId;
    protected $comment;
    protected $date;

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function setArticleId($articleId): void
    {
        $this->articleId = $articleId;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }

    public function isExistAvatar($id): ?string
    {
        $files = scandir(__DIR__ . '/../../../../files/userAvatar');
        foreach ($files as $file) {
            $number = explode('.', $file);
            if ((int) $number[0] == $id) {
                return $file;
            }
        }
        return null;
    }

    public static function findAllCommentForArticle(string $columnName, $value): ?array
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' 
            WHERE ' . $columnName . ' = :value ORDER BY id DESC LIMIT 10;',
            [':value' => $value],
            static::class
        );

        return $result ? $result : null;
    }

    public static function addComment($commentData, User $user, Article  $article)
    {

        if (empty($commentData['comment'])) {
            throw new InvalidArgumentException('Напишите комментарий');
        }

        $comment = new Comment();

        $comment->setArticleId($article->getId());
        $comment->setUserId($user->getId());
        $comment->setComment(nl2br(htmlentities($commentData['comment'])));
        $comment->setDate(date('Y-m-d H:i:s'));

        $comment->save();

        return $comment;
    }

    public function editComment($dataEditComment)
    {

        if (empty($dataEditComment['edit-comment'])) {
            $this->setComment($this->getComment());
        } else {
            $this->setComment($dataEditComment['edit-comment']);
        }

        $this->save();

        return $this;
    }
}
