<?php declare(strict_types=1);

namespace F5\CatFacts\Test\Unit;
use F5\CatFacts\Block\CatFact;
use F5\CatFacts\Api\CatFactsApi;
use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\TestCase;

class CatFactTest extends TestCase
{
    /**
     * @var CatFactsApi
     */
    private $catFactsApiStub;

    /**
     * @var Context|\PHPUnit\Framework\MockObject\MockObject
     */
    private $contextMock;

    /**
     * @var CatFact
     */
    private $catFactBlock;

    protected function setUp(): void
    {
        $this->catFactsApiStub = $this->createStub(CatFactsApi::class);

        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->catFactBlock = new CatFact(
            $this->catFactsApiStub,
            $this->contextMock
        );
    }

    /**
     * Test getCatFact() returns a valid fact from the API.
     *
     * @throws \JsonException
     */
    public function testGetCatFactSuccess(): void
    {
        $this->catFactsApiStub->method('getCatFact')
            ->willReturn('Cats are awesome!');

        $this->assertEquals('Cats are awesome!', $this->catFactBlock->getCatFact());
    }

    /**
     * Test getCatFact() handles exceptions.
     *
     * @throws \JsonException
     */
    public function testGetCatFactException(): void
    {
        $this->catFactsApiStub->method('getCatFact')
            ->willThrowException(new \JsonException('API Error'));

        $this->expectException(\JsonException::class);
        $this->expectExceptionMessage('API Error');

        $this->catFactBlock->getCatFact();
    }
}
