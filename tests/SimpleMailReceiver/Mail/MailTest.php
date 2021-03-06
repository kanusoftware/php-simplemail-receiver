<?php
require_once 'PHPUnit/Autoload.php';

use SimpleMailReceiver\Mail\Mail;
use SimpleMailReceiver\Mail\Headers;
use SimpleMailReceiver\Mail\Attachment;
use SimpleMailReceiver\Commons\Collection;

class MailTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Mail
     */
    private $mail;

    /**
     * @var Headers
     */
    private $mailHeader;

    /**
     * @var string
     */
    private $mailBody;

    /**
     * @var Collection
     */
    private $mailAttachments;

    public function setUp()
    {
        $this->mailHeader      = new Headers(array(
            'msgno'   => '125545d4f5d',
            'to'      => 'mavianceTest@gmail.com',
            'from'    => 'Jose Luis Cardosa Manzano <jlcardosa@gmail.com>',
            'reply'   => 'Jose Luis Cardosa Manzano <jlcardosa@gmail.com>',
            'subject' => 'Pruuueba',
            'udate'   => '19586575518',
            'unseen'  => 'U',
            'size'    => '1024'
        ));
        $this->mailBody        = 'Body with attachmentes';
        $this->mailAttachments = new Collection(array(
            new Attachment('prueba1', 'Content of attachment1', 'txt', '1024'),
            new Attachment('prueba2', 'Content of attachment2', 'txt', '2048'),
            new Attachment('prueba3', 'Content of attachment3', 'txt', '4096')
        ));
        $this->mail = new Mail();
        $this->mail->setMailHeader($this->mailHeader);
        $this->mail->setBody($this->mailBody);
        $this->mail->setAttachments($this->mailAttachments);
    }

    public function testGetterAndSetter()
    {
        $this->assertEquals($this->mail->getMailHeader(), $this->mailHeader);
        $this->assertEquals($this->mail->getBody(), $this->mailBody);
        $this->assertEquals($this->mail->getAttachments(), $this->mailAttachments);
        $this->assertEquals($this->mail->getAttachments()->count(), 3);
        $this->assertTrue(is_array($this->mail->getAttachments()->getAll()));
    }

    public function testSearch()
    {
        $this->assertTrue($this->mail->search('Jose Luis Cardosa'));
        $this->assertTrue($this->mail->search('Pruuueba'));
        $this->assertTrue($this->mail->search('Body with att'));
        $this->assertTrue($this->mail->search('prueba1.txt'));
        $this->assertTrue($this->mail->search('txt'));
        $this->assertTrue($this->mail->search('Not found ') == false);
    }

    public function testToArray()
    {
        $this->assertEquals(
            $this->mail->toArray(),
            array(
                "header"     => $this->mailHeader,
                "body"       => $this->mailBody,
                "attachment" => $this->mailAttachments
            )
        );
    }

    public function testToString()
    {
        $this->assertTrue(is_string($this->mail->__toString()));
    }
}
