<?php

use PHPUnit\Framework\TestCase;
use CleanTalk\Censor;

class CensorTest extends TestCase
{
    private $censor;

    protected function setUp(): void
    {
        $this->censor = new Censor('vi-vietnamese');
    }

    public function testContainsWithCleanText()
    {
        $text = 'Đây là một văn bản bình thường.';
        $this->assertFalse($this->censor->contains($text));
    }

    public function testContainsWithOffensiveText()
    {

        $text = 'Đây là một văn bản có từ tục: ngu .';
        $this->assertTrue($this->censor->contains($text));
    }

    public function testCleanWithOffensiveText()
    {
        $text = 'Đây là một văn bản có từ tục: ngu.';
        $cleaned = $this->censor->clean($text);
        $this->assertStringContainsString('***', $cleaned);
        $this->assertStringNotContainsString('ngu', $cleaned);
    }

    public function testNullWithCleanText()
    {
        $text = 'Đây là một văn bản bình thường.';
        $result = $this->censor->null($text);
        $this->assertEquals($text, $result);
    }

    public function testNullWithOffensiveText()
    {
        $text = 'Đây là một văn bản có từ tục: ngu .';
        $result = $this->censor->null($text);
        $this->assertEquals('', $result);
    }

    public function testAddWord()
    {
        $text = 'Đây là một văn bản có từ mới: testword .';
        $this->assertFalse($this->censor->contains($text));
        
        $this->censor->addWord('testword');
        $this->assertTrue($this->censor->contains($text));
    }

    public function testSetMaskChar()
    {
        $this->censor->setMaskChar('#');
        $text = 'Đây là một văn bản có từ tục: ngu .';
        $cleaned = $this->censor->clean($text);
        $this->assertStringContainsString('###', $cleaned);
    }

    public function testSetStrictMode()
    {
        $this->censor->setStrictMode(true);
        $text = 'Đây là một văn bản có từ tục: ngu .';
        $this->assertTrue($this->censor->contains($text));
    }
} 