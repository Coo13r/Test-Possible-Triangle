<?php

namespace Api;

use Codeception\Example;
use Codeception\Util\HttpCode;
use Step\Tester;
use Generator;

class TriangleIsPossibleCest
{
    /**
     * @param Tester $I
     * @param Example $provider
     *
     * @dataProvider dataProvider
     */
    public function testTriangleIsPossible(Tester $I, Example $provider): void
    {
        $I->sendTriangleSides($provider['sides']);
        $I->seeResponseCodeIs($provider['expectedCode']);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($provider['expectedMessage']);
    }

    protected function dataProvider(): Generator
    {
        // Testing possible triangles
        yield [
            'sides' => ['a'=>2, 'b'=>3, 'c'=>4],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => true],
        ];

        yield [
            'sides' => ['a'=>2, 'b'=>2, 'c'=>2],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => true],
        ];

        // Testing triangles with Zero in side
        yield [
            'sides' => ['a'=>10, 'b'=>10, 'c'=>10],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => true],
        ];

        yield [
            'sides' => ['a'=>15, 'b'=>18, 'c'=>20],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => true],
        ];

        // Testing triangles with (A+B) > C
        yield [
            'sides' => ['a'=>15, 'b'=>18, 'c'=>33],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => true],
        ];

        yield [
            'sides' => ['a'=>15, 'b'=>18, 'c'=>34],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => false],
        ];

        // Testing triangles with (A-B) < C
        yield [
            'sides' => ['a'=>19, 'b'=>7, 'c'=>12],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => false],
        ];
        yield [
            'sides' => ['a'=>19, 'b'=>7, 'c'=>13],
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ['isPossible' => true],
        ];

        // Testing triangles with not valid sides
        yield [
            'sides' => ['a'=>0, 'b'=>0, 'c'=>0],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];

        yield [
            'sides' => ['a'=>2, 'b'=>0, 'c'=>2],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];
        yield [
            'sides' => ['a'=>0, 'b'=>1, 'c'=>2],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];
        yield [
            'sides' => ['a'=>2, 'b'=>3, 'c'=>0],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];

        yield [
            'sides' => ['a'=>2, 'b'=>2, 'c'=>-1],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];

        yield [
            'sides' => ['a'=>2, 'b'=>2, 'c'=>'Q'],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];

        yield [
            'sides' => ['a'=>2, 'b'=>'', 'c'=>4],
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ['message' => ['error' => 'Not valid date']],
        ];
    }
}
