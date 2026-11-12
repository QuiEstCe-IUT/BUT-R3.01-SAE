<?php

namespace tests\phpunit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use src\models\BoardModel;

#[CoversClass(BoardModel::class)]
class BoardModelTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $board = new BoardModel();
        $this->assertNull($board->getGid());
        $this->assertNull($board->getP1());
        $this->assertNull($board->getP2());
        $this->assertSame(BoardModel::STATUS_LOBBY, $board->getGameStatus());
        $this->assertSame(1, $board->getPActive());
        $this->assertNull($board->getData());
        $this->assertNull($board->getPWinner());
    }

    public function testSettersAndGetters(): void
    {
        $board = new BoardModel();

        $board->setP1(10);
        $this->assertSame(10, $board->getP1());

        $board->setP2(20);
        $this->assertSame(20, $board->getP2());

        $board->setGameStatus(BoardModel::STATUS_IN_PROGRESS);
        $this->assertSame(BoardModel::STATUS_IN_PROGRESS, $board->getGameStatus());

        $board->setPActive(2);
        $this->assertSame(2, $board->getPActive());

        $board->setData("Est-ce qu'il a des lunettes ?");
        $this->assertSame("Est-ce qu'il a des lunettes ?", $board->getData());

        $board->setPWinner(10);
        $this->assertSame(10, $board->getPWinner());
    }

    public function testPActiveValidationThrowsException(): void
    {
        $board = new BoardModel();
        $this->expectException(InvalidArgumentException::class);
        $board->setPActive(3);
    }

    public function testHydrate(): void
    {
        $row = [
            'gid'         => 42,
            'p1'          => 1,
            'p2'          => 2,
            'game_status' => BoardModel::STATUS_IN_PROGRESS,
            'p_active'    => 2,
            'data'        => 'Dernière réponse : Oui',
            'p_winner'    => null,
        ];

        $board = BoardModel::hydrate($row);

        $this->assertSame(42, $board->getGid());
        $this->assertSame(1, $board->getP1());
        $this->assertSame(2, $board->getP2());
        $this->assertSame(BoardModel::STATUS_IN_PROGRESS, $board->getGameStatus());
        $this->assertSame(2, $board->getPActive());
        $this->assertSame('Dernière réponse : Oui', $board->getData());
        $this->assertNull($board->getPWinner());
    }
}
