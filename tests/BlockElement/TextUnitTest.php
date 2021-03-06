<?php
namespace Slack\Tests\BlockElements;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class TextUnitTest extends TestCase
{
    public function testTextFromArray()
    {
        $t = new Text([
            'type' => Text::TYPE_PLAIN,
            'text' => 'Text',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $t->getType());

        $this->assertSame('Text', $t->getText());

        $this->assertFalse($t->getEscapeEmojis());
    }

    public function testEscapeEmojis()
    {
        $t = new Text([
            'type'  => Text::TYPE_PLAIN,
            'text'  => 'Text',
            'emoji' => true,
        ]);

        $this->assertTrue($t->getEscapeEmojis());
    }

    public function testVerbatim()
    {
        $t = new Text([
            'type'     => Text::TYPE_MARKDOWN,
            'text'     => 'Text',
            'verbatim' => true,
        ]);

        $this->assertTrue($t->getVerbatim());
    }

    public function testToArrayPlain()
    {
        $t = new Text([
            'type' => Text::TYPE_PLAIN,
            'text' => 'Text',
        ]);

        $this->assertEquals([
            'type'     => Text::TYPE_PLAIN,
            'text'     => 'Text',
            'emoji'    => false,
        ], $t->toArray());
    }

    public function testToArrayMarkdown()
    {
        $t = new Text([
            'type' => Text::TYPE_MARKDOWN,
            'text' => 'Text',
        ]);

        $this->assertEquals([
            'type'     => Text::TYPE_MARKDOWN,
            'text'     => 'Text',
            'verbatim' => false,
        ], $t->toArray());
    }

    public function testStaticCreateFromString()
    {
        $t = Text::create('Text');

        $this->assertSame(Text::TYPE_PLAIN, $t->getType());

        $this->assertSame('Text', $t->getText());
    }

    public function testStaticCreateFromArray()
    {
        $t = Text::create([
            'type' => Text::TYPE_MARKDOWN,
            'text' => 'Text',
        ]);

        $this->assertSame(Text::TYPE_MARKDOWN, $t->getType());

        $this->assertSame('Text', $t->getText());
    }

    public function testStaticCreateInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text must be a string, keyed array or '.Text::class.' object');
        Text::create(0);
    }

    public function testStaticCreateMismatchType()
    {
        $t = Text::create('Text');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text type must be '.Text::TYPE_MARKDOWN);
        Text::create($t, Text::TYPE_MARKDOWN);
    }
}
