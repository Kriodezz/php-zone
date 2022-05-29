<?php

namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
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

    public function getComment()
    {
        return $this->comment;
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }

    public static function addComment($commentData, User $user, Article  $article)
    {

        if (empty($commentData['comment'])) {
            throw new InvalidArgumentException('Напишите комментарий');
        }

        $comment = new Comment();

        $comment->setArticleId($article->getId());
        $comment->setUserId($user->getId());
        $comment->setComment(htmlentities($commentData['comment']));
        $comment->setDate(date('Y-m-d H:i:s'));

        $comment->save();
    }

    public static function findAllCommentForArticle(string $columnName, $value): ?array
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' 
            WHERE ' . $columnName . ' = :value ORDER BY date DESC LIMIT 10;',
            [':value' => $value],
            static::class
        );

        return $result ? $result : null;
    }
}
