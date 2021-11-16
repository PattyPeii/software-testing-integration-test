<?php
use PHPUnit\Framework\TestCase;

require_once ('_DIR__."/../src/transfer/transfer.php"');
use AccountInformationException;
use Operation\transfer;


class TestTransferStubDepWit extends transfer{

    public function withdraw(string $accNo, string $amount): array 
    {
        $response = [
            'accNo' => $accNo,
            'accName' => 'account name',
            'accBalance' => 1000000 - $amount,
            'isError' => false,
            'message' => '',
        ];
        
        return $response;
    }

    public function deposit(string $accNo, string $amount): array 
    {
        $isError = $amount == 900000;
        $response = [
            'accNo' => $accNo,
            'accName' => 'account name',
            'accBalance' => 1000000 + $amount,
            'isError' => $isError,
            'message' => '',
        ];
        
        return $response;
    }

    
}

class TransferTestStubDepWit_02Test extends TestCase
{
    /**
	* add DataProvider
	*
	* @dataProvider dataProvider
	*
	*/
    public function test($srcAccNo, $srcAccBalance, $targetNumber, $targetAmount, $expected)
	{
        $srcAccName = 'Test Test';
        $transfer = new TestTransferStubDepWit($srcAccNo, $srcAccName);
        $response = $transfer->doTransfer($targetNumber, $targetAmount);
        
        $this->assertSame($expected, $response['message']);
	}

    public function dataProvider() {
		return [
            ['4312531892', 9900900, 'abcdefghij', 100, 'หมายเลขบัญชีต้องเป็นตัวเลขเท่านั้น'], // TC-TF-001

            ['4312531892', 9900900, '1234567890', 'abcd', 'จำนวนเงินต้องเป็นตัวเลขเท่านั้น'], // TC-TF-002

            ['4312531892', 9900900, '01234567890', 100, 'หมายเลขบัญชีต้องมีจำนวน 10 หลัก'], // TC-TF-003

            ['4312531892', 9900900, '1234567890', 0, 'ยอดการโอนต้องมากกว่า 0 บาท'], // TC-TF-004

            ['4312531892', 9900900, '1234567890', 10000000, 'ยอดการโอนต้องไม่มากกว่า 9,999,999 บาท'], // TC-TF-005

            ['4312531892', 9900900, '4312531892', 100, 'ไม่สามารถโอนไปบัญชีตัวเองได้'], // TC-TF-006

            ['4312531892', 9900900, '0000000000', 100, 'Account number : 0000000000 not found.'], // TC-TF-007

            ['4312531892', 9900900, '1234567890', 9999999, 'คุณมียอดเงินในบัญชีไม่เพียงพอ'], // TC-TF-008

            ['4312531892', 9900900, '7234153321', 900000, 'ดำเนินการไม่สำเร็จ'], // TC-TF-009

            ['4312531892', 9900900, '1234567890', 100, ''], // TC-TF-010
        ];
	}
  
}